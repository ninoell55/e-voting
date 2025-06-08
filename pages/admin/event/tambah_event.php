<?php
require_once '../../../config/connection.php';
$pageTitle = "Tambah Event";

if (isset($_POST["submit"])) {
    if (addEvent($_POST) > 0) {
        header("Location: daftar_event.php?success=tambah");
        exit;
    } else {
        $error = true;
    }
}

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
    
    <?php if (!empty($error)): ?>
        <div id="alert-box" class="bg-red-100 text-red-700 p-4 rounded mb-4 flex justify-between items-center">
            <span>Tanggal selesai tidak boleh lebih kecil dari tanggal mulai</span>
            <button onclick="document.getElementById('alert-box').style.display='none'"
                class="text-xl font-bold px-2 leading-none hover:text-red-900">&times;</button>
        </div>
    <?php endif; ?>

    <form method="POST" class="bg-white shadow rounded-2xl p-6 max-w-xl">
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Nama</label>
            <input type="text" name="nama_event" required class="w-full border px-3 py-2 rounded focus:outline-none focus:ring focus:border-blue-500">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Tanggal Mulai</label>
            <input type="date" name="tgl_mulai" required class="w-full border px-3 py-2 rounded focus:outline-none focus:ring focus:border-blue-500">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Tanggal Selesai</label>
            <input type="date" name="tgl_selesai" required class="w-full border px-3 py-2 rounded focus:outline-none focus:ring focus:border-blue-500">
        </div>

        <button type="submit" name="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
            Simpan
        </button>
    </form>
</main>

<?php include '../../../includes/footer.php'; ?>