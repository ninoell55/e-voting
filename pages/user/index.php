<?php
require_once '../../config/connection.php';

if (isset($_SESSION['login_admin'])) {
    header("Location: ../admin/index.php");
    exit;
} elseif(!isset($_SESSION['login_user'])) {
    header("Location: ../../auth/login_user.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman User</title>
    <link href="<?= $base_url ?>assets/css/output.css" rel="stylesheet">
</head>

<body class="bg-gray-100 min-h-screen">

    <!-- Header -->
    <header class="bg-white shadow p-4 flex justify-between items-center">
        <h1 class="text-xl font-bold text-indigo-600">Halaman User</h1>
        <div class="text-sm text-gray-600">Hai, <?= $_SESSION['nama_lengkap'] ?> | <a href="../../auth/logout_user.php" class="text-red-500 hover:underline">Logout</a></div>
    </header>

    <!-- Contoh aja ges -->
    <!-- <main class="p-6 space-y-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white p-4 rounded-lg shadow text-center">
                <h2 class="text-lg font-semibold text-gray-700">Jumlah Pemilih</h2>
                <p class="text-2xl font-bold text-indigo-600">123</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow text-center">
                <h2 class="text-lg font-semibold text-gray-700">Jumlah Kandidat</h2>
                <p class="text-2xl font-bold text-indigo-600">5</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow text-center">
                <h2 class="text-lg font-semibold text-gray-700">Total Suara Masuk</h2>
                <p class="text-2xl font-bold text-indigo-600">87</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow text-center">
                <h2 class="text-lg font-semibold text-gray-700">Status Voting</h2>
                <p class="text-xl font-bold text-green-500">Berlangsung</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-lg font-semibold mb-4 text-gray-700">Navigasi Cepat</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                <a href="#" class="p-3 bg-indigo-100 hover:bg-indigo-200 rounded text-center font-medium text-indigo-700">Kelola Kandidat</a>
                <a href="#" class="p-3 bg-indigo-100 hover:bg-indigo-200 rounded text-center font-medium text-indigo-700">Kelola Pemilih</a>
                <a href="#" class="p-3 bg-indigo-100 hover:bg-indigo-200 rounded text-center font-medium text-indigo-700">Laporan Hasil</a>
                <a href="#" class="p-3 bg-indigo-100 hover:bg-indigo-200 rounded text-center font-medium text-indigo-700">Pengaturan Voting</a>
                <a href="#" class="p-3 bg-indigo-100 hover:bg-indigo-200 rounded text-center font-medium text-indigo-700">Reset Suara</a>
            </div>
        </div>
    </main> -->
    <!-- Contoh aja ges -->

</body>

</html>