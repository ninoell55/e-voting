<?php
require_once '../../../config/connection.php';
$pageTitle = "Pemilih";

$id_pemilih = $_GET["id"];
$pemilih = query("SELECT * FROM pemilih WHERE id_pemilih = $id_pemilih")[0];

if (isset($_POST["submit"])) {
    if (updatePemilih($_POST) > 0) {
        header("Location: daftar_pemilih.php?success=edit");
        exit;
    } else {
        $error = "Gagal memperbarui data.";
    }
}

include '../../../includes/header.php';
include '../../../includes/sidebar.php';
?>

<main class="flex-1 p-6 mt-16 md:ml-64 bg-gray-50 min-h-screen">
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

    <h1 class="text-2xl font-bold mb-4">Edit Pemilih</h1>

    <?php if (!empty($error)): ?>
        <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
            <?= $error; ?>
        </div>
    <?php endif; ?>

    <form method="POST" class="bg-white shadow rounded-2xl p-6 max-w-xl">
        <input type="hidden" name="id_pemilih" value="<?= $pemilih['id_pemilih']; ?>">
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Username</label>
            <input type="text" name="username" value="<?= $pemilih['username']; ?>" class="w-full border px-3 py-2 rounded focus:outline-none focus:ring focus:border-blue-500" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Password</label>
            <input type="text" name="password" value="<?= $pemilih['password']; ?>" class="w-full border px-3 py-2 rounded focus:outline-none focus:ring focus:border-blue-500" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Nama Lengkap</label>
            <input type="text" name="nama_lengkap" value="<?= $pemilih['nama_lengkap']; ?>" class="w-full border px-3 py-2 rounded focus:outline-none focus:ring focus:border-blue-500">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Kelas</label>
            <input type="text" name="kelas" value="<?= $pemilih['kelas']; ?>" class="w-full border px-3 py-2 rounded focus:outline-none focus:ring focus:border-blue-500">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Jenis Kelamin</label>
            <select name="gender" class="w-full border px-3 py-2 rounded focus:outline-none focus:ring focus:border-blue-500" required>
                <option value="L" <?= $pemilih['gender'] == 'L' ? 'selected' : ''; ?>>Laki-laki</option>
                <option value="P" <?= $pemilih['gender'] == 'P' ? 'selected' : ''; ?>>Perempuan</option>
            </select>
        </div>

        <button type="submit" name="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
            Simpan Perubahan
        </button>
    </form>
</main>

<?php include '../../../includes/footer.php'; ?>