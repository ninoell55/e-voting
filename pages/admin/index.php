<?php
require_once '../../config/connection.php';
$pageTitle = "Dashboard";

// Cek login session admin
if (!isset($_SESSION['login_admin'])) {
    header("Location: ../../auth/login_admin.php");
    exit;
}

updateEventStatus();

$query = "SELECT * FROM event ORDER BY tgl_mulai DESC";
$event = mysqli_query($conn, $query);
$e = mysqli_fetch_assoc($event);

$query1 = "SELECT k.*, 
                (SELECT COUNT(*) FROM pilih p WHERE p.id_kandidat = k.id_kandidat) AS jumlah_suara,
                e.nama_event, e.tgl_mulai, e.tgl_selesai
            FROM kandidat k
            LEFT JOIN event e ON k.id_event = e.id_event";

$kandidat = mysqli_query($conn, $query1);
$k = mysqli_fetch_assoc($kandidat);

// Statistik dasar
$jumlahEvent = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM event"))['total'];
$jumlahKandidat = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM kandidat"))['total'];
$jumlahPemilih = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM pemilih"))['total'];
$jumlahVote = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM pilih"))['total'];


// Ambil daftar semua event untuk dropdown
$allEventsQuery = mysqli_query($conn, "SELECT * FROM event WHERE status='aktif' ORDER BY tgl_mulai DESC");
$activeEvents = [];
while ($row = mysqli_fetch_assoc($allEventsQuery)) {
    $activeEvents[] = $row;
}

// Inisialisasi variabel
$eventSelected = null;
$selectedEventId = null;
$votingData = [];
$topKandidat = [];
$persentasePartisipasi = 0;
$totalPemilih = 0;
$pemilihVoting = 0;

if (count($activeEvents) === 1) {
    // Jika hanya satu event aktif, langsung set ID-nya
    $selectedEventId = $activeEvents[0]['id_event'];
    $eventSelected = $activeEvents[0];
} elseif (isset($_POST['event_id']) && !empty($_POST['event_id'])) {
    $selectedEventId = intval($_POST['event_id']);
} elseif ($eventSelected) {
    $selectedEventId = $eventSelected['id_event'];
}

// Ambil event yang dipilih via form (POST atau GET), default pakai event aktif
if (isset($_POST['event_id']) && !empty($_POST['event_id'])) {
    $selectedEventId = intval($_POST['event_id']);
} elseif ($eventSelected) {
    $selectedEventId = $eventSelected['id_event'];
} else {
    $selectedEventId = null;
}

