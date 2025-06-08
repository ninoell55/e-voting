<?php
require_once '../../config/connection.php';

$id_pemilih = $_SESSION['id_pemilih'] ?? null;
if (!$id_pemilih) {
    header("Location: login.php");
    exit;
}

$id_event = $_GET['id_event'] ?? null;
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

// Ambil data pilihan pemilih
$pilihan = query("SELECT * FROM pilih WHERE id_event = $id_event AND id_pemilih = $id_pemilih")[0] ?? null;
if (!$pilihan) {
    header("Location: vote_event.php");
    exit;
}

// Ambil data kandidat yang dipilih
$id_kandidat = $pilihan['id_kandidat'];
$kandidat = query("SELECT * FROM kandidat WHERE id_kandidat = $id_kandidat")[0] ?? null;

include '../../includes/header.php';
?>

<main class="min-h-screen mt-16 bg-gradient-to-br from-sky-300 via-white to-purple-200 p-6 md:p-10">

    <div class="animate__animated animate__fadeIn animate__faster max-w-4xl mx-auto backdrop-blur-lg bg-white/70 border border-white/30 rounded-3xl shadow-2xl p-8 transition-all duration-300">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-10">
            <h1 class="animate__animated animate__fadeInLeft text-base sm:text-2xl font-extrabold text-indigo-900 tracking-tight flex items-center gap-2">
                <i data-lucide="user-check" class="w-7 h-7 text-indigo-700"></i>
                Pilihan Anda - <?= htmlspecialchars($event['nama_event']) ?>
            </h1>
            <a href="vote_event.php" class="animate__animated animate__fadeInRight inline-flex items-center gap-2 bg-indigo-100 hover:bg-indigo-200 text-indigo-700 px-5 py-2 rounded-xl shadow-md font-semibold transition duration-300">
                <i data-lucide="arrow-left" class="w-6 h-6"></i>
                Kembali ke Pilihan Event
            </a>
        </div>

        <?php if ($kandidat): ?>
            <div class="flex flex-col sm:flex-row items-center sm:items-start gap-8 text-center sm:text-left">

                <a href="<?= $base_url ?>/assets/img/<?= htmlspecialchars($kandidat['gambar']) ?>" data-lightbox="choice-candidate" data-title="<?= htmlspecialchars($kandidat['nama_kandidat']) ?> - <?= htmlspecialchars(explode("-", $kandidat['kode_kandidat'])[1]) ?>">
                    <img src="<?= $base_url ?>/assets/img/<?= htmlspecialchars($kandidat['gambar']) ?>"
                        alt="<?= htmlspecialchars($kandidat['nama_kandidat']) ?>"
                        class="w-36 h-36 object-cover rounded-full border-4 border-indigo-200 shadow-lg transition hover:scale-105 duration-300 cursor-pointer animate__animated animate__zoomIn">
                </a>

                <div class="flex-1">
                    <h2 class="animate__animated animate__fadeInDown text-2xl font-bold text-indigo-800 mb-1">
                        <?= htmlspecialchars($kandidat['nama_kandidat']) ?>
                    </h2>
                    <p class="animate__animated animate__fadeInUp text-gray-700 text-sm leading-relaxed">
                        <?= htmlspecialchars($kandidat['keterangan']) ?>
                    </p>

                    <div class="animate__animated animate__lightSpeedInRight mt-6 bg-white/70 border border-gray-200 backdrop-blur rounded-xl p-4 shadow text-sm text-gray-700 font-medium">
                        <div class="flex items-center gap-2 mb-1 text-indigo-600 font-semibold">
                            <i data-lucide="clipboard-check" class="w-4 h-4"></i>
                            Tanda Terima:
                        </div>
                        <span class="block font-mono bg-gray-100 text-indigo-800 px-3 py-1 rounded-md mt-1 w-fit">
                            <?= htmlspecialchars($pilihan['tanda_terima']) ?>
                        </span>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="text-center py-12 text-red-600 font-semibold text-lg">
                <i data-lucide="alert-triangle" class="w-6 h-6 inline mb-1"></i>
                Data kandidat tidak ditemukan.
            </div>
        <?php endif; ?>
    </div>

    <?php if (isset($_SESSION['vote_success'])) : ?>
        <div x-data="{ showToast: true }"
            x-show="showToast"
            x-transition.duration.500ms
            class="fixed bottom-5 right-5 bg-indigo-600 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-2 z-[100]"
            x-init="setTimeout(() => showToast = false, 3000)">
            <i data-lucide="check-circle" class="w-5 h-5"></i>
            <span><?= $_SESSION['vote_success'] ?></span>
        </div>
        <?php unset($_SESSION['vote_success']); ?>
    <?php endif; ?>

</main>

<?php include '../../includes/footer.php'; ?>