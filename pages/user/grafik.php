<?php
require_once '../../config/connection.php';

$id_pemilih = $_SESSION['id_pemilih'] ?? null;
if (!$id_pemilih) {
    header("Location: login.php");
    exit;
}

// Ambil event yang pernah dipilih user
$eventList = query("
  SELECT e.id_event, e.nama_event
  FROM event e
  JOIN pilih p ON e.id_event = p.id_event
  WHERE p.id_pemilih = $id_pemilih
  GROUP BY e.id_event
");

// Jika user memilih event
$event_id = $_GET['event'] ?? null;
$data = [];

if ($event_id) {
    $kandidat = query("
    SELECT k.nama_kandidat, COUNT(p.id) as total_suara
    FROM kandidat k
    LEFT JOIN pilih p ON p.id_kandidat = k.id_kandidat
    WHERE k.id_event = $event_id
    GROUP BY k.id_kandidat
  ");
    $data = $kandidat;
}

include '../../includes/header.php';
?>

<main class="min-h-screen mt-16 bg-gradient-to-br from-sky-300 via-white to-purple-200 p-6 md:p-12">
    <div class="animate__animated animate__fadeIn animate__faster max-w-4xl mx-auto bg-white rounded-3xl shadow-2xl p-8 md:p-12 ring-1 ring-indigo-300">
        <header class="flex flex-col md:flex-row justify-between items-center gap-6 mb-8">
            <h1 class="animate__animated animate__fadeInLeft text-3xl md:text-4xl font-extrabold text-indigo-700 drop-shadow-sm">
                Grafik Suara
            </h1>
            <a href="index.php" class="animate__animated animate__fadeInRight inline-flex items-center gap-2 bg-indigo-100 hover:bg-indigo-200 text-indigo-700 px-5 py-2 rounded-xl shadow-md font-semibold transition duration-300">
                <i data-lucide="arrow-left" class="w-6 h-6"></i> Kembali ke Dashboard
            </a>
        </header>

        <form method="GET" class="mb-10">
            <label for="event-select" class="animate__animated animate__slideInDown block mb-3 font-semibold text-gray-700 text-lg">Pilih Event:</label>
            <select
                id="event-select"
                name="event"
                onchange="this.form.submit()"
                class="animate__animated animate__slideInUp w-full md:w-72 p-3 border-2 border-indigo-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500 transition duration-300">
                <option value="" disabled selected>-- Pilih Event --</option>
                <?php foreach ($eventList as $event) : ?>
                    <option value="<?= $event['id_event'] ?>" <?= ($event_id == $event['id_event']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($event['nama_event']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </form>

        <!-- Chart -->
        <?php if ($event_id && $data) : ?>
            <div class="w-full overflow-x-auto">
                <div class="relative min-w-[300px] h-[22rem] sm:h-[26rem] md:h-[30rem]">
                    <canvas id="voteChart" class="w-full h-full bg-indigo-50 rounded-xl shadow-inner p-4"></canvas>
                </div>
            </div>
        <?php elseif ($event_id) : ?>
            <p class="animate__animated animate__tada text-center text-gray-600 italic text-base sm:text-lg">Belum ada data suara untuk event ini.</p>
        <?php endif; ?>
    </div>
</main>

<?php if ($event_id && $data): ?>
    <script>
        const ctx = document.getElementById('voteChart').getContext('2d');
        const isMobile = window.innerWidth < 640;
        const voteChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?= json_encode(array_column($data, 'nama_kandidat')) ?>,
                datasets: [{
                    label: 'Jumlah Suara',
                    data: <?= json_encode(array_column($data, 'total_suara')) ?>,
                    backgroundColor: 'rgba(99, 102, 241, 0.8)',
                    borderColor: 'rgba(99, 102, 241, 1)',
                    borderWidth: 1,
                    borderRadius: 12,
                    hoverBackgroundColor: 'rgba(79, 70, 229, 0.9)',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    duration: 800,
                    easing: 'easeOutQuart'
                },
                scales: {
                    x: {
                        ticks: {
                            autoSkip: false,
                            maxRotation: 0,
                            minRotation: 0,
                            callback: function(value) {
                                const label = this.getLabelForValue(value);
                                if (isMobile) {
                                    return label.length > 10 ? label.slice(0, 10) + '...' : label;
                                } else {
                                    return label;
                                }
                            }
                        },
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        },
                        grid: {
                            color: '#e0e7ff'
                        }
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            font: {
                                size: 14,
                                weight: '600'
                            },
                            color: '#4f46e5'
                        }
                    },
                    tooltip: {
                        backgroundColor: '#4f46e5',
                        titleFont: {
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 14
                        }
                    }
                }
            }
        });
    </script>
<?php endif; ?>

<?php include '../../includes/footer.php'; ?>