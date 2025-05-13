<?php
require_once '../../config/connection.php';
$pageTitle = "Dashboard";

// Cek login session
if (isset($_SESSION['login_user'])) {
    header("Location: ../user/index.php");
    exit;
} elseif (!isset($_SESSION['login_admin'])) {
    header("Location: ../../auth/login_admin.php");
    exit;
}

// Ambil data jumlah untuk statistik
$jumlahEvent = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM event"))['total'];
$jumlahKandidat = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM kandidat"))['total'];
$jumlahPemilih = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM pemilih"))['total'];
$jumlahVote = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM pilih"))['total'];

include '../../includes/header.php';
?>

<div class="flex">
    <?php include '../../includes/sidebar.php'; ?>

    <main id="mainContent" class="flex-1 bg-gray-100 p-6 mt-16 md:ml-64 transition-all duration-300">
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

        <!-- Card Section -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Card 1: Jumlah Pemilih -->
            <div class="bg-gradient-to-r from-white to-gray-100 border border-gray-200 rounded-2xl shadow-md p-6 hover:shadow-lg transition-shadow duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-sm font-medium text-gray-600 mb-1">Jumlah Pemilih</h2>
                        <p class="text-3xl font-bold text-blue-600"><?= $jumlahPemilih; ?></p>
                    </div>
                    <div class="text-blue-500 bg-blue-100 p-3 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87M16 3.13a4 4 0 010 7.75M8 3.13a4 4 0 000 7.75" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Card 2: Jumlah Kandidat -->
            <div class="bg-gradient-to-r from-white to-gray-100 border border-gray-200 rounded-2xl shadow-md p-6 hover:shadow-lg transition-shadow duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-sm font-medium text-gray-600 mb-1">Jumlah Kandidat</h2>
                        <p class="text-3xl font-bold text-green-600"><?= $jumlahKandidat; ?></p>
                    </div>
                    <div class="text-green-500 bg-green-100 p-3 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 11c0-1.104.896-2 2-2s2 .896 2 2a2 2 0 01-4 0zm0 4h4v2h-4v-2zM6 11c0-1.104.896-2 2-2s2 .896 2 2a2 2 0 01-4 0zm0 4h4v2H6v-2z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Card 3: Total Voting Masuk -->
            <div class="bg-gradient-to-r from-white to-gray-100 border border-gray-200 rounded-2xl shadow-md p-6 hover:shadow-lg transition-shadow duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-sm font-medium text-gray-600 mb-1">Total Voting Masuk</h2>
                        <p class="text-3xl font-bold text-purple-600"><?= $jumlahVote; ?></p>
                    </div>
                    <div class="text-purple-500 bg-purple-100 p-3 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6M9 16h6M13 8h2M4 6h16M4 10h16M4 14h16M4 18h16" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Card 4: Jumlah Event -->
            <div class="bg-gradient-to-r from-white to-gray-100 border border-gray-200 rounded-2xl shadow-md p-6 hover:shadow-lg transition-shadow duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-sm font-medium text-gray-600 mb-1">Jumlah Event</h2>
                        <p class="text-3xl font-bold text-red-600"><?= $jumlahEvent; ?></p>
                    </div>
                    <div class="text-red-500 bg-red-100 p-3 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3M5 11h14M5 19h14M3 5h18a2 2 0 012 2v14a2 2 0 01-2 2H3a2 2 0 01-2-2V7a2 2 0 012-2z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grafik atau Statistik -->
        <div class="mt-8">
            <div class="bg-white rounded-2xl shadow p-6">
                <h2 class="text-lg font-semibold text-gray-700 mb-4">Statistik Voting per Kandidat</h2>
                <div class="relative w-full" style="height: 400px;">
                    <canvas id="votingChart"></canvas>
                </div>
            </div>
        </div>

    </main>
</div>
<?php include '../../includes/footer.php'; ?>