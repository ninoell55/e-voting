<?php
require_once '../../../config/connection.php';
$pageTitle = "Event";

updateEventStatus();

$event = query("SELECT * FROM event ORDER BY tgl_mulai DESC");

include '../../../includes/header.php';
include '../../../includes/sidebar.php';
?>

<main class="flex-1 p-6 mt-16 md:ml-64 bg-gray-50 min-h-screen">

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


    <!-- Tampilkan Pesan Sukses -->
    <?php showSuccessAlert(); ?>

    <!-- Kartu event yang sedang aktif -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
        <?php
        $adaAktif = false;
        foreach ($event as $e) :
            if ($e["status"] === 'aktif') :
                $adaAktif = true;
        ?>
                <div class="bg-blue-100 border border-blue-500 rounded-2xl p-5 shadow hover:shadow-lg transition duration-300 transform hover:-translate-y-1">
                    <div class="mb-3">
                        <h3 class="text-xl font-bold text-blue-700"><?= htmlspecialchars($e['nama_event']) ?></h3>
                        <p class="text-sm text-gray-600 mt-1">
                            <?= $e['tgl_mulai']; ?> &mdash; <?= $e['tgl_selesai']; ?>
                        </p>
                    </div>
                    <div class="flex items-center justify-between mt-4">
                        <span class="px-3 py-1 text-xs bg-blue-600 text-white rounded-full">Sedang Berlangsung</span>
                        <a href="view_event.php?id=<?= $e['id_event']; ?>"
                            class="inline-flex items-center gap-1 text-sm text-blue-600 hover:text-blue-800 font-medium">
                            <i data-lucide="eye" class="w-4 h-4"></i> View
                        </a>
                    </div>
                </div>
        <?php
            endif;
        endforeach;
        ?>

        <?php if (!$adaAktif): ?>
            <div class="col-span-full text-center p-6 bg-gray-100 border border-gray-300 rounded-xl">
                <p class="text-gray-600 text-base">Belum ada event yang sedang berlangsung saat ini.</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Daftar event yang pernah ada -->
    <div class="max-w-full w-full bg-white shadow-lg rounded-xl p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-semibold text-gray-700">📋 Daftar Event</h2>
            <a href="tambah_event.php"
                class="flex items-center gap-1 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                <i data-lucide="plus-circle" class="w-4 h-4"></i> Tambah Event
            </a>
        </div>

        <div class="">
            <table id="dataTables"
                class="overflow-x-auto min-w-full text-sm text-gray-800 border border-gray-200 rounded-lg display responsive nowrap">
                <thead>
                    <tr class="bg-gray-100 text-gray-700 font-semibold text-left text-sm">
                        <th class="px-6 py-3">No</th>
                        <th class="px-6 py-3">Event</th>
                        <th class="px-6 py-3">Tanggal Mulai</th>
                        <th class="px-6 py-3">Tanggal Selesai</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1 ?>
                    <?php foreach ($event as $row): ?>
                        <tr class="hover:bg-gray-100 transition">
                            <td class="px-6 py-4"><?= $i ?></td>
                            <td class="px-6 py-4"><?= $row['nama_event']; ?></td>
                            <td class="px-6 py-4"><?= $row['tgl_mulai']; ?></td>
                            <td class="px-6 py-4"><?= $row['tgl_selesai']; ?></td>
                            <td class="px-6 py-4">
                                <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold
                                    <?= $row['status'] === 'aktif' ? 'bg-green-200 text-green-800 uppercase' : 'bg-red-200 text-red-800'; ?>">
                                    <?= $row['status']; ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 space-x-2">
                                <a href="view_event.php?id=<?= $row['id_event']; ?>" class="text-yellow-600 hover:text-yellow-800"><i data-lucide="eye"
                                        class="w-4 h-4 inline"></i></a>
                                <a href="edit_event.php?id=<?= $row['id_event']; ?>" class="text-blue-600 hover:text-blue-800"><i data-lucide="edit"
                                        class="w-4 h-4 inline"></i></a>
                                <a href="hapus_event.php?id=<?= $row['id_event']; ?>" class="text-red-600 hover:text-red-800" onclick="return confirm('yakin?')"><i data-lucide="trash-2"
                                        class="w-4 h-4 inline"></i></a>
                            </td>
                        </tr>
                        <?php $i++ ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</main>

<?php include '../../../includes/footer.php'; ?>