<?php
require '../../../config/connection.php';
$pageTitle = "Edit Kandidat";

$id = $_GET['id'];
$kandidat = query("SELECT * FROM kandidat WHERE id_kandidat = $id")[0];

// ambil data event untuk dropdown
$events = query("SELECT * FROM event WHERE status = 'aktif' OR id_event = {$kandidat['id_event']}");

if (isset($_POST['submit'])) {
    if (updateKandidat($_POST) > 0) {
        header("Location: daftar_kandidat.php?success=edit");
        exit;
    } else {
        $error = "Gagal memperbarui data.";
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
        <div id="alert-box" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
            <span class="block sm:inline"><?= $error ?></span>
            <span onclick="document.getElementById('alert-box').style.display='none'"
                class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer text-xl font-bold">&times;</span>
        </div>
    <?php endif; ?>

    <form action="" method="post" enctype="multipart/form-data" class="space-y-6 bg-white p-6 rounded shadow-md max-w-xl">
        <input type="hidden" name="id_kandidat" value="<?= $kandidat['id_kandidat']; ?>">
        <input type="hidden" name="gambar_lama" value="<?= $kandidat['gambar']; ?>">

        <div>
            <label for="id_event" class="block text-sm font-medium text-gray-700 mb-1">Pilih Event</label>
            <select name="id_event" id="id_event" required class="w-full border border-gray-300 rounded px-3 py-2">
                <?php foreach ($events as $event) : ?>
                    <option value="<?= $event['id_event']; ?>"
                        <?= $event['id_event'] == $kandidat['id_event'] ? 'selected' : ''; ?>>
                        <?= $event['nama_event']; ?><?= $event['status'] != 'aktif' ? ' (nonaktif)' : ''; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label for="nama_kandidat" class="block text-sm font-medium text-gray-700 mb-1">Nama Kandidat</label>
            <input type="text" name="nama_kandidat" id="nama_kandidat" value="<?= $kandidat['nama_kandidat']; ?>"
                required class="w-full border border-gray-300 rounded px-3 py-2">
        </div>

        <div>
            <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
            <textarea name="keterangan" id="keterangan" required rows="4"
                class="w-full border border-gray-300 rounded px-3 py-2"><?= $kandidat['keterangan']; ?></textarea>
        </div>

        <div class="mb-6">
            <label for="gambar" class="block text-gray-700 font-medium mb-2">Gambar</label>

            <div class="flex flex-wrap md:flex-nowrap items-start gap-6">
                <div class="flex flex-col items-center">
                    <label
                        for="gambar"
                        class="flex flex-col items-center rounded border border-gray-300 p-4 text-gray-900 shadow-sm sm:p-6 cursor-pointer hover:bg-gray-50 transition">
                        <i data-lucide="image-up" class="w-6 h-6 text-gray-500"></i>

                        <span class="mt-4 font-medium">Upload your file</span>

                        <span
                            class="mt-2 inline-block rounded border border-gray-200 bg-gray-50 px-3 py-1.5 text-center text-xs font-medium text-gray-700 shadow-sm hover:bg-gray-100">
                            Browse files
                        </span>

                        <input type="file" name="gambar" id="gambar" accept="image/*" class="sr-only" onchange="previewFile(this)">
                    </label>

                    <span id="nama-file" class="text-sm text-gray-600 mt-2">Belum ada file yang dipilih</span>
                </div>

                <div class="mt-4 md:mt-0">
                    <img id="preview-image" src="../../../assets/img/<?= $kandidat['gambar']; ?>" alt="Preview"
                        class="w-48 h-48 object-cover border rounded shadow">
                </div>
            </div>
        </div>

        <div>
            <button type="submit" name="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded transition">
                Ubah Data
            </button>
        </div>
    </form>
</main>

<script>
    function previewFile(input) {
        const file = input.files[0];
        const fileName = file ? file.name : 'Belum ada file yang dipilih';
        document.getElementById('nama-file').textContent = fileName;

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview-image').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }
</script>


<?php include '../../../includes/footer.php'; ?>