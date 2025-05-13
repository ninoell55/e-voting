<?php
require_once '../../../config/connection.php';
$pageTitle = "Pemilih";

$pemilih = query("SELECT * FROM pemilih ORDER BY id_pemilih DESC");

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

    <!-- Daftar Pemilih -->
    <div class="max-w-full w-full bg-white shadow-lg rounded-xl p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-semibold text-gray-700">📋 Daftar Pemilih</h2>
            <a href="tambah_pemilih.php"
                class="flex items-center gap-1 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                <i data-lucide="plus-circle" class="w-4 h-4"></i> Tambah Pemilih
            </a>
        </div>

        <div class="">
            <table id="dataTables"
                class="overflow-x-auto min-w-full text-sm text-gray-800 border border-gray-200 rounded-lg display responsive nowrap">
                <thead>
                    <tr class="bg-gray-100 text-gray-700 font-semibold text-left text-sm">
                        <th class="px-6 py-3">No</th>
                        <th class="px-6 py-3">NISN</th>
                        <th class="px-6 py-3">Username</th>
                        <th class="px-6 py-3">Nama Lengkap</th>
                        <th class="px-6 py-3">Kelas</th>
                        <th class="px-6 py-3">Gender</th>
                        <!-- <th class="px-6 py-3">Status</th> -->
                        <th class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1 ?>
                    <?php foreach ($pemilih as $row): ?>
                        <tr class="hover:bg-gray-100 transition">
                            <td class="px-6 py-4"><?= $i ?></td>
                            <td class="px-6 py-4"><?= $row['password']; ?></td>
                            <td class="px-6 py-4"><?= $row['username']; ?></td>
                            <td class="px-6 py-4"><?= $row['nama_lengkap']; ?></td>
                            <td class="px-6 py-4"><?= $row['kelas']; ?></td>
                            <td class="px-6 py-4"><?= $row['gender']; ?></td>
                            <!-- <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center px-2 py-1 text-xs font-medium text-green-700 bg-green-100 rounded-full">
                                    Sudah Memilih
                                </span>
                            </td> -->
                            <td class="px-6 py-4 space-x-2">
                                <a href="edit_pemilih.php?id=<?= $row['id_pemilih']; ?>" class="text-blue-600 hover:text-blue-800"><i data-lucide="edit"
                                        class="w-4 h-4 inline"></i></a>
                                <a href="hapus_pemilih.php?id=<?= $row['id_pemilih']; ?>" class="text-red-600 hover:text-red-800"><i data-lucide="trash-2"
                                        class="w-4 h-4 inline" onclick="return confirm('yakin?')"></i></a>
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