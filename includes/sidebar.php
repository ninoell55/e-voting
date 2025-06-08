<!-- Sidebar -->
<aside id="sidebar"
    style="visibility: hidden;"
    class="fixed left-0 z-40 w-64 h-screen min-h-full p-6 pt-4 transition-transform duration-300 ease-in-out transform -translate-x-full bg-white shadow-lg md:translate-x-0 top-16">

    <button id="toggleSidebar"
        class="absolute z-50 hidden p-1 transition-all duration-300 ease-in-out bg-white border border-gray-300 rounded-full shadow-lg -top-3 -right-3 md:block hover:bg-blue-100 hover:border-blue-300">
        <i data-lucide="arrow-left" class="w-5 h-5 text-gray-700"></i>
    </button>

    <!-- User Profile -->
    <div class="flex items-center gap-4 mb-6">
        <div class="flex items-center justify-center w-12 h-12 text-xl font-bold text-blue-600 bg-blue-100 rounded-full">
            <?= ucfirst($_SESSION["username"][0]) ?>
        </div>
        <div>
            <p class="text-sm font-semibold text-gray-800"><?= ucfirst($_SESSION["username"]) ?></p>
            <p class="text-xs text-gray-500"><?= ucfirst($_SESSION["role"]) ?></p>
        </div>
    </div>

    <!-- Search Bar Mobile -->
    <!-- <div class="block mb-4 sm:hidden">
        <div class="relative">
            <input type="text" placeholder="Search..."
                class="w-full py-2 pl-4 pr-10 text-sm text-gray-700 transition duration-200 bg-gray-100 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
            <button class="absolute text-blue-500 transition -translate-y-1/2 right-3 top-1/2 hover:text-blue-700">
                <span class="text-base"><i data-lucide="search"></i></span>
            </button>
        </div>
    </div> -->

    <nav class="flex flex-col gap-1">
        <!-- Main -->
        <p class="px-4 text-xs tracking-wide text-gray-400 uppercase">Main</p>
        <a href="<?= $base_url ?>pages/admin/index.php"
            class="flex items-center px-4 py-2 <?= isActive('index.php') ? 'bg-blue-100 text-blue-600 hover:bg-blue-200' : 'text-gray-700 hover:bg-gray-100'; ?> rounded-lg font-medium transition">
            <span class="mr-3"><i data-lucide="layout-dashboard"></i></span> Dashboard
        </a>

        <a href="<?= $base_url ?>pages/admin/event/daftar_event.php"
            class="flex items-center px-4 py-2 <?= isActive('/event/') ? 'bg-blue-100 text-blue-600 hover:bg-blue-200' : 'text-gray-700 hover:bg-gray-100'; ?> rounded-lg transition">
            <span class="mr-3">
                <i data-lucide="calendar"></i>
            </span> Event
        </a>

        <a href="<?= $base_url ?>pages/admin/kandidat/daftar_kandidat.php"
            class="flex items-center px-4 py-2 <?= isActive('/kandidat/') ? 'bg-blue-100 text-blue-600 hover:bg-blue-200' : 'text-gray-700 hover:bg-gray-100'; ?> rounded-lg transition">
            <span class="mr-3"><i data-lucide="users"></i></span> Kandidat
        </a>

        <!-- Hasil -->
        <p class="px-4 mt-4 text-xs tracking-wide text-gray-400 uppercase">Results</p>
        <a href="<?= $base_url ?>pages/admin/log/log_suara.php"
            class="flex items-center px-4 py-2 <?= isActive('/log/') ? 'bg-blue-100 text-blue-600 hover:bg-blue-200' : 'text-gray-700 hover:bg-gray-100'; ?> rounded-lg transition">
            <span class="mr-3"><i data-lucide="history"></i></span> Log
        </a>

        <a href="<?= $base_url ?>pages/admin/suara/suara.php"
            class="flex items-center px-4 py-2 <?= isActive('/suara/') ? 'bg-blue-100 text-blue-600 hover:bg-blue-200' : 'text-gray-700 hover:bg-gray-100'; ?> rounded-lg transition">
            <span class="mr-3"><i data-lucide="mic-vocal"></i></span> Suara
        </a>

        <a href="<?= $base_url ?>pages/admin/hasil/hasil_akhir.php"
            class="flex items-center px-4 py-2 <?= isActive('/hasil/') ? 'bg-blue-100 text-blue-600 hover:bg-blue-200' : 'text-gray-700 hover:bg-gray-100'; ?> rounded-lg transition">
            <span class="mr-3"><i data-lucide="save-all"></i></span> Hasil
        </a>

        <!-- Settings -->
        <p class="px-4 mt-4 text-xs tracking-wide text-gray-400 uppercase">Settings</p>
        <?php if ($_SESSION['role'] === 'administrator') : ?>
            <a href="<?= $base_url; ?>pages/admin/settings/daftar_admin.php"
                class="flex items-center px-4 py-2 <?= isActive('/settings/') ? 'bg-blue-100 text-blue-600 hover:bg-blue-200' : 'text-gray-700 hover:bg-gray-100'; ?> rounded-lg transition">
                <span class="mr-3"><i data-lucide="shield-user"></i></span> Admin
            </a>

            <a href="<?= $base_url ?>pages/admin/pemilih/daftar_pemilih.php"
                class="flex items-center px-4 py-2 <?= isActive('/pemilih/') ? 'bg-blue-100 text-blue-600 hover:bg-blue-200' : 'text-gray-700 hover:bg-gray-100'; ?> rounded-lg transition">
                <span class="mr-3"><i data-lucide="circle-user"></i></span> Pemilih
            </a>
        <?php endif; ?>
        <a href="<?= $base_url ?>auth/logout_admin.php"
            class="flex items-center px-4 py-2 text-red-500 transition rounded-lg hover:bg-red-100 btn-logout">
            <span class="mr-3"><i data-lucide="log-out"></i></span> Logout
        </a>
    </nav>
</aside>