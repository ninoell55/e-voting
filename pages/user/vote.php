<?php
require_once '../../config/connection.php';

$id_pemilih = $_SESSION['id_pemilih'] ?? null;
if (!$id_pemilih) {
    header("Location: login.php");
    exit;
}

$id_event = $_GET['id'] ?? null;
if (!$id_event) {
    header("Location: vote_event.php");
    exit;
}

// Ambil data event
$event = query("SELECT * FROM event WHERE id_event = $id_event")[0] ?? null;
if (!$event) {
    header("Location: vote_event.php");
    exit;
}

// Ambil kandidat berdasarkan event
$kandidat = query("SELECT * FROM kandidat WHERE id_event = $id_event");

include '../../includes/header.php';
?>

<main class="min-h-screen mt-16 bg-gradient-to-br from-sky-200 via-white to-purple-200 p-6 md:p-10" x-data="{ modal: false, selectedId: null }" @keydown.enter.window="if (modal && selectedId) window.location.href = 'submit_vote.php?id_event=<?= $id_event ?>&id_kandidat=' + selectedId">

    <div class="animate__animated animate__fadeIn animate__faster max-w-6xl mx-auto bg-white rounded-3xl shadow-2xl p-8">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mb-6 text-center sm:text-left">
            <h1 class="animate__animated animate__fadeInLeft text-xl sm:text-3xl font-bold text-indigo-800 tracking-tight leading-snug">
                Pilih Kandidat - <?= htmlspecialchars($event['nama_event']) ?>
            </h1>
            <a href="vote_event.php" class="animate__animated animate__fadeInRight inline-flex items-center gap-2 bg-indigo-100 hover:bg-indigo-200 text-indigo-700 px-5 py-2 rounded-xl shadow-md font-semibold transition duration-300">
                <i data-lucide="arrow-left" class="w-6 h-6"></i>
                Kembali ke Pilihan Event
            </a>
        </div>

        <?php if (empty($kandidat)) : ?>
            <div class="animate__animated animate__tada text-center py-12">
                <p class="text-xl font-medium text-gray-500">Belum ada kandidat untuk event ini.</p>
            </div>
        <?php else : ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" x-data="{ search: '' }">
                <?php foreach ($kandidat as $k) : ?>
                    <div class="group bg-indigo-50 hover:bg-white rounded-2xl shadow-md hover:shadow-xl p-6 text-center transition-all duration-300" x-show="'<?= strtolower($k['nama_kandidat']) ?>'.includes(search.toLowerCase())">
                        <div class="flex justify-center mb-4">
                            <div class="animate__animated animate__zoomIn w-32 h-32 rounded-full overflow-hidden border-4 border-white shadow-lg transform group-hover:scale-105 transition">
                                <a href="<?= $base_url ?>/assets/img/<?= htmlspecialchars($k['gambar']) ?>" data-lightbox="candidate-image" data-title="<?= htmlspecialchars($k['nama_kandidat']) ?> - <?= htmlspecialchars(explode("-", $k['kode_kandidat'])[1]) ?>">
                                    <img src="<?= $base_url ?>/assets/img/<?= htmlspecialchars($k['gambar']) ?>" alt="<?= htmlspecialchars($k['nama_kandidat']) ?>" class="w-full h-full object-cover cursor-pointer">
                                </a>
                            </div>
                        </div>
                        <h2 class="animate__animated animate__lightSpeedInLeft text-xl font-semibold text-indigo-700 group-hover:text-indigo-900 transition"><?= htmlspecialchars($k['nama_kandidat']) ?></h2>
                        <p class="animate__animated animate__lightSpeedInRight text-sm text-gray-600 mt-1 mb-4 italic"><?= htmlspecialchars($k['keterangan']) ?></p>
                        <button @click="modal = true; selectedId = '<?= $k['id_kandidat'] ?>'" class="animate__animated animate__slideInUp inline-flex items-center gap-2 mt-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-xl shadow-md font-medium text-sm transition">
                            <i data-lucide="check-circle" class="w-5 h-5"></i>Pilih Kandidat
                        </button>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- MODAL KONFIRMASI -->
    <div x-show="modal" x-transition.opacity.duration.300ms class="fixed inset-0 flex items-center justify-center bg-black/30 backdrop-blur-sm z-50">
        <div
            x-show="modal"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-90"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-90"
            class="bg-white rounded-2xl shadow-2xl max-w-sm w-full p-6 relative"
            @click.outside="modal = false">
            <h2 class="text-lg font-bold text-gray-800 mb-2">Konfirmasi Pilihan</h2>
            <p class="text-sm text-gray-600 mb-4">Apakah kamu yakin ingin memilih kandidat ini?</p>
            <div class="flex justify-end gap-3 mt-6">
                <button @click="modal = false" class="px-4 py-2 rounded-md bg-gray-200 hover:bg-gray-300 text-sm font-medium text-gray-700">
                    Batal
                </button>
                <template x-if="selectedId">
                    <a :href="'submit_vote.php?id_event=<?= $id_event ?>&id_kandidat=' + selectedId" class="px-4 py-2 rounded-md bg-indigo-600 hover:bg-indigo-700 text-sm font-medium text-white">
                        Yakin & Pilih
                    </a>
                </template>
            </div>
            <div class="absolute -top-5 left-1/2 -translate-x-1/2 bg-white p-1 rounded-full shadow">
                <i data-lucide="help-circle" class="w-8 h-8 text-indigo-600"></i>
            </div>
        </div>
    </div>

</main>

<?php include '../../includes/footer.php'; ?>