<?php
require_once '../../../config/connection.php';
$pageTitle = "Admin";

// Cek login session admin
if (!isset($_SESSION['login_admin'])) {
    header("Location: ../../../auth/login_admin.php");
    exit;
}

$admin = query("SELECT * FROM admin ORDER BY id_admin DESC");

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

    <!-- Daftar Admin -->
    <div class="w-full max-w-full p-6 bg-white shadow-lg rounded-xl">
        <div class="flex flex-col items-center gap-3 mb-4 text-center sm:flex-row sm:items-center sm:justify-between sm:text-left">
            <h2 class="flex items-center gap-2 text-2xl font-semibold text-gray-700">
                <i data-lucide="clipboard-list" class="w-6 h-6"></i>
                <span>Daftar Admin</span>
            </h2>
            <a href="tambah_admin.php"
                class="flex items-center justify-center w-full gap-2 px-4 py-2 text-sm font-medium text-white transition bg-blue-600 rounded-lg hover:bg-blue-700 sm:w-auto">
                <i data-lucide="plus-circle" class="w-5 h-5"></i> Tambah Admin
            </a>
        </div>

        <div class="">
            <table id="dataTables"
                class="min-w-full overflow-x-auto text-sm text-gray-800 border border-gray-200 rounded-lg display responsive nowrap">
                <thead>
                    <tr class="text-sm font-semibold text-left text-gray-700 bg-gray-100">
                        <th class="px-6 py-3">No</th>
                        <th class="px-6 py-3">Username</th>
                        <th class="px-6 py-3">Password</th>
                        <th class="px-6 py-3">Role</th>
                        <th class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1;
                    foreach ($admin as $row): ?>
                        <tr class="transition hover:bg-gray-100">
                            <td class="px-6 py-4"><?= $i++ ?></td>
                            <td class="px-6 py-4"><?= $row['username']; ?></td>
                            <td class="px-6 py-4"><?= $row['password']; ?></td>
                            <td class="px-6 py-4"><?= $row['role']; ?></td>
                            <td class="px-6 py-4 space-x-2">
                                <a href="edit_admin.php?id=<?= $row['id_admin']; ?>" class="text-blue-600 hover:text-blue-800"><i data-lucide="edit"
                                        class="inline w-4 h-4"></i></a>
                                <a href="hapus_admin.php?id=<?= $row['id_admin']; ?>" class="text-red-600 hover:text-red-800 btn-hapus" data-id="<?= $row['id_admin']; ?>"><i data-lucide="trash-2"
                                        class="inline w-4 h-4"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</main>

<?php include '../../../includes/footer.php'; ?>