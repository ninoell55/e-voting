<?php
require_once '../../../config/connection.php';
$pageTitle = "Edit Admin";

// Cek login session admin
if (!isset($_SESSION['login_admin'])) {
    header("Location: ../../../auth/login_admin.php");
    exit;
}

$id_admin = $_GET["id"];
if (!isset($id_admin) || !is_numeric($id_admin)) {
    header("Location: daftar_admin.php?success=invalid");
    exit;
}
$admin = query("SELECT * FROM admin WHERE id_admin = $id_admin")[0];

if (isset($_POST["submit"])) {
    if (updateAdmin($_POST) > 0) {
        header("Location: daftar_admin.php?success=edit");
        exit;
    } else {
        $error = "Gagal memperbarui data.";
    }
}

include '../../../includes/header.php';
include '../../../includes/sidebar.php';
?>

<main id="mainContent" class="flex-1 bg-gray-100 p-6 mt-16 transition-all duration-300 ml-64">
    <!-- Breadcrumb -->
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

    <?php if (!empty($error)): ?>
        <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
            <?= $error; ?>
        </div>
    <?php endif; ?>

    <form method="POST" class="bg-white shadow rounded-2xl p-6 max-w-xl">
        <input type="hidden" name="id_admin" value="<?= $admin['id_admin']; ?>">
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Username</label>
            <input type="text" name="username" value="<?= $admin['username']; ?>" class="w-full border px-3 py-2 rounded focus:outline-none focus:ring focus:border-blue-500" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Password</label>
            <input type="text" name="password" value="<?= $admin['password']; ?>" class="w-full border px-3 py-2 rounded focus:outline-none focus:ring focus:border-blue-500" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Role</label>
            <select name="role" class="w-full border px-3 py-2 rounded focus:outline-none focus:ring focus:border-blue-500" required>
                <option value="administrator" <?= $admin['role'] == 'Administrator' ? 'selected' : ''; ?>>Administrator</option>
                <option value="panitia event" <?= $admin['role'] == 'panitia event' ? 'selected' : ''; ?>>Panitia Event</option>
            </select>
        </div>

        <button type="submit" name="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
            Simpan Perubahan
        </button>
    </form>
</main>

<?php include '../../../includes/footer.php'; ?>