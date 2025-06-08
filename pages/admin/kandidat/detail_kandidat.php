<?php
require_once '../../../config/connection.php';
$pageTitle = "Detail Kandidat";

// Ambil detail kandidat berdasarkan ID
$id_kandidat = $_GET['id'];
$kandidat = query("SELECT * FROM kandidat WHERE id_kandidat = $id_kandidat")[0];

$id_event = $kandidat['id_event'];
$event = query("SELECT * FROM event WHERE id_event = $id_event")[0];

// Hitung jumlah suara yang diterima kandidat ini
$jumlah_suara = query("SELECT COUNT(*) as total FROM pilih WHERE id_kandidat = $id_kandidat")[0]['total'];

include '../../../includes/header.php';
include '../../../includes/sidebar.php';
?>

<main id="mainContent" class="flex-1 bg-gray-100 p-6 mt-16 transition-all duration-300 ml-64 max-w-5xl mx-auto">

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

    <div
        class="bg-white rounded-3xl shadow-xl border border-gray-200 max-w-5xl mx-auto overflow-hidden transition-transform duration-500 hover:scale-[1.03] hover:shadow-2xl">
        <!-- Header -->
        <div
            class="bg-gradient-to-r from-indigo-600 via-purple-700 to-pink-600 px-6 sm:px-8 py-4 sm:py-6 flex flex-col sm:flex-row justify-between items-center text-white gap-3 sm:gap-0">
            <h2
                class="text-2xl sm:text-3xl font-extrabold tracking-wide drop-shadow-md text-center sm:text-left">
                <?= htmlspecialchars($kandidat['nama_kandidat']) ?>
            </h2>
            <span
                class="bg-white text-indigo-700 text-xs sm:text-sm font-semibold px-4 sm:px-5 py-1.5 sm:py-2 rounded-full shadow-lg border border-indigo-200 select-none whitespace-nowrap"><?= htmlspecialchars($event['nama_event'] ?? 'Independen') ?></span>
        </div>

        <!-- Isi -->
        <div
            class="flex flex-col md:flex-row items-center p-6 sm:p-10 gap-6 sm:gap-10 bg-gray-50">
            <!-- Foto Kandidat -->
            <div
                class="relative w-28 h-28 sm:w-44 sm:h-44 rounded-full border-6 sm:border-8 border-indigo-500 shadow-lg overflow-hidden transform transition-transform duration-500 hover:scale-110 flex-shrink-0">
                <a href="<?= $base_url ?>/assets/img/<?= $kandidat['gambar'] ?>" data-lightbox="candidate-image" data-title="<?= htmlspecialchars($kandidat['nama_kandidat']) ?> - <?= htmlspecialchars(explode("-", $kandidat['kode_kandidat'])[1]) ?>">
                    <img
                        src="<?= $base_url ?>/assets/img/<?= $kandidat['gambar'] ?>"
                        alt="<?= htmlspecialchars($kandidat['nama_kandidat']) ?>"
                        class="w-full h-full object-cover"
                        loading="lazy" />
                </a>
            </div>

            <!-- Detail Kandidat -->
            <div class="flex-1 space-y-4 sm:space-y-6 text-center md:text-left">
                <p
                    class="text-gray-700 text-sm sm:text-lg leading-relaxed bg-white p-4 sm:p-6 rounded-xl italic shadow-md border border-gray-200">
                    <?= htmlspecialchars($kandidat['keterangan']) ?>
                </p>

                <div
                    class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 text-xs sm:text-sm text-gray-700 pt-2 sm:pt-3">
                    <div class="flex items-center gap-2 font-semibold justify-center md:justify-start">
                        <i data-lucide="hash" class="text-indigo-500 w-5 h-5 sm:w-6 sm:h-6"></i>
                        <span>ID Kandidat:</span>
                        <span class="text-indigo-600"><?= $kandidat['id_kandidat'] ?></span>
                    </div>
                    <div class="flex items-center gap-2 font-semibold justify-center md:justify-start">
                        <i data-lucide="calendar" class="text-pink-500 w-5 h-5 sm:w-6 sm:h-6"></i>
                        <span>ID Event:</span>
                        <span class="text-pink-600"><?= $kandidat['id_event'] ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Separator -->
    <hr class="my-10 border-t border-gray-300">

    <!-- Statistik dan Grafik -->
    <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100">
        <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center gap-2">
            <i data-lucide="bar-chart-3" class="w-6 h-6 text-indigo-600"></i>
            Statistik Suara
        </h3>
        <h4 class="text-lg text-gray-700 mb-4">Total Suara Masuk: <span class="font-bold text-indigo-600"><?= $jumlah_suara ?></span></h4>
        <div class="relative w-full h-64">
            <canvas id="chartSuaraKandidat"></canvas>
        </div>
    </div>

    <!-- Tombol Kembali -->
    <a href="daftar_kandidat.php?id=<?= $kandidat['id_event'] ?>" class="inline-block mt-8 text-indigo-600 hover:underline text-sm font-medium">&larr; Kembali ke Event</a>
</main>


<script>
    const ctx = document.getElementById('chartSuaraKandidat').getContext('2d');

    const gradient = ctx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, 'rgba(99, 102, 241, 0.9)');
    gradient.addColorStop(1, 'rgba(139, 92, 246, 0.7)');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['<?= htmlspecialchars($kandidat['nama_kandidat']) ?>'],
            datasets: [{
                label: 'Jumlah Suara',
                data: [<?= $jumlah_suara ?>],
                backgroundColor: gradient,
                borderColor: 'rgba(99, 102, 241, 1)',
                borderWidth: 1.5,
                borderRadius: 10,
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
                    bodyColor: '#fff'
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
                },
                x: {
                    ticks: {
                        color: '#4b5563',
                        font: {
                            size: 14,
                            weight: '500'
                        }
                    },
                    grid: {
                        display: false
                    }
                }
            }
        },
        plugins: [ChartDataLabels]
    });
</script>

<?php include '../../../includes/footer.php'; ?>