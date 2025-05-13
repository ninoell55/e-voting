<?php
require_once '../../../config/connection.php';
$pageTitle = "Detail Kandidat";

// Ambil detail kandidat berdasarkan ID
$id_kandidat = $_GET['id'];
$kandidat = query("SELECT * FROM kandidat WHERE id_kandidat = $id_kandidat")[0];

// Hitung jumlah suara yang diterima kandidat ini
$jumlah_suara = query("SELECT COUNT(*) as total FROM pilih WHERE id_kandidat = $id_kandidat")[0]['total'];

include '../../../includes/header.php';
include '../../../includes/sidebar.php';
?>

<main class="flex-1 p-6 mt-16 md:ml-64 max-w-5xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Detail Kandidat</h1>
    </div>

    <!-- Kartu Profil Kandidat -->
    <div class="bg-white rounded-xl shadow-md p-6 flex flex-col md:flex-row gap-6 items-start">
        <img src="../../../assets/img/<?= $kandidat['gambar'] ?>" alt="<?= htmlspecialchars($kandidat['nama_kandidat']) ?>" class="w-full md:w-60 h-auto object-cover rounded-lg border">

        <div class="flex-1">
            <h2 class="text-2xl font-bold text-gray-800 mb-2"><?= htmlspecialchars($kandidat['nama_kandidat']) ?></h2>
            <p class="text-gray-600 mb-4 whitespace-pre-line"><?= htmlspecialchars($kandidat['keterangan']) ?></p>
            <div class="text-sm text-gray-500 space-y-1">
                <p><span class="font-medium text-gray-700">ID Kandidat:</span> <?= $kandidat['id_kandidat'] ?></p>
                <p><span class="font-medium text-gray-700">ID Event:</span> <?= $kandidat['id_event'] ?></p>
            </div>
        </div>
    </div>

    <!-- Separator -->
    <hr class="my-8 border-t border-gray-200">

    <!-- Statistik dan Grafik -->
    <h3 class="text-xl font-semibold text-gray-700 mb-4">Statistik Suara</h3>
    <div class="bg-white rounded-xl shadow-md p-6">
        <h4 class="text-lg text-gray-800 mb-2">Total Suara Masuk: <?= $jumlah_suara ?></h4>
        <div class="relative">
            <canvas id="chartSuaraKandidat" height="100"></canvas>
        </div>
    </div>

    <!-- Tombol Kembali -->
    <a href="daftar_kandidat.php?id=<?= $kandidat['id_event'] ?>" class="inline-block mt-6 text-blue-600 hover:underline text-sm">&larr; Kembali ke Event</a>
</main>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('chartSuaraKandidat').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['<?= htmlspecialchars($kandidat['nama_kandidat']) ?>'],
            datasets: [{
                label: 'Jumlah Suara',
                data: [<?= $jumlah_suara ?>],
                backgroundColor: 'rgba(99, 102, 241, 0.7)',
                borderColor: 'rgba(99, 102, 241, 1)',
                borderWidth: 1,
                borderRadius: 8,
                hoverBackgroundColor: 'rgba(99, 102, 241, 0.8)',
                hoverBorderColor: 'rgba(99, 102, 241, 1)',
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0,
                    }
                }
            },
            plugins: {
                legend: {
                    display: false,
                },
            }
        }
    });
</script>

<?php include '../../../includes/footer.php'; ?>