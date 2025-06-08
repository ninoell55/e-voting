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
    <script src="<?= $base_url ?>assets/js/lucide.min.js"></script>

    <link rel="stylesheet" href="<?= $base_url ?>assets/css/animate.min.css" />

    <style>
        .video-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }
    </style>
</head>

<body class="flex flex-col min-h-screen font-sans bg-gradient-to-br from-indigo-100 to-white">

    <!-- Video Latar Belakang -->
    <video class="video-bg" autoplay muted loop>
        <source src="<?= $base_url ?>assets/pictures/login.mp4" type="video/mp4" />
        Browser Anda tidak mendukung tag video.
    </video>

    <!-- Header -->
    <header class="py-8 text-white shadow-lg bg-indigo-500/50">
        <div class="container px-4 mx-auto text-center">
            <img src="<?= $base_url ?>/assets/pictures/logo_smk.png" alt="Logo Sekolah" class="animate__animated animate__fadeInDown w-20 h-20 mx-auto mb-4 drop-shadow-md" />
            <h1 class="animate__animated animate__fadeInDown text-3xl font-bold tracking-wide md:text-4xl">Sistem E-Voting Sekolah</h1>
            <p class="animate__animated animate__tada mt-2 text-sm md:text-base opacity-90">Mudah, Aman, dan Transparan untuk Pemilihan Ketua OSIS, Kelas, dan Jurusan</p>
        </div>
    </header>

    <!-- Konten Utama -->
    <main class="flex items-center justify-center flex-grow px-4 py-16">
        <div class="w-full max-w-5xl p-10 transition-all shadow-xl bg-white/50 rounded-3xl md:p-14">

            <!-- Tentang Sistem -->
            <h2 class="animate__animated animate__jello mb-6 text-2xl font-bold text-center text-indigo-700 md:text-3xl">Tentang Sistem</h2>
            <p class="animate__animated animate__flipInX max-w-2xl mx-auto mb-10 text-base font-semibold text-center text-gray-700 md:text-lg">
                Website ini dirancang untuk mempermudah proses pemilihan di lingkungan sekolah secara elektronik.
                Setiap siswa atau guru dapat memberikan suara secara digital dengan mudah, aman, dan hanya satu kali.
            </p>

            <!-- Fitur Unggulan -->
            <h3 class="animate__animated animate__lightSpeedInLeft mb-4 text-lg font-semibold text-gray-800">Fitur Unggulan:</h3>
            <div class="grid grid-cols-1 gap-6 mb-10 md:grid-cols-2">
                <!-- Fitur 1 -->
                <div class="animate__animated animate__slideInLeft flex items-start gap-4 p-5 transition border border-indigo-100 shadow bg-indigo-50 rounded-2xl hover:shadow-md">
                    <i data-lucide="lock" class="w-6 h-6 mt-1 text-indigo-600"></i>
                    <div>
                        <h4 class="font-semibold text-indigo-700 text-md">Login Aman</h4>
                        <p class="text-sm text-gray-600">Sistem login terpisah antara Admin dan Pemilih dengan validasi ketat.</p>
                    </div>
                </div>
                <!-- Fitur 2 -->
                <div class="animate__animated animate__slideInRight flex items-start gap-4 p-5 transition border border-green-100 shadow bg-green-50 rounded-2xl hover:shadow-md">
                    <i data-lucide="check-circle" class="w-6 h-6 mt-1 text-green-600"></i>
                    <div>
                        <h4 class="font-semibold text-green-700 text-md">Voting Sekali Saja</h4>
                        <p class="text-sm text-gray-600">Setiap pemilih hanya bisa memberikan suara satu kali, mencegah kecurangan.</p>
                    </div>
                </div>
                <!-- Fitur 3 -->
                <div class="animate__animated animate__slideInLeft flex items-start gap-4 p-5 transition border border-yellow-100 shadow bg-yellow-50 rounded-2xl hover:shadow-md">
                    <i data-lucide="bar-chart-3" class="w-6 h-6 mt-1 text-yellow-600"></i>
                    <div>
                        <h4 class="font-semibold text-yellow-700 text-md">Hasil Real-Time</h4>
                        <p class="text-sm text-gray-600">Hasil pemilihan langsung terhitung otomatis dan bisa dilihat setelah voting selesai.</p>
                    </div>
                </div>
                <!-- Fitur 4 -->
                <div class="animate__animated animate__slideInRight flex items-start gap-4 p-5 transition border border-purple-100 shadow bg-purple-50 rounded-2xl hover:shadow-md">
                    <i data-lucide="file-text" class="w-6 h-6 mt-1 text-purple-600"></i>
                    <div>
                        <h4 class="font-semibold text-purple-700 text-md">Riwayat Voting</h4>
                        <p class="text-sm text-gray-600">Pemilih dapat melihat riwayat pemilihan sebelumnya sebagai bukti keikutsertaan.</p>
                    </div>
                </div>
            </div>

            <!-- Tombol Login -->
            <div class="flex flex-col items-center justify-center gap-5 sm:flex-row">
                <a href="login_admin.php"
                    class="animate__animated animate__fadeInLeft animate__slow flex items-center justify-center w-full gap-2 px-6 py-3 text-sm font-semibold text-center text-white transition bg-indigo-600 shadow-md hover:bg-indigo-700 rounded-xl sm:w-auto">
                    <i data-lucide="shield"></i> Login sebagai Admin
                </a>
                <a href="login_user.php"
                    class="animate__animated animate__fadeInRight animate__slow flex items-center justify-center w-full gap-2 px-6 py-3 text-sm font-semibold text-center text-white transition bg-pink-600 shadow-md hover:bg-pink-700 rounded-xl sm:w-auto">
                    <i data-lucide="user"></i> Login sebagai Pemilih
                </a>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="animate__animated animate__fadeIn py-4 text-sm text-center text-gray-600 shadow-inner bg-indigo-100/50">
        &copy; <?= date('Y'); ?> E-Voting Sekolah | Dikembangkan oleh 3 orang siswa kelas X-PPLG 2 SMKN 1 Cirebon
    </footer>

    <!-- Lucide Icon -->
    <script>
        lucide.createIcons();
    </script>
</body>

</html>