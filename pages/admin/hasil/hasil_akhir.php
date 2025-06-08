<?php
require_once '../../../config/connection.php';
$pageTitle = "Hasil Akhir";

date_default_timezone_set('Asia/Jakarta');
$today = date('Y-m-d');

$eventsQuery = mysqli_query($conn, "SELECT * FROM event WHERE DATE(tgl_selesai) = '$today'");

include '../../../includes/header.php';
include '../../../includes/sidebar.php';
?>

<main id="mainContent" class="flex-1 bg-gray-100 p-6 mt-16 transition-all duration-300 ml-64">

    <nav class="text-gray-500 text-sm">
        <ol class="list-reset flex flex-wrap items-center">
            <li><a href="#" class="text-blue-600 hover:underline">Pages</a></li>
            <li><span class="mx-2">/</span></li>
            <li class="text-gray-800"><?= $pageTitle ?></li>
        </ol>
        <h1 class="text-2xl font-bold text-gray-800 mt-1"><?= $pageTitle ?></h1>
    </nav>

    <div class="p-4 md:p-6 rounded-xl shadow-inner bg-white/80 backdrop-blur-lg mt-5">

        <h1 class="text-2xl font-bold text-gray-800 mb-8 border-b pb-3">Hasil Akhir Pemilihan Suara</h1>

        <?php if (mysqli_num_rows($eventsQuery) > 0): ?>
            <?php while ($event = mysqli_fetch_assoc($eventsQuery)): ?>
                <?php
                $eventId = $event['id_event'];
                $eventName = $event['nama_event'];

                $kandidatQuery = mysqli_query($conn, "
                    SELECT kandidat.id_kandidat, kandidat.nama_kandidat, COUNT(pilih.id_kandidat) AS total_suara
                    FROM kandidat
                    LEFT JOIN pilih ON kandidat.id_kandidat = pilih.id_kandidat
                    WHERE kandidat.id_event = $eventId
                    GROUP BY kandidat.id_kandidat
                    ORDER BY kandidat.id_kandidat ASC
                ");

                $pemenang = null;
                $suaraTertinggi = -1;
                $kandidatList = [];

                while ($row = mysqli_fetch_assoc($kandidatQuery)) {
                    $kandidatList[] = $row;
                    if ($row['total_suara'] > $suaraTertinggi) {
                        $pemenang = $row;
                        $suaraTertinggi = $row['total_suara'];
                    }
                }
                ?>

                <div class="bg-white border border-indigo-200 rounded-2xl p-6 mb-10 shadow-lg">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-2">
                            <i data-lucide="bar-chart-2" class="w-6 h-6 text-indigo-600"></i>
                            <h2 class="text-xl sm:text-2xl font-semibold text-indigo-700">
                                Hasil Suara - <?= htmlspecialchars($eventName) ?>
                            </h2>
                        </div>
                    </div>

                    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        <?php foreach ($kandidatList as $i => $k): ?>
                            <?php $isPemenang = $pemenang && $pemenang['id_kandidat'] == $k['id_kandidat']; ?>
                            <div class="relative bg-gradient-to-br from-indigo-50 to-white border rounded-xl p-5 shadow hover:shadow-xl transition-all duration-300">
                                <?php if ($isPemenang): ?>
                                    <div class="absolute top-3 right-3 bg-emerald-500 text-white text-xs px-3 py-1 rounded-full flex items-center gap-1 shadow-md">
                                        <i data-lucide="award" class="w-4 h-4"></i>
                                        Pemenang
                                    </div>
                                <?php endif; ?>
                                <div class="mb-3">
                                    <div class="text-sm text-gray-500">Nomor Urut</div>
                                    <div class="text-lg font-semibold text-gray-800"><?= $i + 1 ?></div>
                                </div>
                                <div class="mb-3">
                                    <div class="text-sm text-gray-500">Nama Kandidat</div>
                                    <div class="text-lg font-bold text-indigo-800"><?= htmlspecialchars($k['nama_kandidat']) ?></div>
                                </div>
                                <div class="mt-4">
                                    <div class="text-sm text-gray-500">Total Suara</div>
                                    <div class="text-2xl font-bold text-indigo-600"><?= $k['total_suara'] ?></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <?php if ($pemenang): ?>
                        <div class="mt-6 px-6 py-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-900 rounded-xl shadow flex items-center gap-3">
                            <i data-lucide="award" class="w-6 h-6 text-emerald-600"></i>
                            <div>
                                <div class="text-sm sm:text-base font-semibold">Pemenang:</div>
                                <span class="inline-block mt-1 bg-emerald-200 text-emerald-900 text-sm sm:text-base font-semibold px-3 py-1 rounded-full shadow">
                                    <?= htmlspecialchars($pemenang['nama_kandidat']) ?> (<?= $pemenang['total_suara'] ?> suara)
                                </span>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

            <?php endwhile; ?>
        <?php else: ?>
            <div class="flex items-center gap-3 bg-yellow-100 text-yellow-800 p-4 rounded-md text-sm font-medium">
                <i data-lucide="alert-circle" class="w-5 h-5 text-yellow-600"></i>
                Tidak ada event yang berakhir hari ini.
            </div>
        <?php endif; ?>
    </div>
</main>

<?php include '../../../includes/footer.php'; ?>