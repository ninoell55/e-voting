<?php
require_once '../../../config/connection.php';
$pageTitle = "Pilih Event";

// Ambil filter dari query string
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'semua';

// Query berdasarkan filter
if ($filter === 'aktif') {
    $events = query("SELECT * FROM event WHERE status = 'aktif' ORDER BY tgl_mulai DESC");
} else {
    $events = query("SELECT * FROM event ORDER BY tgl_mulai DESC");
}

include '../../../includes/header.php';
include '../../../includes/sidebar.php';
?>

<main class="flex-1 p-6 mt-16 md:ml-64 bg-gray-50 min-h-screen">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 mb-1">Pilih Event</h1>
            <p class="text-gray-600">Klik salah satu event untuk melihat daftar kandidat dan statistik suara.</p>
        </div>
        <form method="GET">
            <select name="filter" onchange="this.form.submit()" class="border border-gray-300 rounded-md px-3 py-2 text-sm">
                <option value="semua" <?= $filter === 'semua' ? 'selected' : '' ?>>Semua Event</option>
                <option value="aktif" <?= $filter === 'aktif' ? 'selected' : '' ?>>Event Aktif Saja</option>
            </select>
        </form>
    </div>

    <?php if (empty($events)) : ?>
        <div class="text-gray-600">Tidak ada event yang sesuai dengan filter.</div>
    <?php else : ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            <?php foreach ($events as $event) : ?>
                <a href="daftar_kandidat.php?id=<?= $event['id_event']; ?>"
                    class="block p-4 bg-white rounded-xl shadow hover:shadow-lg transition duration-200">
                    <h2 class="text-lg font-semibold text-gray-800"><?= htmlspecialchars($event['nama_event']); ?></h2>
                    <p class="text-sm text-gray-500">Tanggal: <?= $event['tgl_mulai']; ?> s/d <?= $event['tgl_selesai']; ?></p>
                    <span class="inline-block mt-2 px-2 py-1 text-xs rounded-full 
                        <?= $event['status'] === 'aktif' ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800'; ?>">
                        <?= ucfirst($event['status']); ?>
                    </span>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>

<?php include '../../../includes/footer.php'; ?>