<?php
require_once "config/connection.php";

if (isset($_SESSION['login_admin'])) {
    header("Location: pages/admin/index.php");
    exit;
} elseif (isset($_SESSION['login_user'])) {
    header("Location: pages/user/index.php");
    exit;
}
?>
<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- MyCSS -->
    <link href="<?= $base_url ?>assets/css/output.css" rel="stylesheet">
    <title>SELAMAT DATANG</title>
    <!-- Icon Lucide -->
    <script src="<?= $base_url ?>assets/js/lucide.min.js"></script>
    <!-- Animate.CSS -->
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/animate.min.css" />
    <!-- AOS -->
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/aos.css">
    <!-- Lightbox -->
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/lightbox.min.css">

    <style>
        * {
            scroll-behavior: smooth;
        }

        @media (max-width: 768px) {
            [data-aos] {
                opacity: 1 !important;
                transform: none !important;
            }
        }
    </style>
</head>

<body>

    <!-- ========== HEADER ========== -->
    <header class="fixed top-0 left-0 w-full bg-white shadow-xs z-100">
        <div class="relative z-20 border-b lg:border-none">
            <div class="px-6 md:px-12 lg:container lg:mx-auto xl:px-40 lg:py-6">
                <div class="flex items-center justify-between">
                    <!-- Logo -->
                    <div class="relative z-20">
                        <a class="animate__animated animate__fadeInLeft block text-2xl font-extrabold text-blue-800 transition-transform duration-300 font-bebas lg:text-3xl -tracking-widest hover:-translate-y-1"
                            href="#">
                            E-Voting<span class="text-blue-500">System</span>
                            <img class="inline h-8" src="<?= $base_url ?>assets/pictures/logo_smk.png" alt="Logo">
                        </a>
                    </div>

                    <!-- Hamburger Menu -->
                    <div class="flex items-center justify-end border-l lg:border-l-0">
                        <input type="checkbox" name="hamburger" id="hamburger" class="hidden peer">
                        <label for="hamburger"
                            class="relative z-20 block p-6 -mr-6 cursor-pointer peer-checked:hamburger lg:hidden">
                            <div aria-hidden="true" class="m-auto h-0.5 w-6 rounded bg-blue-800 transition duration-300"></div>
                            <div aria-hidden="true" class="m-auto mt-2 h-0.5 w-6 rounded bg-blue-800 transition duration-300"></div>
                        </label>

                        <!-- Mobile Menu & Desktop Menu -->
                        <div
                            class="peer-checked:translate-x-0 fixed inset-0 w-[calc(100%-4.5rem)] translate-x-[-100%] border-r shadow-xl transition duration-300 lg:border-r-0 lg:w-auto lg:static lg:shadow-none lg:translate-x-0 bg-white lg:bg-transparent">
                            <div class="flex flex-col justify-between h-full lg:items-center lg:flex-row">
                                <!-- Navigation Links -->
                                <ul
                                    class="px-6 pt-32 space-y-8 text-blue-900 md:px-12 lg:space-y-0 lg:flex lg:space-x-12 lg:pt-0">
                                    <li class="animate__animated animate__fadeInDown">
                                        <a href="#"
                                            class="relative group before:absolute before:inset-x-0 before:bottom-0 before:h-2 before:bg-blue-100">
                                            <span class="relative text-blue-600">Home</span>
                                        </a>
                                    </li>
                                    <li class="animate__animated animate__fadeInUp">
                                        <a href="#how"
                                            class="relative text-blue-900 transition pb-1 before:content-[''] before:absolute before:bottom-0 before:left-0 before:w-0 before:h-[1px] before:bg-blue-800 before:transition-all before:duration-300 hover:before:w-full">
                                            How?
                                        </a>
                                    </li>
                                    <li class="animate__animated animate__fadeInDown">
                                        <a href="#why"
                                            class="relative text-blue-900 transition pb-1 before:content-[''] before:absolute before:bottom-0 before:left-0 before:w-0 before:h-[1px] before:bg-blue-800 before:transition-all before:duration-300 hover:before:w-full">
                                            Why?
                                        </a>
                                    </li>
                                    <li class="animate__animated animate__fadeInUp">
                                        <a href="#about"
                                            class="relative text-blue-900 transition pb-1 before:content-[''] before:absolute before:bottom-0 before:left-0 before:w-0 before:h-[1px] before:bg-blue-800 before:transition-all before:duration-300 hover:before:w-full">
                                            About
                                        </a>
                                    </li>
                                </ul>

                                <!-- Tombol Logout -->
                                <div
                                    class="px-6 py-8 border-t md:px-12 md:py-16 lg:border-t-0 lg:border-l animate__animated animate__fadeInRight lg:py-0 lg:pr-0 lg:pl-6">
                                    <a href="https://wa.me/6287740864657" target="_blank"
                                        class="animate__animated animate__fadeInRight block px-6 py-3 text-sm font-medium text-center text-white transition-all duration-300 transform bg-blue-600 rounded-md hover:bg-blue-500 lg:hover:scale-110">
                                        Kontak Kami
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end menu container -->
                </div>
            </div>
        </div>
    </header>
    <!-- ========== HEADER-end ========== -->


    <!-- ========== HERO ========== -->
    <section class="flex items-center py-16 bg-white min-h-screen sm:py-24 lg:py-64">
        <div class="w-screen max-w-screen-xl px-4 py-16 mx-auto sm:px-6 sm:py-24 lg:px-8 lg:py-32">
            <div class="mx-auto text-center max-w-prose">
                <h1 class="animate__animated animate__jackInTheBox text-4xl font-bold text-gray-900 sm:text-5xl">
                    Selamat Datang di Website
                    <strong class="text-blue-600"> E-Voting. </strong>
                </h1>

                <p class="animate__animated animate__zoomInUp mt-4 text-base text-gray-700 text-pretty sm:text-lg/relaxed">
                    Login untuk mulai memilih. Gunakan hak suara Anda dengan bijak!
                </p>

                <div class="flex justify-center gap-4 mt-4 sm:mt-6">
                    <a
                        class="animate__animated animate__fadeInBottomLeft inline-block px-5 py-3 font-medium text-white transition-colors bg-blue-600 border border-blue-600 rounded shadow-sm hover:bg-blue-700"
                        href="auth/">
                        Login
                    </a>

                    <a
                        class="animate__animated animate__fadeInBottomRight inline-block px-5 py-3 font-medium text-gray-700 transition-colors border border-gray-200 rounded shadow-sm hover:bg-gray-50 hover:text-gray-900"
                        href="#footer">
                        Learn More
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!-- ========== HERO-end ========== -->


    <!-- ========== SECOND HERO ========== -->
    <section id="secondHero" class="p-10 bg-blue-100 dark:bg-blue-900 md:p-24">
        <div
            class="flex items-center justify-center min-h-full p-10 overflow-hidden text-black bg-white shadow-2xl sm:p-10 rounded-3xl dark:bg-gray-900 dark:text-white">
            <div class="w-full max-w-6xl px-4 sm:px-6">
                <div class="grid grid-cols-1 gap-8 md:grid-cols-2">

                    <!-- Kiri: Teks -->
                    <div class="z-10 flex flex-col justify-center text-center md:text-left">
                        <h1 data-aos="flip-up"
                            class="text-4xl font-extrabold leading-tight tracking-tight uppercase sm:text-4xl md:text-5xl lg:text-7xl">
                            Sistem <span class="text-blue-600">E-Voting</span> Digital
                        </h1>
                        <p data-aos="fade-right" class="mt-4 text-base font-medium text-gray-700 sm:text-lg md:text-xl dark:text-gray-400 text-balance">
                            Proses pemilihan kini lebih mudah, cepat, dan transparan. Jadilah bagian dari perubahan teknologi di lingkungan sekolah!
                        </p>
                        <div class="flex flex-wrap gap-4 mt-6 sm:mt-8">
                            <a data-aos="fade-right" href="#about"
                                class="p-3 text-sm font-bold tracking-widest text-center text-white uppercase transition bg-blue-600 rounded-sm grow hover:bg-blue-700">
                                Tentang Kami
                            </a>
                            <a data-aos="fade-left" href="https://wa.me/6287740864657" target="_blank"
                                class="p-3 text-sm font-bold tracking-widest text-center text-blue-600 uppercase transition border border-blue-600 rounded-sm grow hover:bg-blue-600 hover:text-white">
                                Hubungi Kami
                            </a>
                        </div>
                    </div>

                    <!-- Kanan: Desain -->
                    <div data-aos="zoom-in-down" class="relative flex items-center sm:m-10">
                        <div
                            class="absolute bg-blue-600 border-b-4 border-r-8 border-blue-800 rounded-lg -top-10 md:-top-20 -left-10 sm:w-32 sm:h-32 lg:w-64 lg:h-64 rotate-12 max-sm:hidden">
                        </div>
                        <div
                            class="relative z-10 p-4 text-center -translate-x-1/2 bg-gray-800 border-b-4 border-r-8 shadow-2xl dark:bg-gray-800 sm:p-6 -right-1/2 grow -rotate-2 rounded-xl text-nowrap border-slate-950">
                            <h2 class="text-2xl font-bold uppercase sm:text-3xl text-gray-50 dark:text-gray-50">
                                Voting. Digital. Aman.
                            </h2>
                            <p class="mt-1 text-sm font-light text-gray-400 sm:text-base dark:text-gray-400">
                                Satu suara untuk masa depan yang lebih baik!
                            </p>
                        </div>
                        <div
                            class="absolute bg-blue-600 border-b-8 border-r-4 border-blue-800 rounded-lg -bottom-10 md:-bottom-20 -right-16 sm:w-32 sm:h-32 lg:w-64 lg:h-64 -rotate-12 max-sm:hidden">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ========== SECOND HERO-end ========== -->


    <!-- ========== HOW? ========== -->
    <section id="how" class="bg-white lg:pt-28">
        <div class="container px-6 py-10 mx-auto">
            <div class="lg:flex lg:items-center lg:space-x-16">

                <!-- Kiri -->
                <div class="w-full space-y-12 lg:w-1/2">
                    <div>
                        <h1 data-aos="fade-right" class="text-3xl font-bold text-gray-800 lg:text-4xl">
                            Apa Itu E-Voting & <br> Bagaimana Cara Memilih?
                        </h1>

                        <p data-aos="fade-left" class="mt-4 text-justify text-gray-600">
                            <span class="font-semibold text-blue-700">E-Voting</span> adalah sistem pemilihan suara berbasis digital yang memungkinkan pemilih memberikan suaranya secara elektronik melalui perangkat yang terhubung ke sistem.
                        </p>

                        <p data-aos="fade-right" class="mt-6 text-justify text-gray-600">
                            Sistem ini meningkatkan efisiensi, transparansi, dan keamanan dalam proses pemungutan suara. E-Voting sangat cocok untuk pemilihan ketua OSIS, ketua jurusan, atau pemilihan internal lainnya.
                        </p>

                        <div class="flex mt-6 space-x-2">
                            <span class="inline-block w-32 h-1 bg-blue-600 rounded-full"></span>
                            <span class="inline-block w-6 h-1 bg-blue-600 rounded-full"></span>
                            <span class="inline-block w-2 h-1 bg-blue-600 rounded-full"></span>
                        </div>
                    </div>

                    <!-- Langkah-langkah -->
                    <div class="space-y-8">
                        <div class="flex items-start space-x-4">
                            <div data-aos="fade-right" class="p-3 text-blue-600 bg-blue-100 rounded-xl">
                                <i data-lucide="log-in" class="w-6 h-6"></i>
                            </div>
                            <div>
                                <h2 data-aos="flip-up" class="text-xl font-semibold text-gray-700">Langkah 1: Login</h2>
                                <p data-aos="flip-down" class="mt-2 text-gray-500">Masukkan NIS dan password yang telah diberikan untuk mengakses sistem e-voting.</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div data-aos="fade-right" class="p-3 text-blue-600 bg-blue-100 rounded-xl">
                                <i data-lucide="calendar-days" class="w-6 h-6"></i>
                            </div>
                            <div>
                                <h2 data-aos="flip-up" class="text-xl font-semibold text-gray-700">Langkah 2: Pilih Event</h2>
                                <p data-aos="flip-down" class="mt-2 text-gray-500">Setelah berhasil login, pilih event pemilihan yang tersedia, misalnya Pemilihan Ketua OSIS.</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div data-aos="fade-right" class="p-3 text-blue-600 bg-blue-100 rounded-xl">
                                <i data-lucide="users" class="w-6 h-6"></i>
                            </div>
                            <div>
                                <h2 data-aos="flip-up" class="text-xl font-semibold text-gray-700">Langkah 3: Pilih Kandidat</h2>
                                <p data-aos="flip-down" class="mt-2 text-gray-500">Lihat profil kandidat, lalu pilih salah satu dengan mengklik tombol “Pilih” pada kandidat yang diinginkan.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kanan -->
                <div data-aos="zoom-in-up" class="relative items-center justify-center hidden lg:flex lg:w-1/2 group">
                    <img class="w-[28rem] h-[28rem] xl:w-[34rem] xl:h-[34rem] object-cover rounded-full grayscale group-hover:grayscale-0 transition-all duration-500"
                        src="<?= $base_url ?>assets/pictures/bg-how.jpeg"
                        alt="Ilustrasi E-Voting" />
                    <div
                        class="absolute inset-0 flex items-center justify-center text-center transition-opacity duration-500 rounded-full opacity-0 bg-white/80 backdrop-blur-sm group-hover:opacity-100">
                        <div>
                            <p class="text-4xl font-extrabold leading-tight text-blue-600 font-bebas">E-Voting</p>
                            <p class="mt-1 text-lg font-medium text-gray-800">Mudah, Cepat, Aman</p>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="my-12 border-gray-200">
        </div>
    </section>
    <!-- ========== HOW?-end ========== -->


    <!-- ========== WHY? ========== -->
    <section id="why" class="py-20 bg-blue-50">
        <div class="container px-6 mx-auto">
            <div class="mb-12 text-center">
                <h2 data-aos="fade-down" class="text-3xl font-bold text-gray-800 lg:text-4xl">Mengapa E-Voting?</h2>
                <p data-aos="fade-up" class="max-w-2xl mx-auto mt-4 text-gray-600">
                    E-Voting menghadirkan solusi pemilihan yang <span class="font-semibold text-blue-600">efisien, aman, dan transparan</span>. Berikut alasan mengapa kamu harus menggunakannya!
                </p>
                <div data-aos="fade-right" data-aos-delay="500" class="flex justify-center mt-4">
                    <span class="inline-block w-32 h-1 bg-blue-600 rounded-full"></span>
                    <span class="inline-block w-3 h-1 ml-1 bg-blue-600 rounded-full"></span>
                    <span class="inline-block w-1 h-1 ml-1 bg-blue-600 rounded-full"></span>
                </div>
            </div>

            <div class="grid gap-10 md:grid-cols-2 lg:grid-cols-3">
                <!-- Card 1 -->
                <div data-aos="flip-right" class="p-6 transition bg-white shadow-md rounded-2xl hover:shadow-lg">
                    <div class="flex items-center justify-center w-16 h-16 mb-4 bg-blue-100 rounded-full">
                        <i data-lucide="shield-check" class="w-8 h-8 text-blue-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800">Aman & Terjamin</h3>
                    <p class="mt-2 text-gray-600">
                        Sistem dilengkapi autentikasi pengguna, hanya yang berhak bisa memilih.
                    </p>
                </div>

                <!-- Card 2 -->
                <div data-aos="flip-right" data-aos-delay="300" class="p-6 transition bg-white shadow-md rounded-2xl hover:shadow-lg">
                    <div class="flex items-center justify-center w-16 h-16 mb-4 bg-blue-100 rounded-full">
                        <i data-lucide="clock" class="w-8 h-8 text-blue-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800">Hemat Waktu</h3>
                    <p class="mt-2 text-gray-600">
                        Proses pemungutan suara bisa dilakukan dalam hitungan detik dari mana saja.
                    </p>
                </div>

                <!-- Card 3 -->
                <div data-aos="flip-right" data-aos-delay="500" class="p-6 transition bg-white shadow-md rounded-2xl hover:shadow-lg">
                    <div class="flex items-center justify-center w-16 h-16 mb-4 bg-blue-100 rounded-full">
                        <i data-lucide="bar-chart-3" class="w-8 h-8 text-blue-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800">Hasil Real-time</h3>
                    <p class="mt-2 text-gray-600">
                        Perolehan suara langsung terdata dan bisa dilihat secara real-time.
                    </p>
                </div>

                <!-- Card 4 -->
                <div data-aos="flip-left" data-aos-delay="700" class="p-6 transition bg-white shadow-md rounded-2xl hover:shadow-lg">
                    <div class="flex items-center justify-center w-16 h-16 mb-4 bg-blue-100 rounded-full">
                        <i data-lucide="users" class="w-8 h-8 text-blue-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800">Mudah Digunakan</h3>
                    <p class="mt-2 text-gray-600">
                        Tampilan sistem user-friendly memudahkan siswa dalam memilih.
                    </p>
                </div>

                <!-- Card 5 -->
                <div data-aos="flip-left" data-aos-delay="900" class="p-6 transition bg-white shadow-md rounded-2xl hover:shadow-lg">
                    <div class="flex items-center justify-center w-16 h-16 mb-4 bg-blue-100 rounded-full">
                        <i data-lucide="recycle" class="w-8 h-8 text-blue-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800">Tanpa Kertas</h3>
                    <p class="mt-2 text-gray-600">
                        Ramah lingkungan karena tidak memerlukan kertas untuk surat suara.
                    </p>
                </div>

                <!-- Card 6 -->
                <div data-aos="flip-left" data-aos-delay="1100" class="p-6 transition bg-white shadow-md rounded-2xl hover:shadow-lg">
                    <div class="flex items-center justify-center w-16 h-16 mb-4 bg-blue-100 rounded-full">
                        <i data-lucide="check-circle" class="w-8 h-8 text-blue-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800">Transparan</h3>
                    <p class="mt-2 text-gray-600">
                        Proses dan hasil dapat diaudit untuk memastikan keadilan pemilihan.
                    </p>
                </div>
            </div>
        </div>
    </section>
    <!-- ========== WHY?-end ========== -->


    <!-- ========== ABOUT ========== -->
    <section id="about" class="bg-white">
        <header class="py-12 text-center text-white bg-blue-500">
            <h1 data-aos="fade-right" class="mt-16 text-4xl font-bold">Tentang Kami</h1>
        </header>

        <section class="bg-white">
            <div class="container px-6 py-10 mx-auto">
                <h1 data-aos="fade-left" class="text-2xl font-semibold text-center text-gray-800 capitalize lg:text-3xl">Para Pengembang Sistem</h1>

                <p data-aos="flip-up" class="max-w-2xl mx-auto my-6 text-center text-gray-600 text-pretty">
                    <span class="text-black underline">e<span class="text-blue-500">Voting</span></span> SMKN 1 Cirebon adalah proyek digital buatan sekelompok siswa kelas X-PPLG 2 SMKN 1 Cirebon. Proyek ini dibuat sebagai tugas akhir semester untuk menghadirkan sistem pemilihan yang efisien, transparan, dan modern di lingkungan sekolah.
                </p>

                <div class="grid grid-cols-1 gap-8 mt-8 xl:mt-16 md:grid-cols-2 xl:grid-cols-3">
                    <div data-aos="fade-right"
                        class="flex flex-col items-center p-8 transition-colors duration-300 transform border cursor-pointer rounded-xl hover:border-transparent group hover:bg-blue-600">
                        <a href="<?= $base_url ?>assets/pictures/nino.jpg" data-lightbox="team" data-title="Nino Adityo - Fullstack Developer">
                            <img class="object-cover w-32 h-32 rounded-full ring-4 ring-gray-300"
                                src="<?= $base_url ?>assets/pictures/nino.jpg"
                                alt="Nino Adityo Nugroho">
                        </a>

                        <h1
                            class="mt-4 text-2xl font-semibold text-gray-700 capitalize group-hover:text-white">
                            Nino Adityo Nugroho</h1>

                        <p class="mt-2 text-gray-500 capitalize group-hover:text-gray-300">Fullstack Developer</p>

                        <div class="flex mt-3 -mx-2">
                            <a href="https://www.youtube.com/@PPLG2Angkatan66" target="_blank"
                                class="mx-2 bg-gray-700 text-white p-1 rounded-full hover:bg-gray-800 transition group-hover:text-black group-hover:bg-white group-hover:hover:bg-gray-300"
                                aria-label="Youtube">
                                <i class="w-5 h-5" data-lucide="youtube"></i>
                            </a>

                            <a href="https://www.instagram.com/nihooo_o.o" target="_blank"
                                class="mx-2 bg-gray-700 text-white p-1 rounded-full hover:bg-gray-800 transition group-hover:text-black group-hover:bg-white group-hover:hover:bg-gray-300"
                                aria-label="Instagram">
                                <i class="w-5 h-5" data-lucide="instagram"></i>
                            </a>

                            <a href="https://github.com/ninoell55" target="_blank"
                                class="mx-2 bg-gray-700 text-white p-1 rounded-full hover:bg-gray-800 transition group-hover:text-black group-hover:bg-white group-hover:hover:bg-gray-300"
                                aria-label="Github">
                                <i class="w-5 h-5" data-lucide="github"></i>
                            </a>
                        </div>
                    </div>

                    <div data-aos="zoom-in"
                        class="flex flex-col items-center p-8 transition-colors duration-300 transform border cursor-pointer rounded-xl hover:border-transparent group hover:bg-blue-600">
                        <a href="<?= $base_url ?>assets/pictures/jia.jpg" data-lightbox="team" data-title="Jihan Syahira - Analyst & Documentation">
                            <img class="object-cover w-32 h-32 rounded-full ring-4 ring-gray-300"
                                src="<?= $base_url ?>assets/pictures/jia.jpg"
                                alt="Jihan Syahira">
                        </a>

                        <h1
                            class="mt-4 text-2xl font-semibold text-gray-700 capitalize group-hover:text-white">
                            Jihan Syahira</h1>

                        <p class="mt-2 text-gray-500 capitalize group-hover:text-gray-300">Analyst & Documentation</p>

                        <div class="flex mt-3 -mx-2">
                            <a href="https://www.youtube.com/@PPLG2Angkatan66" target="_blank"
                                class="mx-2 bg-gray-700 text-white p-1 rounded-full hover:bg-gray-800 transition group-hover:text-black group-hover:bg-white group-hover:hover:bg-gray-300"
                                aria-label="Youtube">
                                <i class="w-5 h-5" data-lucide="youtube"></i>
                            </a>

                            <a href="https://www.instagram.com/zhira_o.o" target="_blank"
                                class="mx-2 bg-gray-700 text-white p-1 rounded-full hover:bg-gray-800 transition group-hover:text-black group-hover:bg-white group-hover:hover:bg-gray-300"
                                aria-label="Instagram">
                                <i class="w-5 h-5" data-lucide="instagram"></i>
                            </a>

                            <a href="https://github.com/jiaa220809" target="_blank"
                                class="mx-2 bg-gray-700 text-white p-1 rounded-full hover:bg-gray-800 transition group-hover:text-black group-hover:bg-white group-hover:hover:bg-gray-300"
                                aria-label="Github">
                                <i class="w-5 h-5" data-lucide="github"></i>
                            </a>
                        </div>
                    </div>


                    <div data-aos="fade-left"
                        class="flex flex-col items-center p-8 transition-colors duration-300 transform border cursor-pointer rounded-xl hover:border-transparent group hover:bg-blue-600">
                        <a href="<?= $base_url ?>assets/pictures/puji.jpg" data-lightbox="team" data-title="Puji Wijayanto - Design Director">
                            <img class="object-cover w-32 h-32 rounded-full ring-4 ring-gray-300"
                                src="<?= $base_url ?>assets/pictures/puji.jpg"
                                alt="Puji Wijayanto">
                        </a>

                        <h1
                            class="mt-4 text-2xl font-semibold text-gray-700 capitalize group-hover:text-white">
                            Puji Wijayanto</h1>

                        <p class="mt-2 text-gray-500 capitalize group-hover:text-gray-300">design
                            director</p>

                        <div class="flex mt-3 -mx-2">
                            <a href="https://www.youtube.com/@PPLG2Angkatan66" target="_blank"
                                class="mx-2 bg-gray-700 text-white p-1 rounded-full hover:bg-gray-800 transition group-hover:text-black group-hover:bg-white group-hover:hover:bg-gray-300"
                                aria-label="Youtube">
                                <i class="w-5 h-5" data-lucide="youtube"></i>
                            </a>

                            <a href="https://www.instagram.com/_pujione" target="_blank"
                                class="mx-2 bg-gray-700 text-white p-1 rounded-full hover:bg-gray-800 transition group-hover:text-black group-hover:bg-white group-hover:hover:bg-gray-300"
                                aria-label="Instagram">
                                <i class="w-5 h-5" data-lucide="instagram"></i>
                            </a>

                            <a href="https://github.com/ninoell55" target="_blank"
                                class="mx-2 bg-gray-700 text-white p-1 rounded-full hover:bg-gray-800 transition group-hover:text-black group-hover:bg-white group-hover:hover:bg-gray-300"
                                aria-label="Github">
                                <i class="w-5 h-5" data-lucide="github"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="px-4 py-12 text-white bg-blue-500">
            <h2 data-aos="fade-down" class="text-2xl font-bold text-center">Visi Kami</h2>
            <p data-aos="zoom-in" class="max-w-2xl mx-auto mt-4 text-center">
                Menjadi sistem pemilihan digital terpercaya yang mendorong partisipasi aktif, transparan, dan adil di lingkungan sekolah.
            </p>
        </section>

        <section class="px-4 py-12 text-gray-700 bg-gray-100">
            <h2 data-aos="fade-up" class="text-2xl font-bold text-center">Misi Kami</h2>
            <div class="grid max-w-5xl grid-cols-1 gap-8 mx-auto mt-8 md:grid-cols-2">
                <div data-aos="fade-right" class="p-4 transition-shadow bg-white rounded-lg shadow-lg hover:shadow-xl">
                    <h3 class="text-xl font-bold">Menyediakan Sistem yang Andal</h3>
                    <p class="mt-2 text-gray-700">Menghadirkan sistem e-voting yang stabil, aman, dan mudah digunakan oleh seluruh warga sekolah.</p>
                </div>
                <div data-aos="fade-left" data-aos-delay="300" class="p-4 transition-shadow bg-white rounded-lg shadow-lg hover:shadow-xl">
                    <h3 class="text-xl font-bold">Mendorong Partisipasi Demokratis</h3>
                    <p class="mt-2 text-gray-700">Meningkatkan kesadaran pentingnya pemilihan umum yang jujur dan adil sejak di bangku sekolah.</p>
                </div>
                <div data-aos="fade-right" data-aos-delay="500" class="p-4 transition-shadow bg-white rounded-lg shadow-lg hover:shadow-xl">
                    <h3 class="text-xl font-bold">Mendukung Digitalisasi Sekolah</h3>
                    <p class="mt-2 text-gray-700">Berperan aktif dalam transformasi digital dengan menyediakan solusi teknologi yang relevan dan bermanfaat.</p>
                </div>
                <div data-aos="fade-left" data-aos-delay="700" class="p-4 transition-shadow bg-white rounded-lg shadow-lg hover:shadow-xl">
                    <h3 class="text-xl font-bold">Memberikan Pengalaman Terbaik</h3>
                    <p class="mt-2 text-gray-700">Menjamin proses pemungutan suara yang cepat, efisien, dan nyaman bagi para pemilih.</p>
                </div>
            </div>
        </section>

        <section class="px-4 py-12 text-center text-white bg-blue-500">
            <h2 data-aos="fade-down" class="text-2xl font-bold">Keunggulan Kami</h2>
            <p data-aos="fade-up" class="max-w-2xl mx-auto mt-4 text-center">Sistem e-voting kami dirancang khusus untuk pemilihan di lingkungan sekolah dengan antarmuka yang sederhana dan mudah digunakan.</p>
            <div class="grid max-w-5xl grid-cols-1 gap-8 mx-auto mt-8 sm:grid-cols-2 md:grid-cols-3">
                <div data-aos="fade-up-right" class="p-4 transition-colors bg-blue-600 rounded-lg shadow-lg hover:bg-blue-500">
                    <p>"Setiap suara terenkripsi dan tersimpan dengan aman untuk menjamin hasil yang jujur dan transparan."</p>
                    <h3 class="mt-4 font-bold">- 🛡️</h3>
                </div>
                <div data-aos="fade-up" class="p-4 transition-colors bg-blue-600 rounded-lg shadow-lg hover:bg-blue-500">
                    <p>"Pemungutan suara dapat dilakukan dalam hitungan detik tanpa antrian panjang."</p>
                    <h3 class="mt-4 font-bold">- ⚡</h3>
                </div>
                <div data-aos="fade-up-left" class="p-4 transition-colors bg-blue-600 rounded-lg shadow-lg hover:bg-blue-500">
                    <p>"Perhitungan suara dilakukan secara otomatis dan ditampilkan secara real-time tanpa manipulasi."</p>
                    <h3 class="mt-4 font-bold">- 📊</h3>
                </div>
            </div>
        </section>

        <div class="relative flex flex-col items-center mx-auto lg:flex-row-reverse lg:max-w-5xl lg:mt-12 xl:max-w-6xl">

            <div data-aos="fade-left" class="w-full h-64 lg:w-1/2 lg:h-auto">
                <img class="object-cover w-full h-full"
                    src="<?= $base_url ?>assets/pictures/bg-about.jpeg"
                    alt="Vote">
            </div>

            <div
                class="max-w-lg bg-white md:max-w-2xl md:z-10 md:shadow-lg md:absolute md:top-0 md:mt-48 lg:w-3/5 lg:left-0 lg:mt-20 lg:ml-20 xl:mt-24 xl:ml-12">
                <div class="flex flex-col p-12 md:px-16">
                    <h2 data-aos="fade-down-right" class="text-2xl font-medium text-blue-800 uppercase lg:text-4xl">Dukung Kami Selalu</h2>
                    <p data-aos="zoom-in" class="mt-4">
                        Sistem e-voting ini adalah langkah awal kami menghadirkan pemilihan yang modern dan efisien di sekolah. Kami sadar teknologi terus berkembang, begitu juga sistem ini. Masih banyak ruang untuk peningkatan, baik dari fitur, keamanan, maupun tampilan. Dukungan dan masukan sangat berarti bagi pengembangan ke depan.
                    </p>
                    <div data-aos="fade-up-left" class="mt-8">
                        <a href="https://wa.me/6287740864657" target="_blank"
                            class="inline-block w-full px-10 py-4 text-lg font-medium text-center text-gray-100 bg-blue-600 border-2 border-gray-600 border-solid hover:bg-blue-800 hover:shadow-md md:w-52">Hubungi Kami
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <footer id="footer" class="text-center text-white bg-blue-500 py-10 lg:py-20">
            <p class="lg:mt-20" data-aos="fade-up" data-aos-delay="500">&copy; 2025 eVoting SMKN 1 Cirebon. Dibuat oleh Nino, Jihan & Puji.</p>
        </footer>
    </section>
    <!-- ========== ABOUT-end ========== -->



    <!-- AOS -->
    <script src="<?= $base_url ?>assets/js/aos.js"></script>

    <!-- Lightbox -->
    <script src="<?= $base_url ?>assets/js/lightbox-plus-jquery.min.js"></script>

    <script>
        lucide.createIcons();

        function handleAOS() {
            if (window.innerWidth > 768) {
                AOS.init({
                    duration: 600,
                    once: true
                });
            } else {
                // Hapus efek AOS supaya elemen muncul
                const aosElements = document.querySelectorAll('[data-aos]');
                aosElements.forEach(el => {
                    el.style.opacity = '1';
                    el.style.transform = 'none';
                });
            }
        }

        // Jalankan saat pertama kali load
        document.addEventListener("DOMContentLoaded", handleAOS);

        // Jalankan saat resize layar
        window.addEventListener("resize", () => {
            // Clear previous AOS to prevent duplicates
            AOS.refreshHard();
            handleAOS();
        });
    </script>

</body>

</html>