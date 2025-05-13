<?php
require_once '../../../config/connection.php';
$pageTitle = "Daftar Kandidat";

$id_event = $_GET['id'];
$event = query("SELECT * FROM event WHERE id_event = $id_event")[0];

// Ambil kandidat & total suara per kandidat
$kandidat = query("
    SELECT k.*, 
    (SELECT COUNT(*) FROM pilih p WHERE p.id_kandidat = k.id_kandidat) AS jumlah_suara
    FROM kandidat k
    WHERE k.id_event = $id_event
");

include '../../../includes/header.php';
include '../../../includes/sidebar.php';
?>

<main class="flex-1 p-6 mt-16 md:ml-64">
    <!-- Header Event -->
    <div class="mb-6 flex items-start justify-between flex-wrap gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Daftar Kandidat</h1>
            <p class="text-gray-600 mb-1">Event: <strong><?= htmlspecialchars($event['nama_event']) ?></strong></p>
            <p class="text-gray-500 text-sm">Periode: <?= $event['tgl_mulai'] ?> s/d <?= $event['tgl_selesai'] ?></p>
        </div>
        <div>
            <a href="tambah_kandidat.php?id_event=<?= $id_event ?>"
                class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded-md shadow transition">
                <i data-lucide="plus-circle" class="w-4 h-4"></i>
                Tambah Kandidat
            </a>
        </div>
    </div>


    <!-- Jika tidak ada kandidat -->
    <?php if (empty($kandidat)) : ?>
        <div class="text-gray-600">Belum ada kandidat pada event ini.</div>
    <?php else : ?>
        <!-- Daftar Kandidat -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
            <?php foreach ($kandidat as $k) : ?>
                <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition duration-300 ease-in-out">
                    <?php if ($k['gambar']) : ?>
                        <img src="../../../assets/img/<?= $k['gambar'] ?>" alt="<?= $k['nama_kandidat'] ?>" class="w-full h-48 object-cover rounded-md mb-4">
                    <?php endif; ?>
                    <h2 class="text-lg font-semibold text-gray-800"><?= htmlspecialchars($k['nama_kandidat']) ?></h2>
                    <p class="text-gray-600 mt-2 text-sm whitespace-pre-line"><?= htmlspecialchars($k['keterangan']) ?></p>
                    <p class="text-indigo-600 mt-4 text-sm font-medium">Suara Masuk: <?= $k['jumlah_suara'] ?></p>
                    <a href="detail_kandidat.php?id=<?= $k['id_kandidat'] ?>" class="text-blue-500 hover:underline text-sm mt-2 inline-block">Lihat Detail</a>

                    <div class="mt-4 flex flex-wrap items-center gap-2">
                        <a href="detail_kandidat.php?id=<?= $k['id_kandidat'] ?>"
                            class="inline-flex items-center gap-1 bg-blue-100 text-blue-700 hover:bg-blue-200 px-2 py-1 rounded text-xs font-medium">
                            <i data-lucide="info" class="w-4 h-4"></i> Detail
                        </a>

                        <a href="edit_kandidat.php?id=<?= $k['id_kandidat'] ?>"
                            class="inline-flex items-center gap-1 bg-yellow-100 text-yellow-700 hover:bg-yellow-200 px-2 py-1 rounded text-xs font-medium">
                            <i data-lucide="pencil" class="w-4 h-4"></i> Edit
                        </a>

                        <a href="hapus_kandidat.php?id=<?= $k['id_kandidat'] ?>&id_event=<?= $id_event ?>"
                            onclick="return confirm('Yakin ingin menghapus kandidat ini?')"
                            class="inline-flex items-center gap-1 bg-red-100 text-red-700 hover:bg-red-200 px-2 py-1 rounded text-xs font-medium">
                            <i data-lucide="trash-2" class="w-4 h-4"></i> Hapus
                        </a>
                    </div>


                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- Grafik Suara -->
    <div class="bg-white p-6 rounded-xl shadow-xl max-w-full mx-auto mt-10">
        <h2 class="text-xl font-semibold text-gray-800 mb-6 text-center">Grafik Jumlah Suara Masuk</h2>
        <div class="relative">
            <!-- Atur tinggi grafik lebih kompak -->
            <canvas id="chartSuara" height="100"></canvas>
        </div>
    </div>

</main>

<!-- Ambil data suara untuk grafik -->
<?php
$suaraData = query("
    SELECT k.nama_kandidat, COUNT(p.id_kandidat) AS total_suara
    FROM kandidat k
    LEFT JOIN pilih p ON k.id_kandidat = p.id_kandidat
    WHERE k.id_event = $id_event
    GROUP BY k.id_kandidat
");

$nama_kandidat = [];
$jumlah_suara = [];
foreach ($suaraData as $data) {
    $nama_kandidat[] = $data['nama_kandidat'];
    $jumlah_suara[] = $data['total_suara'];
}
?>

<!-- Grafik dengan Chart.js -->
<script>
    const ctx = document.getElementById('chartSuara').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($nama_kandidat) ?>,
            datasets: [{
                label: 'Jumlah Suara',
                data: <?= json_encode($jumlah_suara) ?>,
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
            },
            layout: {
                padding: {
                    top: 20,
                    left: 20,
                    right: 20,
                    bottom: 20,
                }
            }
        }
    });
</script>

<?php include '../../../includes/footer.php'; ?>