<?php
require_once '../../../config/connection.php';
$pageTitle = "Event";

updateEventStatus();

$event = query("SELECT * FROM event ORDER BY tgl_mulai DESC");

include '../../../includes/header.php';
include '../../../includes/sidebar.php';
?>

<main id="mainContent" class="flex-1 p-6 mt-16 ml-64 transition-all duration-300 bg-gray-100">

    <div class="mb-6">
        <nav class="mb-1 text-sm text-gray-500">
            <ol class="flex list-reset">
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
    <div class="grid grid-cols-1 gap-6 mb-6 md:grid-cols-2 lg:grid-cols-3">
        <?php
        $adaAktif = false;
        foreach ($event as $e) :
            if ($e["status"] === 'aktif') :
                $adaAktif = true;
        ?>
                <div class="p-5 transition duration-300 transform bg-blue-100 border border-blue-500 shadow rounded-2xl hover:shadow-lg hover:-translate-y-1">
                    <div class="mb-3">
                        <h3 class="text-xl font-bold text-blue-700"><?= htmlspecialchars($e['nama_event']) ?></h3>
                        <p class="mt-1 text-sm text-gray-600">
                            <?= $e['tgl_mulai']; ?> &mdash; <?= $e['tgl_selesai']; ?>
                        </p>
                    </div>
                    <div class="flex items-center justify-between mt-4">
                        <span class="px-3 py-1 text-xs text-white bg-blue-600 rounded-full">Sedang Berlangsung</span>
                        <a href="view_event.php?id=<?= $e['id_event']; ?>"
                            class="inline-flex items-center gap-1 text-sm font-medium text-blue-600 hover:text-blue-800">
                            <i data-lucide="eye" class="w-4 h-4"></i> View
                        </a>
                    </div>
                </div>
        <?php
            endif;
        endforeach;
        ?>

        <?php if (!$adaAktif): ?>
            <div class="p-6 text-center bg-gray-100 border border-gray-300 col-span-full rounded-xl">
                <p class="text-base text-gray-600">Belum ada event yang sedang berlangsung saat ini.</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Daftar event yang pernah ada -->
    <div class="w-full max-w-full p-6 bg-white shadow-lg rounded-xl">
        <div class="flex flex-col items-center gap-3 mb-4 text-center sm:flex-row sm:items-center sm:justify-between sm:text-left">
            <h2 class="flex items-center gap-2 text-2xl font-semibold text-gray-700">
                <i data-lucide="clipboard-list" class="w-6 h-6"></i>
                <span>Daftar Event</span>
            </h2>
            <a href="tambah_event.php"
                class="flex items-center justify-center w-full gap-2 px-4 py-2 text-sm font-medium text-white transition bg-blue-600 rounded-lg hover:bg-blue-700 sm:w-auto">
                <i data-lucide="plus-circle" class="w-5 h-5"></i> Tambah Event
            </a>
        </div>

        <div class="">
            <table id="dataTables"
                class="min-w-full overflow-x-auto text-sm text-gray-800 border border-gray-200 rounded-lg display responsive nowrap">
                <thead>
                    <tr class="text-sm font-semibold text-left text-gray-700 bg-gray-100">
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
                        <tr class="transition hover:bg-gray-100">
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
                                        class="inline w-4 h-4"></i></a>
                                <a href="edit_event.php?id=<?= $row['id_event']; ?>" class="text-blue-600 hover:text-blue-800"><i data-lucide="edit"
                                        class="inline w-4 h-4"></i></a>
                                <a href="hapus_event.php?id=<?= $row['id_event']; ?>" class="text-red-600 hover:text-red-800 btn-hapus" data-id="<?= $row['id_event']; ?>"><i data-lucide="trash-2"
                                        class="inline w-4 h-4"></i></a>
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