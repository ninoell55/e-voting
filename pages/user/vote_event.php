<?php
require_once '../../config/connection.php';

$id_pemilih = $_SESSION['id_pemilih'] ?? null;
if (!$id_pemilih) {
    header("Location: ../../auth/login_user.php");
    exit;
}

// Ambil semua event yang aktif
$eventList = query("SELECT * FROM event WHERE status = 'aktif'");

include '../../includes/header.php';
?>

<main class="min-h-screen mt-16 bg-gradient-to-br from-sky-300 via-white to-purple-200 p-6 md:p-10">
    <div class="animate__animated animate__fadeIn animate__faster max-w-6xl mx-auto bg-white rounded-3xl shadow-2xl p-8 transition-all duration-300">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <h1 class="animate__animated animate__fadeInLeft text-xl sm:text-3xl font-bold text-indigo-800 tracking-tight">Pilih Event Voting</h1>
            <a href="index.php" class="animate__animated animate__fadeInRight inline-flex items-center gap-2 bg-indigo-100 hover:bg-indigo-200 text-indigo-700 px-5 py-2 rounded-xl shadow-md font-semibold transition duration-300">
                <i data-lucide="arrow-left" class="w-6 h-6"></i>
                Kembali ke Dashboard
            </a>
        </div>

        <?php if (empty($eventList)) : ?>
            <div class="animate__animated animate__tada text-center py-12">
                <p class="text-xl font-medium text-gray-500">Tidak ada event aktif saat ini.</p>
            </div>
        <?php else : ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($eventList as $event) : ?>
                    <?php
                    $id_event = $event['id_event'];
                    $cek = query("SELECT 1 FROM pilih WHERE id_event = $id_event AND id_pemilih = $id_pemilih");
                    $sudahMemilih = count($cek) > 0;
                    ?>
                    <div class="animate__animated animate__flipInX group relative border border-indigo-300 hover:shadow-xl hover:-translate-y-1 transition-all bg-indigo-50 hover:bg-white rounded-2xl p-6 text-center">

                        <!-- Badge Sudah Memilih -->
                        <?php if ($sudahMemilih): ?>
                            <div class="animate__animated animate__fadeInDownBig absolute top-2 right-2 bg-green-100 text-green-700 text-xs font-semibold px-2 py-1 rounded-full flex items-center gap-1">
                                <i data-lucide="check-circle" class="w-4 h-4"></i> Sudah Memilih
                            </div>
                        <?php endif; ?>

                        <div class="flex justify-center mb-3">
                            <div class="bg-indigo-100 p-3 rounded-full shadow-md">
                                <i data-lucide="calendar-check" class="w-6 h-6 text-indigo-600 group-hover:scale-110 transition"></i>
                            </div>
                        </div>

                        <h2 class="text-xl font-semibold text-indigo-700 group-hover:text-indigo-900 transition">
                            <?= htmlspecialchars($event['nama_event']) ?>
                        </h2>

                        <p class="text-sm text-gray-500 mt-1 italic">
                            <?= date("d M Y", strtotime($event['tgl_mulai'])) ?> – <?= date("d M Y", strtotime($event['tgl_selesai'])) ?>
                        </p>

                        <a href="<?= $sudahMemilih ? "lihat_pilihan.php?id_event=$id_event" : "vote.php?id=$id_event" ?>"
                            class="animate__animated animate__jello inline-flex items-center justify-center gap-2 mt-5 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-xl shadow-md font-medium text-sm transition">
                            <i data-lucide="<?= $sudahMemilih ? 'eye' : 'check-square' ?>" class="w-5 h-5"></i>
                            <?= $sudahMemilih ? "Lihat Pilihan" : "Pilih Kandidat" ?>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php include '../../includes/footer.php'; ?>