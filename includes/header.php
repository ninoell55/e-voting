<?php
// Deteksi siapa yang login dan ambil nama sesuai tabel
if (isset($_SESSION['login_admin'])) {
    $name = $_SESSION['username']; // dari tabel admin, gunakan kolom `username`
    $role = $_SESSION['role'] ?? 'Admin'; // jika kamu simpan role
} elseif (isset($_SESSION['login_user'])) {
    $name = $_SESSION['nama_lengkap']; // dari tabel pemilih
    $role = 'Pemilih';
} else {
    $name = 'Guest';
    $role = '';
}

// Ambil huruf awal nama
$initial = strtoupper(substr($name, 0, 1));

date_default_timezone_set('Asia/Jakarta'); // Pastikan zona waktu sesuai

$hour = date('H');

if ($hour >= 5 && $hour < 12) {
    $greeting = 'Selamat pagi';
} elseif ($hour >= 12 && $hour < 15) {
    $greeting = 'Selamat siang';
} elseif ($hour >= 15 && $hour < 18) {
    $greeting = 'Selamat sore';
} else {
    $greeting = 'Selamat malam';
}
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= $pageTitle ?? 'Evoting SMKN 1 CIREBON'; ?></title>

    <!-- ICON-Website -->
    <link rel="icon" type="image/x-icon" href="<?= $base_url ?>assets/pictures/logo_smk.png" />

    <!-- MyCSS -->
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/output.css">

    <!-- Grafik -->
    <script src="<?= $base_url ?>assets/js/chart.js"></script>
    <script src="<?= $base_url; ?>assets/js/chartjs-plugin-datalabels@2.js"></script>

    <!-- Datatables -->
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/dataTables.tailwindcss.css" />
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/responsive.dataTables.min.css" />

    <!-- Icons -->
    <script src="<?= $base_url ?>assets/js/lucide.min.js"></script>

    <!-- Sweet-Alert -->
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/sweetalert2.min.css">

    <!-- Animate.css -->
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/animate.min.css" />

    <!-- AOS -->
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/aos.css">

    <!-- Lightbox -->
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/lightbox.min.css">

    <style>
        @keyframes slideDownFade {
            0% {
                opacity: 0;
                transform: translateY(-10px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-slide-down-fade {
            animation: slideDownFade 0.2s ease-out;
        }
    </style>

</head>

<body class="bg-gray-100">

    <!-- Navbar -->
    <header class="fixed top-0 left-0 z-30 flex items-center justify-between w-full h-16 px-6 transition-all duration-300 bg-white backdrop-blur">
        <!-- Logo & Nama -->
        <div class="flex items-center h-full gap-3">
            <?php if (isset($_SESSION["login_admin"])): ?>
                <button id="sidebarToggle" class="flex items-center h-full text-gray-700 transition duration-200 md:hidden hover:text-blue-600 focus:outline-none">
                    <i data-lucide="menu" class="w-5 h-5"></i>
                </button>
            <?php endif; ?>

            <a href="<?= $base_url ?>pages/admin/index.php" class="flex items-center gap-2 group">
                <img src="<?= $base_url ?>assets/pictures/logo_smk.png" alt="Logo SMKN 1 Cirebon"
                    class="object-cover w-10 h-10 transition duration-300 rounded-full shadow-sm group-hover:scale-110" />
                <span class="text-lg font-extrabold tracking-wide text-blue-700 transition-all duration-300 sm:text-xl group-hover:text-blue-900">SMKN 1 CIREBON</span>
            </a>
        </div>

        <!-- Profile -->
        <div class="relative">
            <button onclick="toggleProfileMenu()" class="flex items-center gap-3 px-4 py-2 transition-transform duration-200 hover:scale-[1.02] active:scale-[0.98] bg-white border border-gray-200 rounded-full shadow-sm hover:shadow-md group">
                <div class="relative">
                    <div class="flex items-center justify-center text-base font-bold text-white uppercase rounded-full shadow-inner w-9 h-9 bg-gradient-to-br from-blue-600 to-blue-500">
                        <?= $initial ?>
                    </div>
                    <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></span>
                </div>
                <div class="flex-col hidden leading-tight text-left transition-all duration-300 sm:flex">
                    <span class="text-sm font-semibold text-gray-800 group-hover:text-blue-600"><?= ucfirst($name) ?></span>
                    <span class="text-xs text-gray-500"><?= $role ?></span>
                </div>
                <i id="chevronIcon" data-lucide="chevron-down" class="w-4 h-4 text-gray-400 transition-transform duration-300"></i>
            </button>

            <!-- Dropdown -->
            <div id="profileDropdown" class="absolute right-0 z-50 hidden w-64 mt-3 bg-white shadow-xl rounded-xl ring-1 ring-black/10 animate-slide-down-fade">
                <div class="px-4 py-4 border-b border-gray-100 bg-gray-50">
                    <div class="flex items-center gap-3">
                        <div class="flex items-center justify-center w-10 h-10 text-lg font-bold text-white uppercase bg-blue-600 rounded-full">
                            <?= $initial ?>
                        </div>
                        <div>
                            <span class="text-[11px] text-blue-500"><?= $greeting ?>,</span>
                            <p class="text-sm font-semibold text-gray-900"><?= ucfirst($name) ?></p>
                            <p class="text-xs text-gray-500"><?= $role ?></p>
                        </div>
                    </div>
                </div>
                <a href="<?= $base_url ?>auth/<?= isset($_SESSION['login_admin']) ? 'logout_admin' : 'logout_user' ?>.php"
                    class="flex items-center gap-2 px-4 py-3 text-sm font-medium text-red-600 transition-all duration-200 hover:bg-red-50 btn-logout">
                    <i data-lucide="log-out" class="w-4 h-4"></i>
                    Logout
                </a>
            </div>
        </div>
    </header>



    <script>
        function toggleProfileMenu() {
            const dropdown = document.getElementById('profileDropdown');
            const chevron = document.getElementById('chevronIcon');
            const isHidden = dropdown.classList.contains('hidden');

            dropdown.classList.toggle('hidden');

            if (!isHidden) {
                chevron.classList.remove('rotate-180');
            } else {
                chevron.classList.add('rotate-180');
            }
        }

        document.addEventListener('click', function(e) {
            const trigger = e.target.closest('button[onclick="toggleProfileMenu()"]');
            const dropdown = document.getElementById('profileDropdown');
            const chevron = document.getElementById('chevronIcon');

            if (!trigger && !e.target.closest('#profileDropdown')) {
                dropdown.classList.add('hidden');
                chevron.classList.remove('rotate-180');
            }
        });
    </script>