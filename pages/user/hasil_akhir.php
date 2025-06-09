<?php
require_once '../../config/connection.php';

$id_pemilih = $_SESSION['id_pemilih'] ?? null;
if (!$id_pemilih) {
    header("Location: ../../auth/login_user.php");
    exit;
}

// Ambil tanggal hari ini
date_default_timezone_set('Asia/Jakarta');
$today = date('Y-m-d');

// Ambil semua event yang selesai hari ini
$events = query("SELECT * FROM event WHERE DATE(tgl_selesai) = '$today' ORDER BY tgl_mulai");

// Fungsi untuk hitung suara per kandidat pada event tertentu
function getSuaraPerKandidat($id_event)
{
    return query("SELECT k.id_kandidat, k.kode_kandidat, k.nama_kandidat, COUNT(p.id) AS total_suara
                  FROM kandidat k
                  LEFT JOIN pilih p ON k.id_kandidat = p.id_kandidat AND p.id_event = $id_event
                  WHERE k.id_event = $id_event
                  GROUP BY k.id_kandidat
                  ORDER BY total_suara DESC, k.kode_kandidat ASC");
}

// Fungsi untuk cari pemenang (suara terbanyak)
function getPemenang($hasilSuara)
{
    $max = 0;
    foreach ($hasilSuara as $h) {
        if ($h['total_suara'] > $max) {
            $max = $h['total_suara'];
        }
    }
    // Bisa lebih dari satu pemenang kalau seri
    return array_filter($hasilSuara, fn($h) => $h['total_suara'] == $max);
}

include '../../includes/header.php';
?>

<main class="min-h-screen pt-20 bg-gradient-to-br from-blue-200 via-white to-purple-200 px-4 sm:px-6 md:px-10 pb-16">
    <div class="animate__animated animate__fadeIn animate__faster max-w-6xl mx-auto bg-white/80 backdrop-blur-md rounded-3xl shadow-2xl p-6 sm:p-10">
        <h1 class="animate__animated animate__jackInTheBox text-2xl sm:text-3xl font-extrabold text-center text-indigo-800 mb-10">
            Hasil Akhir Voting Hari Ini
            <div class="mt-1 text-sm font-medium text-gray-500"><?= date('d M Y', strtotime($today)) ?></div>
        </h1>

        <?php if (empty($events)) : ?>
            <div class="animate__animated animate__tada text-center text-gray-600 text-lg font-semibold py-24">
                Belum ada event yang selesai hari ini.
            </div>
        <?php else : ?>
            <?php foreach ($events as $event) :
                $hasilSuara = getSuaraPerKandidat($event['id_event']);
                $pemenang = getPemenang($hasilSuara);
                $pemenangIds = array_map(fn($p) => $p['id_kandidat'], $pemenang);
            ?>
                <section class="mb-14">
                    <h2 class="animate__animated animate__lightSpeedInLeft text-xl sm:text-2xl font-bold text-indigo-700 mb-6">
                        Event: <span class="italic"><?= htmlspecialchars($event['nama_event']) ?></span>
                    </h2>

                    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        <?php foreach ($hasilSuara as $row) : ?>
                            <?php
                            $isWinner = in_array($row['id_kandidat'], $pemenangIds);
                            ?>
                            <div class="animate__animated animate__flipInX relative bg-white border <?= $isWinner ? 'border-emerald-500' : 'border-indigo-200' ?> rounded-xl shadow-lg p-5 pt-10 flex flex-col justify-between hover:shadow-xl transition duration-300">
                                <?php if ($isWinner) : ?>
                                    <div class="animate__animated animate__fadeInDownBig absolute top-3 right-3 bg-emerald-500 text-white text-xs px-3 py-1 rounded-full shadow flex items-center gap-1">
                                        <i data-lucide="award" class="w-4 h-4"></i> Pemenang
                                    </div>
                                <?php endif; ?>

                                <div>
                                    <h3 class="animate__animated animate__slideInDown animate__slow text-lg font-bold text-indigo-800 mb-2"><?= htmlspecialchars($row['nama_kandidat']) ?></h3>
                                    <p class="animate__animated animate__slideInUp animate__slow text-sm text-gray-600 mb-1">No Urut: <span class="font-medium"><?= htmlspecialchars(substr($row['kode_kandidat'], -2)) ?></span></p>
                                </div>

                                <div class="mt-4 text-right">
                                    <div class="animate__animated animate__slideInLeft text-sm text-gray-500">Total Suara</div>
                                    <div class="animate__animated animate__slideInLeft text-2xl font-bold text-indigo-700"><?= $row['total_suara'] ?></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="animate__animated animate__zoomIn mt-6 px-6 py-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-900 rounded-xl shadow flex items-center gap-3">
                        <i data-lucide="award" class="animate__animated animate__tada animate__slower w-6 h-6 text-emerald-600"></i>
                        <div>
                            <div class="animate__animated animate__fadeInDown animate__slow text-sm sm:text-base font-semibold">Pemenang:</div>
                            <?php foreach ($pemenang as $p) : ?>
                                <span class="animate__animated animate__lightSpeedInRight inline-block mt-1 bg-emerald-200 text-emerald-900 text-sm sm:text-base font-semibold px-3 py-1 rounded-full shadow">
                                    <?= htmlspecialchars($p['nama_kandidat']) ?> (<?= $p['total_suara'] ?> suara)
                                </span>
                            <?php endforeach; ?>
                        </div>
                    </div>

                </section>
            <?php endforeach; ?>
        <?php endif; ?>

        <div class="mt-10 text-center sm:text-right">
            <a href="index.php" class="animate__animated animate__fadeInRight inline-flex items-center gap-2 bg-indigo-100 hover:bg-indigo-200 text-indigo-700 px-5 py-2 rounded-xl shadow-md font-semibold transition duration-300">
                <i data-lucide="arrow-left" class="w-6 h-6"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>
</main>

<?php include '../../includes/footer.php'; ?>