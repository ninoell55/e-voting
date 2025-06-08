<?php
require_once '../../../config/connection.php';
$pageTitle = "Kandidat";

// Ambil semua kandidat & total suara per kandidat
$kandidat = query("
    SELECT k.*, 
           (SELECT COUNT(*) FROM pilih p WHERE p.id_kandidat = k.id_kandidat) AS jumlah_suara,
           e.nama_event, e.tgl_mulai, e.tgl_selesai
    FROM kandidat k
    LEFT JOIN event e ON k.id_event = e.id_event
");

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

    <div class="flex flex-col gap-4 mb-6 sm:flex-row sm:items-start sm:justify-between">
        <div class="text-center sm:text-left">
            <h1 class="text-2xl font-bold text-gray-800">Daftar Semua Kandidat</h1>
            <p class="text-sm text-gray-600">Berikut adalah daftar seluruh kandidat dari semua event yang pernah dibuat.</p>
        </div>
        <div class="w-full sm:w-auto">
            <a href="tambah_kandidat.php"
                class="inline-flex items-center justify-center w-full gap-2 px-4 py-2 text-sm text-white transition bg-blue-600 rounded-md shadow hover:bg-blue-700">
                <i data-lucide="plus-circle" class="w-4 h-4"></i>
                Tambah Kandidat
            </a>
        </div>
    </div>


    <?php if (empty($kandidat)) : ?>
        <div class="text-gray-600">Belum ada kandidat yang ditambahkan.</div>
    <?php else : ?>
        <table id="dataTables"
            class="min-w-full overflow-x-auto text-sm text-gray-800 border border-gray-200 rounded-lg display responsive nowrap">
            <thead>
                <tr class="text-sm font-semibold text-left text-gray-700 bg-gray-100">
                    <th class="px-4 py-2 text-left">No</th>
                    <th class="px-4 py-2 text-left">Event</th>
                    <th class="px-4 py-2 text-left">Kode Kandidat</th>
                    <th class="px-4 py-2 text-left">Nama Kandidat</th>
                    <th class="px-4 py-2 text-left">Keterangan</th>
                    <th class="px-4 py-2 text-left">Jumlah Suara</th>
                    <th class="px-4 py-2 text-left">Gambar</th>
                    <th class="px-4 py-2 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                foreach ($kandidat as $k) : ?>
                    <tr class="border-b">
                        <td class="px-4 py-2"><?= $no++ ?></td>
                        <td class="px-4 py-2"><?= htmlspecialchars($k['nama_event']) ?><br><span class="text-xs text-gray-500"><?= $k['tgl_mulai'] ?> s/d <?= $k['tgl_selesai'] ?></span></td>
                        <td class="px-4 py-2"><?= htmlspecialchars($k['kode_kandidat']) ?></td>
                        <td class="px-4 py-2"><?= htmlspecialchars($k['nama_kandidat']) ?></td>
                        <td class="px-4 py-2 whitespace-pre-line"><?= htmlspecialchars($k['keterangan']) ?></td>
                        <td class="px-4 py-2"><?= $k['jumlah_suara'] ?></td>
                        <td class="px-4 py-2">
                            <?php if ($k['gambar']) : ?>
                                <img src="../../../assets/img/<?= $k['gambar'] ?>" alt="gambar" class="object-cover w-12 h-12 rounded-md">
                            <?php else : ?>
                                <span class="text-xs text-gray-400">Tidak ada</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-4 py-2 space-x-1">
                            <a href="detail_kandidat.php?id=<?= $k['id_kandidat'] ?>" class="text-yellow-600 hover:text-yellow-800"><i data-lucide="eye"
                                    class="inline w-4 h-4"></i></a>
                            <a href="edit_kandidat.php?id=<?= $k['id_kandidat'] ?>" class="text-blue-600 hover:text-blue-800"><i data-lucide="edit"
                                    class="inline w-4 h-4"></i></a>
                            <a href="hapus_kandidat.php?id=<?= $k['id_kandidat'] ?>" class="text-red-600 hover:text-red-800 btn-hapus" data-id="<?= $k['id_kandidat']; ?>"><i data-lucide="trash-2"
                                    class="inline w-4 h-4"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</main>


<?php include '../../../includes/footer.php'; ?>