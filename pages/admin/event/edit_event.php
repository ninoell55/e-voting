<?php
require_once '../../../config/connection.php';
$pageTitle = "Edit Event";

// Cek login session admin
if (!isset($_SESSION['login_admin'])) {
    header("Location: ../../../auth/login_admin.php");
    exit;
}

$id_event = $_GET["id"];

if (!isset($id_event) || !is_numeric($id_event)) {
    header("Location: daftar_event.php?success=invalid");
    exit;
}

$event = query("SELECT * FROM event WHERE id_event = $id_event")[0];

if (isset($_POST["submit"])) {
    if (updateEvent($_POST) > 0) {
        header("Location: daftar_event.php?success=edit");
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
        <div id="alert-box" class="bg-red-100 text-red-700 p-4 rounded mb-4 flex justify-between items-center">
            <span><?= $error ?></span>
            <button onclick="document.getElementById('alert-box').style.display='none'"
                class="text-xl font-bold px-2 leading-none hover:text-red-900">&times;</button>
        </div>
    <?php endif; ?>

    <form method="POST" class="bg-white shadow rounded-2xl p-6 max-w-xl">
        <input type="hidden" name="id_event" value="<?= $event['id_event']; ?>">
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Nama</label>
            <input type="text" name="nama_event" value="<?= $event['nama_event']; ?>" class="w-full border px-3 py-2 rounded focus:outline-none focus:ring focus:border-blue-500" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Tanggal Mulai</label>
            <input type="date" name="tgl_mulai" value="<?= $event['tgl_mulai']; ?>" class="w-full border px-3 py-2 rounded focus:outline-none focus:ring focus:border-blue-500" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Tanggal Selesai</label>
            <input type="date" name="tgl_selesai" value="<?= $event['tgl_selesai']; ?>" class="w-full border px-3 py-2 rounded focus:outline-none focus:ring focus:border-blue-500">
        </div>

        <button type="submit" name="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
            Simpan Perubahan
        </button>
    </form>
</main>

<?php include '../../../includes/footer.php'; ?>