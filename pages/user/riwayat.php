<?php
require_once '../../config/connection.php';

$bulan = $_GET['bulan'] ?? '';
$tahun = $_GET['tahun'] ?? '';
$id_pemilih = $_SESSION['id_pemilih'] ?? null;

if (!$id_pemilih) {
    header("Location: ../../auth/login_user.php");
    exit;
}

// Ambil semua pilihan pemilih
$riwayat = query("
    SELECT 
        pilih.*, 
        event.nama_event, event.tgl_mulai, event.tgl_selesai, 
        kandidat.nama_kandidat, kandidat.keterangan, kandidat.gambar
    FROM pilih 
    JOIN event ON pilih.id_event = event.id_event
    JOIN kandidat ON pilih.id_kandidat = kandidat.id_kandidat
    WHERE pilih.id_pemilih = $id_pemilih
    ORDER BY pilih.id DESC
");

$where = "p.id_pemilih = $id_pemilih";
if (!empty($bulan) && !empty($tahun)) {
    // Buat rentang tanggal dari bulan & tahun filter
    $startFilter = "$tahun-$bulan-01";
    $endFilter = date("Y-m-t", strtotime($startFilter)); // t = last day of month

    $where .= " AND (
        (e.tgl_mulai BETWEEN '$startFilter' AND '$endFilter')
        OR (e.tgl_selesai BETWEEN '$startFilter' AND '$endFilter')
        OR (e.tgl_mulai <= '$startFilter' AND e.tgl_selesai >= '$endFilter')
    )";
} elseif (!empty($bulan)) {
    // Jika cuma bulan
    $where .= " AND (
        MONTH(e.tgl_mulai) = $bulan
        OR MONTH(e.tgl_selesai) = $bulan
    )";
} elseif (!empty($tahun)) {
    // Jika cuma tahun
    $where .= " AND (
        YEAR(e.tgl_mulai) = $tahun
        OR YEAR(e.tgl_selesai) = $tahun
    )";
}

$query = "
  SELECT p.*, k.nama_kandidat, k.gambar, k.keterangan, e.nama_event, e.tgl_mulai, e.tgl_selesai
  FROM pilih p
  JOIN kandidat k ON p.id_kandidat = k.id_kandidat
  JOIN event e ON p.id_event = e.id_event
  WHERE $where
  ORDER BY p.id DESC
";
$result = mysqli_query($conn, $query);
$riwayat = mysqli_fetch_all($result, MYSQLI_ASSOC);

include '../../includes/header.php';
?>