if ($selectedEventId) {
    // Ambil data event yang dipilih
    $eventSelected = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM event WHERE id_event = $selectedEventId"));

    // Ambil suara per kandidat event terpilih
    $votingData = [];
    $resultVotes = mysqli_query($conn, "
        SELECT k.nama_kandidat, COUNT(p.id_kandidat) AS suara
        FROM kandidat k
        LEFT JOIN pilih p ON k.id_kandidat = p.id_kandidat
        WHERE k.id_event = $selectedEventId
        GROUP BY k.id_kandidat
        ORDER BY suara DESC
    ");
    while ($row = mysqli_fetch_assoc($resultVotes)) {
        $votingData[] = $row;
    }

    // 3 kandidat teratas
    $topKandidat = array_slice($votingData, 0, 3);

    // Persentase partisipasi
    $totalPemilih = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM pemilih"))['total'];
    $pemilihVoting = mysqli_fetch_assoc(mysqli_query($conn, "
        SELECT COUNT(DISTINCT id_pemilih) AS total
        FROM pilih p
        JOIN kandidat k ON p.id_kandidat = k.id_kandidat
        WHERE k.id_event = $selectedEventId
    "))['total'];
    $persentasePartisipasi = $totalPemilih > 0 ? round(($pemilihVoting / $totalPemilih) * 100, 2) : 0;
} else {
    $eventSelected = null;
    $votingData = [];
    $topKandidat = [];
    $persentasePartisipasi = 0;
    $totalPemilih = 0;
    $pemilihVoting = 0;
}

$jumlahMemilih = round($totalPemilih * ($persentasePartisipasi / 100));
$jumlahBelumMemilih = $totalPemilih - $jumlahMemilih;

include '../../includes/header.php';
include '../../includes/sidebar.php';
?>

<main id="mainContent" class="flex-1 bg-gray-100 p-6 mt-16 transition-all duration-300 ml-64">  
    <div class="mb-6 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
        <!-- Breadcrumb & Title -->
        <nav class="text-gray-500 text-sm">
            <ol class="list-reset flex flex-wrap items-center">
                <li><a href="#" class="text-blue-600 hover:underline">Pages</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-800"><?= $pageTitle ?></li>
            </ol>
            <h1 class="text-2xl font-bold text-gray-800 mt-1"><?= $pageTitle ?></h1>
        </nav>

        <!-- Select + Button -->
        <?php if (count($activeEvents) > 1): ?>
            <form method="post" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 w-full sm:w-auto">
                <select name="event_id" class="border border-gray-300 rounded px-3 py-2 w-full sm:w-auto">
                    <option value="">-- Pilih Event --</option>
                    <?php foreach ($activeEvents as $row): ?>
                        <option value="<?= $row['id_event']; ?>" <?= (isset($selectedEventId) && $selectedEventId == $row['id_event']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($row['nama_event']) . " ({$row['tgl_mulai']} - {$row['tgl_selesai']})"; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition w-full sm:w-auto">
                    Tampilkan
                </button>
            </form>
        <?php else: ?>
            <div class="flex items-center gap-2 p-3 bg-blue-50 border border-blue-200 text-sm text-blue-800 rounded-lg shadow-sm">
                <i data-lucide="calendar-check" class="w-5 h-5"></i>

                <span class="font-medium">Event aktif:</span>
                <a href="event/view_event.php?id=<?= $eventSelected['id_event']; ?>" class="text-blue-900 font-bold"><?= htmlspecialchars($activeEvents[0]['nama_event']) ?></a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Statistik -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Jumlah Pemilih -->
        <div class="relative bg-gradient-to-r from-white to-gray-100 border border-gray-200 rounded-2xl shadow-md p-6 hover:shadow-lg transition-shadow duration-300">
            <div class="flex items-center gap-4">
                <div class="bg-blue-100 text-blue-500 p-3 rounded-full">
                    <i data-lucide="users" class="w-6 h-6"></i>
                </div>
                <div>
                    <h2 class="text-sm font-medium text-gray-600 mb-1">Jumlah Pemilih</h2>
                    <p class="text-3xl font-bold text-blue-600"><?= $jumlahPemilih; ?></p>
                </div>
            </div>
            <a href="<?= $base_url; ?>pages/admin/pemilih/daftar_pemilih.php" class="absolute bottom-4 right-4 text-blue-500 hover:text-blue-700">
                <i data-lucide="arrow-up-right" class="w-5 h-5"></i>
            </a>
        </div>

        <!-- Jumlah Kandidat -->
        <div class="relative bg-gradient-to-r from-white to-gray-100 border border-gray-200 rounded-2xl shadow-md p-6 hover:shadow-lg transition-shadow duration-300">
            <div class="flex items-center gap-4">
                <div class="bg-green-100 text-green-500 p-3 rounded-full">
                    <i data-lucide="user-check" class="w-6 h-6"></i>
                </div>
                <div>
                    <h2 class="text-sm font-medium text-gray-600 mb-1">Jumlah Kandidat</h2>
                    <p class="text-3xl font-bold text-green-600"><?= $jumlahKandidat; ?></p>
                </div>
            </div>
            <a href="<?= $base_url; ?>pages/admin/kandidat/daftar_kandidat.php" class="absolute bottom-4 right-4 text-green-500 hover:text-green-700">
                <i data-lucide="arrow-up-right" class="w-5 h-5"></i>
            </a>
        </div>

        <!-- Total Voting Masuk -->
        <div class="relative bg-gradient-to-r from-white to-gray-100 border border-gray-200 rounded-2xl shadow-md p-6 hover:shadow-lg transition-shadow duration-300">
            <div class="flex items-center gap-4">
                <div class="bg-purple-100 text-purple-500 p-3 rounded-full">
                    <i data-lucide="bar-chart-3" class="w-6 h-6"></i>
                </div>
                <div>
                    <h2 class="text-sm font-medium text-gray-600 mb-1">Total Voting Masuk</h2>
                    <p class="text-3xl font-bold text-purple-600"><?= $jumlahVote; ?></p>
                </div>
            </div>
            <a href="<?= $base_url; ?>pages/admin/log/log_suara.php" class="absolute bottom-4 right-4 text-purple-500 hover:text-purple-700">
                <i data-lucide="arrow-up-right" class="w-5 h-5"></i>
            </a>
        </div>

        <!-- Jumlah Event -->
        <div class="relative bg-gradient-to-r from-white to-gray-100 border border-gray-200 rounded-2xl shadow-md p-6 hover:shadow-lg transition-shadow duration-300">
            <div class="flex items-center gap-4">
                <div class="bg-red-100 text-red-500 p-3 rounded-full">
                    <i data-lucide="calendar-days" class="w-6 h-6"></i>
                </div>
                <div>
                    <h2 class="text-sm font-medium text-gray-600 mb-1">Jumlah Event</h2>
                    <p class="text-3xl font-bold text-red-600"><?= $jumlahEvent; ?></p>
                </div>
            </div>
            <a href="<?= $base_url; ?>pages/admin/event/daftar_event.php" class="absolute bottom-4 right-4 text-red-500 hover:text-red-700">
                <i data-lucide="arrow-up-right" class="w-5 h-5"></i>
            </a>
        </div>
    </div>

    <!-- Persentase Partisipasi Pemilih -->
    <div class="mb-8 bg-white rounded-2xl shadow-md p-6 border border-gray-100">
        <div class="flex items-center gap-2 mb-4">
            <i data-lucide="activity-square" class="w-6 h-6 text-blue-600"></i>
            <h2 class="text-lg font-semibold text-gray-700">Persentase Partisipasi Pemilih</h2>
        </div>

        <div class="flex justify-between items-center mb-1">
            <span class="text-sm font-medium text-gray-700">Progress</span>
            <span class="text-sm font-semibold text-blue-700"><?= $persentasePartisipasi ?>%</span>
        </div>

        <div class="w-full bg-gray-200 rounded-full h-6 overflow-hidden">
            <div class="h-full bg-gradient-to-r from-blue-400 via-blue-600 to-indigo-600 rounded-full transition-all duration-700 ease-out"
                style="width: <?= $persentasePartisipasi ?>%;"></div>
        </div>

        <?php
        $sudahMemilih = round($totalPemilih * $persentasePartisipasi / 100);
        $belumMemilih = $totalPemilih - $sudahMemilih;
        ?>

        <?php if ($totalPemilih > 0): ?>
            <div class="mt-4 flex justify-between text-sm text-gray-600">
                <div class="flex items-center gap-1">
                    <i data-lucide="check-circle" class="w-4 h-4 text-green-600"></i>
                    <span><strong><?= $sudahMemilih ?></strong> sudah memilih</span>
                </div>
                <div class="flex items-center gap-1">
                    <i data-lucide="x-circle" class="w-4 h-4 text-red-600"></i>
                    <span><strong><?= $belumMemilih ?></strong> belum memilih</span>
                </div>
            </div>
        <?php else: ?>
            <p class="mt-3 text-sm text-gray-600 italic">Belum ada event aktif atau data pemilih tersedia.</p>
        <?php endif; ?>
    </div>

    <!-- Daftar Event Aktif -->
    <div class="mb-8 bg-white rounded-2xl shadow-md p-6 border border-green-100">
        <div class="flex items-center gap-3 mb-5">
            <i data-lucide="calendar-clock" class="w-7 h-7 text-green-600"></i>
            <h2 class="text-xl font-semibold text-gray-800">Event Aktif</h2>
        </div>

        <?php if ($eventSelected): ?>
            <div class="space-y-3 p-4 bg-green-50 rounded-lg border border-green-200 hover:shadow-lg transition-shadow duration-300">
                <a href="event/view_event.php?id=<?= $eventSelected['id_event']; ?>"
                    class="block text-lg font-bold text-green-800 hover:underline hover:text-green-900 transition-colors duration-200">
                    <?= htmlspecialchars($eventSelected['nama_event']); ?>
                </a>
                <p class="text-sm text-green-700 font-medium">
                    <i data-lucide="calendar" class="inline-block w-4 h-4 mr-1"></i>
                    Periode:
                    <time datetime="<?= htmlspecialchars($eventSelected['tgl_mulai']); ?>" class="underline">
                        <?= htmlspecialchars($eventSelected['tgl_mulai']); ?>
                    </time>
                    &mdash;
                    <time datetime="<?= htmlspecialchars($eventSelected['tgl_selesai']); ?>" class="underline">
                        <?= htmlspecialchars($eventSelected['tgl_selesai']); ?>
                    </time>
                </p>
            </div>
        <?php else: ?>
            <p class="text-center text-gray-500 italic py-6 border border-dashed border-gray-200 rounded-md">
                Tidak ada event yang dipilih.
            </p>
        <?php endif; ?>
    </div>

    <!-- Tabel 3 Kandidat Teratas -->
    <div class="mb-8 bg-white rounded-xl shadow-md p-6 border border-gray-200">
        <?php if ($eventSelected && count($topKandidat) > 0): ?>
            <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <i data-lucide="users" class="w-6 h-6 text-blue-600"></i>
                Daftar Kandidat Event: <span class="text-blue-700"><?= htmlspecialchars($eventSelected['nama_event']); ?></span>
            </h2>
            <div class="overflow-x-auto rounded-lg border border-gray-300">
                <table class="min-w-full text-sm text-left border-collapse border border-gray-300">
                    <thead class="bg-blue-100 text-blue-800 uppercase text-xs font-semibold">
                        <tr>
                            <th class="border border-gray-300 px-5 py-3">
                                <div class="flex items-center gap-1">
                                    <i data-lucide="user-check" class="w-4 h-4"></i>
                                    <span>Nama Kandidat</span>
                                </div>
                            </th>
                            <th class="border border-gray-300 px-5 py-3 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <i data-lucide="bar-chart-2" class="w-4 h-4"></i>
                                    <span>Jumlah Suara</span>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        <?php foreach ($topKandidat as $kandidat): ?>
                            <tr class="hover:bg-blue-50 transition-colors cursor-pointer">
                                <td class="border border-gray-300 px-5 py-3 font-medium">
                                    <a href="kandidat/detail_kandidat.php?id=<?= $k['id_kandidat'] ?>">
                                        <?= htmlspecialchars($kandidat['nama_kandidat']) ?>
                                    </a>
                                </td>
                                <td class="border border-gray-300 px-5 py-3 text-right font-semibold text-blue-700">
                                    <a href="kandidat/detail_kandidat.php?id=<?= $k['id_kandidat'] ?>">
                                        <?= number_format($kandidat['suara']) ?>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-center text-gray-500 italic py-6 border border-dashed border-gray-300 rounded-lg">
                Tidak ada data kandidat untuk event aktif.
            </p>
        <?php endif; ?>
    </div>

    <!-- Grafik suara per kandidat -->
    <?php if ($eventSelected): ?>
        <div class="mb-8 bg-white rounded-2xl shadow p-6 border border-gray-100">
            <div class="flex items-center gap-2 mb-4">
                <i data-lucide="bar-chart-3" class="w-6 h-6 text-indigo-600"></i>
                <h2 class="text-lg font-semibold text-gray-700">
                    Statistik Voting per Kandidat (Event Aktif)
                </h2>
            </div>
            <div class="relative w-full h-[420px]">
                <canvas id="votingChart"></canvas>
            </div>
        </div>
    <?php else: ?>
        <div class="bg-white rounded-2xl shadow p-6 border border-gray-100">
            <p class="text-center text-gray-500 italic py-6 border border-dashed border-gray-300 rounded-lg">
                Silakan pilih event untuk melihat grafik suara per kandidat.
            </p>
        </div>
    <?php endif; ?>
</main>

<script>
    <?php if ($eventSelected): ?>
        const ctx = document.getElementById('votingChart').getContext('2d');

        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(99, 102, 241, 0.9)'); // indigo-500
        gradient.addColorStop(1, 'rgba(139, 92, 246, 0.7)'); // purple-500

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?= json_encode(array_column($votingData, 'nama_kandidat')) ?>,
                datasets: [{
                    label: 'Jumlah Suara',
                    data: <?= json_encode(array_column($votingData, 'suara')) ?>,
                    backgroundColor: gradient,
                    borderColor: 'rgba(99, 102, 241, 1)',
                    borderWidth: 1.5,
                    borderRadius: 6,
                    hoverBackgroundColor: 'rgba(79, 70, 229, 0.9)',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        top: 10,
                        bottom: 10
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#4f46e5',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                    },
                    datalabels: {
                        anchor: 'end',
                        align: 'top',
                        color: '#4f46e5',
                        font: {
                            weight: 'bold'
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#4b5563',
                            font: {
                                size: 12,
                                weight: '500'
                            }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            color: '#6b7280',
                            font: {
                                size: 12
                            }
                        },
                        grid: {
                            color: '#e5e7eb'
                        }
                    }
                }
            },
            plugins: [ChartDataLabels]
        });
    <?php else: ?>
        document.getElementById('votingChart').remove();
    <?php endif; ?>
</script>

<?php include '../../includes/footer.php'; ?>


<?php if (isset($_SESSION['login_success']) && $_SESSION['login_success']) : ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Login Berhasil!',
            text: 'Selamat datang di dashboard admin.',
            timer: 2000,
            showConfirmButton: false,
            timerProgressBar: true
        }).then(() => {
            window.history.replaceState(null, null, window.location.pathname);
        });
    </script>
    <?php unset($_SESSION['login_success']); ?>
<?php endif; ?>