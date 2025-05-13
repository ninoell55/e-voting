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
    <link href="<?= $base_url ?>assets/css/output.css" rel="stylesheet">
    <title>SELAMAT DATANG</title>
</head>

<body>

    <!-- ========== HEADER ========== -->
    <header class="flex flex-wrap lg:justify-start lg:flex-nowrap z-50 w-full py-7">
        <nav class="relative max-w-7xl w-full flex flex-wrap lg:grid lg:grid-cols-12 basis-full items-center px-4 md:px-6 lg:px-8 mx-auto">
            <div class="lg:col-span-3 flex items-center">
                <!-- Logo -->
                <a class="flex-none rounded-xl text-xl inline-block font-semibold focus:outline-hidden focus:opacity-80" href="#" aria-label="Preline">
                E-Voting
                </a>
                <!-- End Logo -->

                <div class="ms-1 sm:ms-2">
                </div>
            </div>

            <!-- Button Group -->
            <div class="flex items-center gap-x-1 lg:gap-x-2 ms-auto py-1 lg:ps-6 lg:order-3 lg:col-span-3">
                <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium text-nowrap rounded-xl border border-transparent bg-indigo-400 text-black hover:bg-indigo-500 focus:outline-hidden focus:bg-indigo-500 transition disabled:opacity-50 disabled:pointer-events-none">
                    Contact us
                </button>

                <div class="lg:hidden">
                    <button type="button" class="hs-collapse-toggle size-9.5 flex justify-center items-center text-sm font-semibold rounded-xl border border-gray-200 text-black hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:border-neutral-700 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700" id="hs-navbar-hcail-collapse" aria-expanded="false" aria-controls="hs-navbar-hcail" aria-label="Toggle navigation" data-hs-collapse="#hs-navbar-hcail">
                        <svg class="hs-collapse-open:hidden shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="3" x2="21" y1="6" y2="6" />
                            <line x1="3" x2="21" y1="12" y2="12" />
                            <line x1="3" x2="21" y1="18" y2="18" />
                        </svg>
                        <svg class="hs-collapse-open:block hidden shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 6 6 18" />
                            <path d="m6 6 12 12" />
                        </svg>
                    </button>
                </div>
            </div>
            <!-- End Button Group -->

            <!-- Collapse -->
            <div id="hs-navbar-hcail" class="hs-collapse hidden overflow-hidden transition-all duration-300 basis-full grow lg:block lg:w-auto lg:basis-auto lg:order-2 lg:col-span-6" aria-labelledby="hs-navbar-hcail-collapse">
                <div class="flex flex-col gap-y-4 gap-x-0 mt-5 lg:flex-row lg:justify-center lg:items-center lg:gap-y-0 lg:gap-x-7 lg:mt-0">
                    <div>
                        <a class="relative inline-block text-black focus:outline-hidden before:absolute before:bottom-0.5 before:start-0 before:-z-1 before:w-full before:h-1 before:bg-indigo-400" href="#" aria-current="page">Home</a>
                    </div>
                    <div>
                        <a class="inline-block text-black hover:text-gray-600 focus:outline-hidden focus:text-gray-600" href="#">How?</a>
                    </div>
                    <div>
                        <a class="inline-block text-black hover:text-gray-600 focus:outline-hidden focus:text-gray-600" href="#">About</a>
                    </div>
                </div>
            </div>
            <!-- End Collapse -->
        </nav>
    </header>
    <!-- ========== END HEADER ========== -->


    <!-- SELAMAT DATANG -->
    <section class="bg-white py-16 sm:py-24 lg:py-32">  
        <div class="mx-auto w-screen max-w-screen-xl px-4 py-16 sm:px-6 sm:py-24 lg:px-8 lg:py-32">
            <div class="mx-auto max-w-prose text-center">
                <h1 class="text-4xl font-bold text-gray-900 sm:text-5xl">
                    Selamat Datang di Website
                    <strong class="text-indigo-600"> E-Voting. </strong>
                </h1>

                <p class="mt-4 text-base text-pretty text-gray-700 sm:text-lg/relaxed">
                    Login untuk mulai memilih. Gunakan hak suara Anda dengan bijak!
                </p>

                <div class="mt-4 flex justify-center gap-4 sm:mt-6">
                    <a
                        class="inline-block rounded border border-indigo-600 bg-indigo-600 px-5 py-3 font-medium text-white shadow-sm transition-colors hover:bg-indigo-700"
                        href="auth/">
                        Login
                    </a>

                    <a
                        class="inline-block rounded border border-gray-200 px-5 py-3 font-medium text-gray-700 shadow-sm transition-colors hover:bg-gray-50 hover:text-gray-900"
                        href="#">
                        Learn More
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!-- SELAMAT DATANG-end -->

</body>

</html>