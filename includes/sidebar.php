<!-- Sidebar -->
<aside id="sidebar"
    class="fixed top-16 left-0 w-64 bg-white shadow-lg h-screen p-6 pt-4 z-20 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out">
    <!-- User Profile -->
    <div class="flex items-center gap-4 mb-6">
        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 text-xl font-bold">
            A
        </div>
        <div>
            <p class="text-sm font-semibold text-gray-800"><?= ucfirst($_SESSION["username"]) ?></p>
            <p class="text-xs text-gray-500"><?= ucfirst($_SESSION["role"]) ?></p>
        </div>
    </div>

    <!-- Search Bar Mobile -->
    <div class="block sm:hidden mb-4">
        <div class="relative">
            <input type="text" placeholder="Search..."
                class="pl-4 pr-10 py-2 w-full text-sm text-gray-700 bg-gray-100 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" />
            <button class="absolute right-3 top-1/2 -translate-y-1/2 text-blue-500 hover:text-blue-700 transition">
                <span class="material-icons text-base">search</span>
            </button>
        </div>
    </div>

    <nav class="flex flex-col gap-1">
        <!-- Main -->
        <p class="text-gray-400 text-xs uppercase tracking-wide px-4">Main</p>
        <a href="<?= $base_url ?>pages/admin/index.php"
            class="flex items-center px-4 py-2 <?= isActive('index.php') ? 'bg-blue-100 text-blue-600 hover:bg-blue-200' : 'text-gray-700 hover:bg-gray-100'; ?> rounded-lg font-medium transition">
            <span class="mr-3"><i data-lucide="layout-dashboard"></i></span> Dashboard
        </a>
        <a href="<?= $base_url ?>pages/admin/pemilih/daftar_pemilih.php"
            class="flex items-center px-4 py-2 <?= isActive('/pemilih/') ? 'bg-blue-100 text-blue-600 hover:bg-blue-200' : 'text-gray-700 hover:bg-gray-100'; ?> rounded-lg transition">
            <span class="mr-3"><i data-lucide="circle-user"></i></span> Pemilih
        </a>
        <a href="<?= $base_url ?>pages/admin/event/daftar_event.php"
            class="flex items-center px-4 py-2 <?= isActive('/event/') ? 'bg-blue-100 text-blue-600 hover:bg-blue-200' : 'text-gray-700 hover:bg-gray-100'; ?> rounded-lg transition">
            <span class="mr-3">
                <i data-lucide="calendar"></i>
            </span> Event
        </a>

        <!-- Communication -->
        <p class="text-gray-400 text-xs uppercase tracking-wide px-4 mt-4">Communication</p>
        <a href="<?= $base_url ?>pages/admin/kandidat/pilih_event.php"
            class="flex items-center px-4 py-2 <?= isActive('/kandidat/') ? 'bg-blue-100 text-blue-600 hover:bg-blue-200' : 'text-gray-700 hover:bg-gray-100'; ?> rounded-lg transition">
            <span class="mr-3"><i data-lucide="users"></i></span> Kandidat
        </a>

        <!-- Settings -->
        <p class="text-gray-400 text-xs uppercase tracking-wide px-4 mt-4">Settings</p>
        <?php if ($_SESSION['role'] === 'administrator') : ?>
            <a href="#"
                class="flex items-center px-4 py-2 text-gray-700 rounded-lg transition">
                <span class="mr-3"><i data-lucide="settings"></i></span> Settings
            </a>
        <?php endif; ?>
        <a href="<?= $base_url ?>auth/logout_admin.php"
            class="flex items-center px-4 py-2 text-red-500 rounded-lg transition hover:bg-red-100">
            <span class="mr-3"><i data-lucide="log-out"></i></span> Logout
        </a>
    </nav>
</aside>