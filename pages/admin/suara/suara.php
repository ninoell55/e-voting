<?php
require_once '../../../config/connection.php';
$pageTitle = "Statistik Suara";

// Mendapatkan event_id yang dipilih
$selectedEventId = $_GET['event_id'] ?? null;

// Ambil semua event dari tabel event
$events = query("SELECT id_event, nama_event, tgl_selesai FROM event ORDER BY tgl_mulai DESC");

// Ambil data kandidat dan suara jika event dipilih
$kandidatData = [];
$totalSuara = 0;
$nama_event = '';
if ($selectedEventId) {
    $eventQuery = query("SELECT nama_event FROM event WHERE id_event = $selectedEventId");
    if (!empty($eventQuery)) {
        $nama_event = $eventQuery[0]['nama_event'];
    }

    // Query untuk mendapatkan data kandidat dan suara
    $kandidatData = query("
        SELECT k.nama_kandidat, COUNT(p.id_kandidat) AS suara 
        FROM kandidat k
        LEFT JOIN pilih p ON k.id_kandidat = p.id_kandidat
        WHERE k.id_event = $selectedEventId
        GROUP BY k.id_kandidat
    ");

    // Menghitung total suara
    $totalSuara = query("SELECT COUNT(*) AS total FROM pilih WHERE id_event = $selectedEventId")[0]['total'] ?? 0;
}

// Data status pemilih
$statusPemilih = [];
if ($selectedEventId) {
    // Query status pemilih
    $statusPemilih = query("
    SELECT pemilih.username, nama_lengkap,
           (SELECT COUNT(*) FROM pilih WHERE id_pemilih = pemilih.id_pemilih AND id_event = $selectedEventId) AS status
    FROM pemilih
  ");
}

include '../../../includes/header.php';
include '../../../includes/sidebar.php';
?>

<main id="mainContent" class="flex-1 p-6 mt-16 ml-64 transition-all duration-300 bg-gray-100">
    <div class="mb-6">
        <nav class="mb-1 text-sm text-gray-500">
            <ol class="flex list-reset">
                <li><a href="#" class="text-blue-600 hover:underline">Pages</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-800"><?= $pageTitle ?></li>
            </ol>
        </nav>
        <h1 class="text-2xl font-bold text-gray-800"><?= $pageTitle ?></h1>
    </div>

    <div>
        <h2 class="mb-6 text-2xl font-semibold">Perolehan Suara</h2>

        <!-- Filter Pilih Event -->
        <?php
        $eventId = isset($_GET['event_id']) ? $_GET['event_id'] : '';
        $dateNow = date('Y-m-d');
        ?>

        <div class="p-4 mb-6 bg-white rounded-md shadow-md">
            <form method="GET" class="flex flex-col items-start gap-4 md:flex-row md:items-center">
                <label for="event_id" class="font-medium">Pilih Pemilihan:</label>
                <select name="event_id" id="event_id" class="w-full p-2 border border-gray-300 rounded-md md:w-80">
                    <option value="">-- Pilih Event --</option>

                    <optgroup label="Event Aktif">
                        <?php foreach ($events as $e): ?>
                            <?php if ($e['tgl_selesai'] > $dateNow): ?>
                                <option value="<?= $e['id_event'] ?>" <?= ($eventId == $e['id_event']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($e['nama_event']) ?>
                                </option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </optgroup>

                    <optgroup label="Event Selesai / Tidak Aktif">
                        <?php foreach ($events as $e): ?>
                            <?php if ($e['tgl_selesai'] <= $dateNow): ?>
                                <option value="<?= $e['id_event'] ?>" <?= ($eventId == $e['id_event']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($e['nama_event']) ?>
                                </option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </optgroup>
                </select>

                <button type="submit" class="px-4 py-2 text-white transition bg-blue-600 rounded-md hover:bg-blue-700">
                    Tampilkan Statistik
                </button>
            </form>
        </div>


        <?php if ($selectedEventId): ?>
            <!-- Konten Statistik -->
            <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
                <!-- Grafik Pie -->
                <div
                    class="flex flex-col items-center justify-center p-6 shadow-lg bg-gradient-to-tr from-indigo-50 via-purple-50 to-pink-50 rounded-2xl"
                    style="min-height: 320px;">
                    <canvas id="pieChart" class="w-full max-w-md max-h-[320px]"></canvas>
                </div>

                <!-- Tabel Kandidat -->
                <div class="p-6 bg-white border border-gray-200 shadow-lg rounded-2xl">
                    <h3 class="pb-3 mb-6 text-2xl font-bold text-gray-800 border-b border-gray-300">
                        <?= htmlspecialchars($nama_event) ?>
                    </h3>
                    <div class="overflow-x-auto rounded-lg">
                        <table class="min-w-full text-sm text-left text-gray-700">
                            <thead class="text-sm font-semibold tracking-wide text-indigo-900 uppercase bg-indigo-100">
                                <tr>
                                    <th class="px-6 py-3">Kandidat</th>
                                    <th class="px-6 py-3">Jumlah Suara</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($kandidatData as $k): ?>
                                    <tr
                                        class="transition-colors duration-300 border-b border-gray-200 cursor-pointer hover:bg-indigo-50"
                                        title="Klik untuk detail <?= htmlspecialchars($k['nama_kandidat']) ?>">
                                        <td class="px-6 py-4 font-medium"><?= htmlspecialchars($k['nama_kandidat']) ?></td>
                                        <td class="px-6 py-4 font-semibold text-indigo-700"><?= $k['suara'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Status Pemilih -->
            <div class="p-4 mt-6 bg-white rounded shadow">
                <h3 class="mb-4 text-base font-semibold text-gray-800">Status Pemilih</h3>
                <div>
                    <table id="dataTables"
                        class="min-w-full overflow-x-auto text-sm text-gray-800 border border-gray-200 rounded-lg display responsive nowrap">
                        <thead>
                            <tr class="text-sm font-semibold text-left text-gray-700 bg-gray-100">
                                <th class="px-6 py-3">Username</th>
                                <th class="px-6 py-3">Nama Lengkap</th>
                                <th class="px-6 py-3">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($statusPemilih as $s): ?>
                                <tr class="transition hover:bg-gray-100">
                                    <td class="px-6 py-4"><?= htmlspecialchars($s['username']) ?></td>
                                    <td class="px-6 py-4"><?= htmlspecialchars($s['nama_lengkap']) ?></td>
                                    <td class="px-6 py-4">
                                        <?php if ($s['status']): ?>
                                            <span class="inline-flex items-center px-2 py-1 text-xs font-medium text-green-700 bg-green-100 rounded-full">Sudah Memilih</span>
                                        <?php else: ?>
                                            <span class="inline-flex items-center px-2 py-1 text-xs font-medium text-red-700 bg-red-100 rounded-full">Belum Memilih</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        <?php endif; ?>
    </div>

</main>

<!-- ChartJS -->
<script>
    const ctx = document.getElementById('pieChart').getContext('2d');
    const dataLabels = <?= json_encode(array_column($kandidatData, 'nama_kandidat')) ?>;
    const dataVotes = <?= json_encode(array_column($kandidatData, 'suara')) ?>;
    const bgColors = ['#f87171', '#60a5fa', '#facc15', '#34d399', '#a78bfa', '#fb7185', '#38bdf8'];

    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: dataLabels,
            datasets: [{
                data: dataVotes,
                backgroundColor: bgColors,
                borderColor: '#fff',
                borderWidth: 3,
                hoverOffset: 30, // efek “pop-out” saat hover
                hoverBorderColor: '#000'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: {
                animateScale: true,
                animateRotate: true,
                duration: 1200,
                easing: 'easeOutQuart',
            },
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        pointStyle: 'circle',
                        padding: 20,
                        font: {
                            size: 14,
                            weight: '600'
                        },
                        color: '#4b5563' // gray-700
                    }
                },
                tooltip: {
                    enabled: true,
                    backgroundColor: 'rgba(55, 65, 81, 0.9)', // gray-700 with opacity
                    titleFont: {
                        weight: 'bold'
                    },
                    bodyFont: {
                        size: 14
                    },
                    padding: 10,
                    cornerRadius: 6,
                    displayColors: false,
                    callbacks: {
                        label: context => {
                            const label = context.label || '';
                            const value = context.parsed || 0;
                            return `${label}: ${value} suara`;
                        }
                    }
                }
            }
        }
    });
</script>

<?php include '../../../includes/footer.php'; ?>