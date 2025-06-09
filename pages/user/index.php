<?php
require_once '../../config/connection.php';

$id_pemilih = $_SESSION['id_pemilih'] ?? null;
if (!$id_pemilih) {
  header("Location: ../../auth/login_user.php");
  exit;
}

$pemilih = query("SELECT * FROM pemilih WHERE id_pemilih = $id_pemilih")[0] ?? null;
$totalEvent = query("SELECT COUNT(*) AS total FROM event WHERE status = 'aktif'")[0]['total'] ?? 0;
$eventDipilih = query("SELECT COUNT(*) AS total FROM pilih WHERE id_pemilih = $id_pemilih")[0]['total'] ?? 0;

include '../../includes/header.php';
?>

<main class="min-h-screen h-full bg-gradient-to-br from-sky-300 via-white to-purple-200 py-12 px-4 sm:px-6 mt-16">
  <div class="animate__animated animate__fadeIn animate__faster max-w-6xl mx-auto">
    <div class="bg-white/60 backdrop-blur-md p-10 rounded-3xl shadow-2xl border border-white/30 transition-all duration-500">

      <div class="mb-10 text-center">
        <h1 class="text-3xl sm:text-4xl italic font-extrabold text-gray-800 drop-shadow-sm tracking-wide">
          <!-- Untuk mobile -->
          <span class="block sm:hidden animate__animated animate__fadeInDown">Selamat Datang</span>
          <!-- Untuk desktop -->
          <span class="hidden sm:inline-block animate__animated animate__fadeInLeft">Selamat Datang</span>

          <!-- nama_lengkap desktop -->
          <span class="hidden sm:inline-block not-italic text-indigo-600 animate__animated animate__fadeInRight">
            , <?= htmlspecialchars($pemilih['nama_lengkap']) ?>!
          </span>
        </h1>

        <!-- nama_lengkap mobile -->
        <p class="mt-2 text-lg text-indigo-600 font-semibold sm:hidden animate__animated animate__fadeInUp">
          <?= htmlspecialchars($pemilih['nama_lengkap']) ?>!
        </p>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-12">
        <div class="animate__animated animate__fadeInTopLeft relative bg-gradient-to-r from-blue-100 to-blue-200 hover:scale-[1.02] transition-transform border-l-4 border-blue-500 p-6 rounded-xl shadow-md hover:shadow-lg">
          <p class="text-gray-700 text-base font-semibold">Event Aktif</p>
          <p class="text-4xl font-bold text-blue-700 mt-1"><?= $totalEvent ?></p>
          <a href="<?= $base_url; ?>pages/user/vote_event.php" class="animate__animated animate__wobble animate__delay-1s absolute bottom-4 right-4 text-black hover:text-blue-700">
            <i data-lucide="arrow-up-right" class="w-5 h-5"></i>
          </a>
        </div>

        <div class="animate__animated animate__fadeInTopRight relative bg-gradient-to-r from-green-100 to-green-200 hover:scale-[1.02] transition-transform border-l-4 border-green-500 p-6 rounded-xl shadow-md hover:shadow-lg">
          <p class="text-gray-700 text-base font-semibold">Sudah Diikuti</p>
          <p class="text-4xl font-bold text-green-700 mt-1"><?= $eventDipilih ?></p>
          <a href="<?= $base_url; ?>pages/user/riwayat.php" class="animate__animated animate__wobble animate__delay-1s absolute bottom-4 right-4 text-black hover:text-green-700">
            <i data-lucide="arrow-up-right" class="w-5 h-5"></i>
          </a>
        </div>
      </div>

      <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-center">
        <a href="vote_event.php" class="animate__animated animate__fadeInUp group bg-indigo-600 hover:bg-indigo-700 text-white py-4 px-5 rounded-2xl shadow-md hover:shadow-xl transition transform hover:-translate-y-1 flex flex-col items-center gap-2">
          <i data-lucide="check-square" class="w-6 h-6 group-hover:scale-110 transition"></i>
          <span class="font-semibold text-sm sm:text-base">Vote</span>
        </a>
        <a href="riwayat.php" class="animate__animated animate__fadeInDown group bg-yellow-500 hover:bg-yellow-600 text-white py-4 px-5 rounded-2xl shadow-md hover:shadow-xl transition transform hover:-translate-y-1 flex flex-col items-center gap-2">
          <i data-lucide="clock" class="w-6 h-6 group-hover:scale-110 transition"></i>
          <span class="font-semibold text-sm sm:text-base">Riwayat</span>
        </a>
        <a href="grafik.php" class="animate__animated animate__fadeInUp group bg-pink-500 hover:bg-pink-600 text-white py-4 px-5 rounded-2xl shadow-md hover:shadow-xl transition transform hover:-translate-y-1 flex flex-col items-center gap-2">
          <i data-lucide="bar-chart-3" class="w-6 h-6 group-hover:scale-110 transition"></i>
          <span class="font-semibold text-sm sm:text-base">Grafik</span>
        </a>
        <a href="hasil_akhir.php" class="animate__animated animate__fadeInDown group bg-blue-900 hover:bg-blue-800 text-white py-4 px-5 rounded-2xl shadow-md hover:shadow-xl transition transform hover:-translate-y-1 flex flex-col items-center gap-2">
          <i data-lucide="award" class="w-6 h-6 group-hover:scale-110 transition"></i>
          <span class="font-semibold text-sm sm:text-base">Hasil Akhir</span>
        </a>
      </div>

    </div>
  </div>
</main>

<?php include '../../includes/footer.php'; ?>


<script>
  lucide.createIcons();
</script>

<?php if (isset($_SESSION['login_success']) && $_SESSION['login_success']) : ?>
  <script>
    Swal.fire({
      icon: 'success',
      title: 'Login Berhasil!',
      text: 'Selamat datang di Website E-Voting SMKN 1 CIREBON!',
      timer: 2000,
      showConfirmButton: false,
      timerProgressBar: true
    }).then(() => {
      window.history.replaceState(null, null, window.location.pathname);
    });
  </script>
  <?php unset($_SESSION['login_success']); ?>
<?php endif; ?>