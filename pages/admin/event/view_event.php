<?php
require_once '../../../config/connection.php';
$pageTitle = "Detail Event";

$id_event = $_GET["id"];
$event = query("SELECT * FROM event WHERE id_event = $id_event")[0];
$kandidat = query("SELECT * FROM kandidat WHERE id_event = $id_event");

include '../../../includes/header.php';
include '../../../includes/sidebar.php';
?>

<main class="flex-1 p-6 mt-16 md:ml-64 bg-gray-50 min-h-screen">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Kandidat - <?= htmlspecialchars($event['nama_event']) ?></h1>
        <p class="text-gray-600 mb-4">Periode: <?= $event['tgl_mulai'] ?> s/d <?= $event['tgl_selesai'] ?></p>
    </div>

    <?php if (empty($kandidat)) : ?>
        <div class="text-gray-600">Belum ada kandidat untuk event ini.</div>
    <?php else : ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($kandidat as $k) : ?>
                <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition duration-300 ease-in-out p-4">
                    <?php if ($k['gambar']) : ?>
                        <img src="../../../assets/img/<?= $k['gambar'] ?>" alt="<?= $k['nama_kandidat'] ?>" class="w-full h-48 object-cover rounded-md mb-4">
                    <?php endif; ?>
                    <h2 class="text-xl font-semibold text-gray-800"><?= htmlspecialchars($k['nama_kandidat']) ?></h2>
                    <p class="text-gray-600 text-sm mt-2 whitespace-pre-line"><?= htmlspecialchars($k['keterangan']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>

<?php include '../../../includes/footer.php' ?>                                         