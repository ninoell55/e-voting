<?php
require_once '../../../config/connection.php';
$pageTitle = "Detail Event";

$id_event = $_GET["id"];

$event = query("SELECT * FROM event WHERE id_event = $id_event")[0];
$kandidat = query("SELECT * FROM kandidat WHERE id_event = $id_event");

include '../../../includes/header.php';
include '../../../includes/sidebar.php';
?>

<main id="mainContent" class="flex-1 bg-gray-100 p-6 mt-16 transition-all duration-300 ml-64">

    <div class="mb-6">
        <nav class="text-gray-500 text-sm mb-1">
            <ol class="list-reset flex">
                <li><a href="#" class="text-blue-600 hover:underline">Pages</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-800"><?= $pageTitle ?></li>
            </ol>
        </nav>
        <h1 class="text-2xl font-bold text-gray-800"><?= $pageTitle ?></h1>
    </div>

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Kandidat - <?= htmlspecialchars($event['nama_event']) ?></h1>
        <p class="text-gray-600 mb-4">Periode: <?= $event['tgl_mulai'] ?> s/d <?= $event['tgl_selesai'] ?></p>
    </div>

    <?php if (empty($kandidat)) : ?>
        <div class="text-gray-600">Belum ada kandidat untuk event ini.</div>
    <?php else : ?>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($kandidat as $k) : ?>
                <div class="bg-indigo-50 hover:bg-indigo-100 rounded-xl shadow-md p-6 text-center transition">
                    <a href="<?= $base_url ?>/assets/img/<?= htmlspecialchars($k['gambar']) ?>" data-lightbox="candidate" data-title="<?= htmlspecialchars($k['nama_kandidat']) ?>">
                        <img src="<?= $base_url ?>/assets/img/<?= htmlspecialchars($k['gambar']) ?>" alt="<?= htmlspecialchars($k['nama_kandidat']) ?>" class="w-32 h-32 object-cover rounded-full mx-auto border-4 border-white shadow mb-4 cursor-pointer">
                    </a>
                    <h2 class="text-lg font-bold text-indigo-700"><?= htmlspecialchars($k['nama_kandidat']) ?></h2>
                    <p class="text-sm text-gray-600 mb-4"><?= htmlspecialchars($k['keterangan']) ?></p>

                    <!-- Tombol disabled tapi tetap terlihat -->
                    <span
                        class="inline-block mt-2 bg-indigo-300 text-white px-4 py-2 rounded shadow text-sm font-medium opacity-80 cursor-not-allowed"
                        title="Kamu tidak bisa memilih sekarang">
                        Pilih
                    </span>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <a href="daftar_event.php" class="inline-block mt-6 text-blue-600 hover:underline text-sm">&larr; Kembali ke Event</a>
</main>

<?php include '../../../includes/footer.php' ?>