<main class="min-h-screen mt-16 bg-gradient-to-br from-sky-300 via-white to-purple-200 p-6 md:p-10">
    <div class="animate__animated animate__fadeIn animate__faster max-w-6xl mx-auto space-y-8">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <h1 class="animate__animated animate__fadeInLeft text-3xl font-extrabold text-gray-800 tracking-tight flex items-center gap-2">
                <i data-lucide="history" class="w-6 h-6 text-indigo-600"></i> Riwayat Voting
            </h1>
            <a href="index.php" class="animate__animated animate__fadeInRight inline-flex items-center gap-2 bg-indigo-100 hover:bg-indigo-200 text-indigo-700 px-5 py-2 rounded-xl shadow-md font-semibold transition duration-300">
                <i data-lucide="arrow-left" class="w-6 h-6"></i>
                Kembali ke Dashboard
            </a>
        </div>

        <!-- Header & Filter -->
        <div class="bg-white rounded-3xl shadow-xl p-6 md:p-8 mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">

                <!-- Judul & Deskripsi -->
                <div>
                    <h1 class="animate__animated animate__fadeInDown text-2xl font-extrabold text-indigo-700">Arsip Suara Anda</h1>
                    <p class="animate__animated animate__fadeInUp text-sm text-gray-600">Histori partisipasi voting Anda berdasarkan periode tertentu.</p>
                </div>

                <!-- Form Filter -->
                <form method="GET" class="w-full md:w-auto flex flex-col sm:flex-row sm:items-end gap-4 bg-gray-50 border border-gray-200 rounded-xl p-4 shadow-sm">

                    <!-- Bulan -->
                    <div class="animate__animated animate__flipInX w-full sm:w-40">
                        <label for="bulan" class="block text-sm font-medium text-gray-700 mb-1">Pilih Bulan</label>
                        <div class="relative">
                            <select id="bulan" name="bulan" class="w-full appearance-none bg-white border border-gray-300 text-sm rounded-lg px-4 py-2 pr-10 text-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <option value="">Semua</option>
                                <?php for ($m = 1; $m <= 12; $m++): ?>
                                    <option value="<?= $m ?>" <?= ($_GET['bulan'] ?? '') == $m ? 'selected' : '' ?>>
                                        <?= date('F', mktime(0, 0, 0, $m, 1)) ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                            <i data-lucide="calendar" class="absolute right-3 top-2.5 w-4 h-4 text-gray-400 pointer-events-none"></i>
                        </div>
                    </div>

                    <!-- Tahun -->
                    <div class="animate__animated animate__flipInX w-full sm:w-40">
                        <label for="tahun" class="block text-sm font-medium text-gray-700 mb-1">Pilih Tahun</label>
                        <div class="relative">
                            <select id="tahun" name="tahun" class="w-full appearance-none bg-white border border-gray-300 text-sm rounded-lg px-4 py-2 pr-10 text-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <option value="">Semua</option>
                                <?php for ($y = date('Y'); $y >= 2020; $y--): ?>
                                    <option value="<?= $y ?>" <?= ($_GET['tahun'] ?? '') == $y ? 'selected' : '' ?>>
                                        <?= $y ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                            <i data-lucide="clock" class="absolute right-3 top-2.5 w-4 h-4 text-gray-400 pointer-events-none"></i>
                        </div>
                    </div>

                    <!-- Tombol Filter -->
                    <div class="animate__animated animate__flipInY w-full sm:w-auto">
                        <label class="block text-sm font-medium text-transparent mb-1">.</label>
                        <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-5 py-2 rounded-lg shadow transition duration-200">
                            <i data-lucide="filter" class="w-4 h-4"></i>
                            Terapkan Filter
                        </button>
                    </div>

                </form>
            </div>
        </div>


        <!-- List Riwayat -->
        <?php if (empty($riwayat)) : ?>
            <div class="animate__animated animate__tada text-center py-20 text-gray-600 text-lg font-medium">
                <i data-lucide="ban" class="w-8 h-8 mx-auto mb-2 text-red-400"></i>
                Tidak ada riwayat voting ditemukan.
            </div>
        <?php else : ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($riwayat as $r) : ?>
                    <div class="animate__animated animate__jackInTheBox bg-white rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transition duration-300 flex flex-col">
                        <div class="relative h-44 w-full bg-gray-100">
                            <img src="../../assets/img/<?= htmlspecialchars($r['gambar']) ?>" alt="<?= htmlspecialchars($r['nama_kandidat']) ?>" class="h-full w-full object-cover">
                            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent text-white text-sm px-4 py-2 flex items-center gap-2">
                                <i data-lucide="calendar" class="w-4 h-4"></i> <?= htmlspecialchars($r['nama_event']) ?>
                            </div>
                        </div>

                        <div class="flex-1 p-4 space-y-2">
                            <p class="text-xs text-gray-500 flex items-center gap-1">
                                <i data-lucide="clock" class="w-4 h-4 text-indigo-500"></i>
                                <?= date("d M Y", strtotime($r['tgl_mulai'])) ?> – <?= date("d M Y", strtotime($r['tgl_selesai'])) ?>
                            </p>
                            <p class="font-semibold text-lg text-gray-800 flex items-center gap-2">
                                <i data-lucide="user-check" class="w-5 h-5 text-green-500"></i>
                                <?= htmlspecialchars($r['nama_kandidat']) ?>
                            </p>
                            <p class="text-sm text-gray-600">
                                <?= htmlspecialchars($r['keterangan']) ?>
                            </p>
                            <p class="text-xs font-mono text-indigo-600 bg-indigo-100 px-2 py-1 rounded w-fit flex items-center gap-1">
                                <i data-lucide="badge-check" class="w-4 h-4 text-indigo-500"></i>
                                <?= htmlspecialchars($r['tanda_terima']) ?>
                            </p>
                        </div>

                        <div class="px-4 py-3 border-t bg-gray-50 text-right">
                            <a href="lihat_pilihan.php?id_event=<?= $r['id_event'] ?>" class="inline-block text-indigo-600 hover:text-indigo-800 font-medium text-sm">
                                <i data-lucide="external-link" class="inline w-4 h-4 mr-1"></i> Detail
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php include '../../includes/footer.php'; ?>