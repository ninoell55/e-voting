<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= $pageTitle ?? 'Evoting SMKN 1 CIREBON'; ?></title>

    <!-- ICON-Website -->
    <link rel="icon" type="image/x-icon" href="<?= $base_url ?>assets/img/logo_smk.png" />

    <!-- MyCSS -->
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/output.css">

    <!-- Grafik -->
    <script src="<?= $base_url ?>assets/js/chart.js"></script>

    <!-- Datatables -->
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/dataTables.tailwindcss.css" />
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/responsive.dataTables.min.css" />

    <!-- Icons -->
    <script src="<?= $base_url ?>assets/js/lucide.min.js"></script>

</head>

<body class="bg-gray-100">

    <!-- Navbar -->
    <header class="fixed top-0 left-0 w-full h-16 bg-white shadow-sm z-30 px-6 flex items-center justify-between">
        <!-- Kiri: Logo dan Toggle Sidebar -->
        <div class="flex items-center space-x-4 h-full">
            <button id="sidebarToggle" class="md:hidden h-full flex items-center text-gray-700 hover:text-blue-600 focus:outline-none">
                <i data-lucide="menu"></i>
            </button>
            <h1 class="sm:text-xl font-bold text-blue-600 tracking-wide">SMKN 1 CIREBON</h1>
        </div>

        <!-- Kanan: Search, Notification, Profile -->
        <div class="flex items-center space-x-5">
            <!-- Search Bar -->
            <div class="relative hidden sm:block">
                <input type="text" placeholder="Search..."
                    class="pl-4 pr-10 py-1.5 text-sm text-gray-700 bg-gray-100 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" />
                <button class="absolute right-2 top-1/2 -translate-y-1/2 text-blue-500 hover:text-blue-700 transition">
                    <span class="text-base"><i data-lucide="search"></i></span>
                </button>
            </div>

            <!-- Notification -->
            <div class="relative">
                <span class="text-gray-600 hover:text-gray-800 cursor-pointer"><i data-lucide="bell"></i></span>
                <span class="absolute top-0 right-0 h-2 w-2 bg-red-500 rounded-full ring-2 ring-white"></span>
            </div>

            <!-- Profile -->
            <div class="flex items-center space-x-2 bg-gray-100 text-sm text-gray-800 px-3 py-1 rounded-full cursor-default">
                <span class="text-base text-blue-500"><i data-lucide="user"></i></span>
                <span class="font-medium"><?= ucfirst($_SESSION["username"]) ?></span>
            </div>
        </div>
    </header>