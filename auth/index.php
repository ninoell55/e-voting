<?php
require_once '../config/connection.php';

if (isset($_SESSION['login_admin'])) {
    header("Location: ../pages/admin/index.php");
    exit;
} elseif (isset($_SESSION['login_user'])) {
    header("Location: ../pages/user/index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
    <link href="<?= $base_url ?>assets/css/output.css" rel="stylesheet">
</head>

<body class="bg-gradient-to-br from-indigo-50 to-white min-h-screen flex flex-col">

    <!-- Header dengan Logo -->
    <header class="bg-indigo-500 text-white p-6 shadow-md">
        <div class="container mx-auto text-center">
            <img src="../assets/img/logo_smk.png" alt="Logo Sekolah" class="mx-auto w-20 h-20 mb-3" />
            <h1 class="text-3xl md:text-4xl font-bold">Sistem E-Voting Sekolah</h1>
            <p class="text-sm md:text-base mt-2">Mudah, Aman, dan Transparan untuk Pemilihan Ketua OSIS, Kelas, dan Jurusan</p>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow flex items-center justify-center px-4 py-12">
        <div class="max-w-4xl w-full bg-white rounded-2xl shadow-lg p-8 text-center">

            <h2 class="text-2xl font-semibold text-indigo-700 mb-4">Tentang Sistem</h2>
            <p class="text-gray-700 mb-6 text-sm md:text-base">
                Website ini dirancang untuk mempermudah proses pemilihan di lingkungan sekolah secara elektronik. Setiap siswa atau guru bisa memberikan suara secara digital dengan mudah dan aman.
            </p>

            <!-- Fitur Unggulan Grid -->
            <!-- Fitur Unggulan Cards -->
            <div class="mb-8">
                <h3 class="text-lg font-medium text-gray-800 mb-6">Fitur Unggulan:</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">

                    <!-- Card 1 -->
                    <div class="bg-blue-50 border border-blue-100 p-5 rounded-xl shadow-sm hover:shadow-md transition">
                        <div class="text-3xl mb-2">🔐</div>
                        <h4 class="text-md font-semibold text-blue-800 mb-1">Login Aman</h4>
                        <p class="text-sm text-gray-600">Sistem login terpisah antara Admin dan Pemilih dengan validasi ketat.</p>
                    </div>

                    <!-- Card 2 -->
                    <div class="bg-green-50 border border-green-100 p-5 rounded-xl shadow-sm hover:shadow-md transition">
                        <div class="text-3xl mb-2">🗳️</div>
                        <h4 class="text-md font-semibold text-green-800 mb-1">Voting Sekali Saja</h4>
                        <p class="text-sm text-gray-600">Setiap pemilih hanya bisa memberikan suara satu kali, mencegah kecurangan.</p>
                    </div>

                    <!-- Card 3 -->
                    <div class="bg-yellow-50 border border-yellow-100 p-5 rounded-xl shadow-sm hover:shadow-md transition">
                        <div class="text-3xl mb-2">📊</div>
                        <h4 class="text-md font-semibold text-yellow-800 mb-1">Hasil Real-Time</h4>
                        <p class="text-sm text-gray-600">Hasil pemilihan langsung terhitung otomatis dan bisa dilihat setelah voting selesai.</p>
                    </div>

                    <!-- Card 4 -->
                    <div class="bg-purple-50 border border-purple-100 p-5 rounded-xl shadow-sm hover:shadow-md transition">
                        <div class="text-3xl mb-2">📄</div>
                        <h4 class="text-md font-semibold text-purple-800 mb-1">Laporan Otomatis</h4>
                        <p class="text-sm text-gray-600">Laporan hasil pemilihan dapat dicetak sebagai arsip dalam bentuk PDF atau Excel.</p>
                    </div>

                </div>
            </div>

            <!-- Tombol Login -->
            <div class="flex flex-col md:flex-row justify-center gap-4 mt-6">
                <a href="login_admin.php">
                    <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg w-full md:w-auto transition">
                        Login Admin
                    </button>
                </a>
                <a href="login_user.php">
                    <button class="bg-pink-600 hover:bg-pink-700 text-white px-6 py-3 rounded-lg w-full md:w-auto transition">
                        Login Pemilih
                    </button>
                </a>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-indigo-100 text-center text-gray-600 text-sm py-4">
        &copy; <?= date('Y'); ?> E-Voting Sekolah | Dikembangkan oleh Tim RPL
    </footer>
</body>

</html>