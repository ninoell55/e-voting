<?php
require_once '../../../config/connection.php';
$pageTitle = "Tambah Kandidat";

$events = query("SELECT * FROM event");

if (isset($_POST["submit"])) {
    if (addKandidat($_POST) > 0) {
        header("Location: daftar_kandidat.php?id=" . $_POST["id_event"]);
        exit;
    } else {
        $error = true;
    }
}

include '../../../includes/header.php';
include '../../../includes/sidebar.php';
?>

<main class="flex-1 p-6 mt-16 md:ml-64 bg-gray-50 min-h-screen">
    <div class="max-w-xl bg-white p-6 rounded-xl shadow">
        <h1 class="text-2xl font-bold mb-4 text-gray-800">Tambah Kandidat</h1>

        <?php if (!empty($error)): ?>
            <div id="alert-box" class="bg-red-100 text-red-700 p-4 rounded mb-4 flex justify-between items-center">
                <span>Gagal menambahkan kandidat. Silakan cek kembali.</span>
                <button onclick="document.getElementById('alert-box').style.display='none'"
                    class="text-xl font-bold px-2 leading-none hover:text-red-900">&times;</button>
            </div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data" class="space-y-4">
            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Pilih Event</label>
                <select name="id_event" required class="w-full border rounded px-3 py-2">
                    <option value="">-- Pilih Event --</option>
                    <?php foreach ($events as $e): ?>
                        <option value="<?= $e['id_event'] ?>"><?= htmlspecialchars($e['nama_event']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Nama Kandidat</label>
                <input type="text" name="nama_kandidat" required class="w-full border rounded px-3 py-2">
            </div>

            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Keterangan (Visi & Misi)</label>
                <textarea name="keterangan" rows="4" class="w-full border rounded px-3 py-2"></textarea>
            </div>

            <div>
                <label class="block mb-2 text-sm font-medium text-gray-700">Foto Kandidat</label>
                <div class="flex flex-wrap md:flex-nowrap items-start gap-6">
                    <!-- Custom File Upload -->
                    <div class="flex flex-col items-center">
                        <label
                            for="gambar"
                            class="flex flex-col items-center rounded border border-gray-300 p-4 text-gray-900 shadow-sm sm:p-6 cursor-pointer hover:bg-gray-50 transition">
                            <i data-lucide="image-up" class="w-6 h-6 text-gray-500"></i>

                            <span class="mt-4 font-medium">Upload Foto</span>

                            <span
                                class="mt-2 inline-block rounded border border-gray-200 bg-gray-50 px-3 py-1.5 text-center text-xs font-medium text-gray-700 shadow-sm hover:bg-gray-100">
                                Browse files
                            </span>

                            <input type="file" name="gambar" id="gambar" accept="image/*" class="sr-only" onchange="previewFile(this)">
                        </label>

                        <!-- Nama File -->
                        <span id="nama-file" class="text-sm text-gray-600 mt-2">Belum ada file yang dipilih</span>
                    </div>

                    <!-- Preview Gambar -->
                    <div class="mt-4 md:mt-0">
                        <img id="preview-image" src="" alt="Preview" class="w-48 h-48 object-cover border rounded shadow hidden">
                    </div>
                </div>
            </div>

            <div>
                <button type="submit" name="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Simpan</button>
            </div>
        </form>
    </div>
</main>

<script>
    function previewFile(input) {
        const file = input.files[0];
        const fileName = file ? file.name : 'Belum ada file yang dipilih';
        document.getElementById('nama-file').textContent = fileName;

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.getElementById('preview-image');
                img.src = e.target.result;
                img.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }
    }


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