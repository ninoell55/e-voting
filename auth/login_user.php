<?php
require_once '../config/connection.php';

updateEventStatus();

if (isset($_SESSION['login_admin'])) {
    header("Location: ../pages/admin/index.php");
    exit;
} elseif (isset($_SESSION['login_user'])) {
    header("Location: ../pages/user/index.php");
    exit;
}

if (isset($_POST['login_user'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM pemilih WHERE username='$username'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);

        if ($row['password'] === $password) {
            $_SESSION['id_pemilih'] = $row['id_pemilih'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['nama_lengkap'] = $row['nama_lengkap'];
            $_SESSION['login_user'] = true;

            $_SESSION['login_success'] = true;

            header("Location: ../pages/user/index.php");
            exit;
        } else {
            $error = "Password salah. Silakan coba lagi.";
        }
    } else {
        $error = "Username tidak ditemukan.";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN USER</title>
    <link href="<?= $base_url ?>assets/css/output.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/sweetalert2.min.css">

    <style>
        video.bg-video {
            position: fixed;
            top: 0;
            left: 0;
            min-width: 100%;
            min-height: 100%;
            object-fit: cover;
            z-index: -10;
        }
    </style>
</head>

<body class="relative flex items-center justify-center min-h-screen overflow-hidden">

    <!-- Background Video -->
    <video autoplay muted loop class="bg-video">
        <source src="<?= $base_url ?>assets/pictures/login_user1.mp4" type="video/mp4">
        Your browser does not support HTML5 video.
    </video>

    <!-- Overlay gelap semi-transparan -->
    <div class="absolute inset-0 z-0 bg-black/50"></div>

    <!-- Card Login -->
    <div class="relative z-10 w-full max-w-md p-8 border shadow-2xl backdrop-blur-lg bg-white/30 rounded-2xl border-white/30">
        <div class="mb-6 text-center">
            <h1 class="text-3xl font-bold text-white drop-shadow-sm">Login User</h1>
        </div>

        <form method="POST" class="space-y-6">
            <!-- Username -->
            <div class="relative">
                <input type="text" name="username" id="username" required
                    class="w-full px-4 pt-6 pb-2 text-sm text-white placeholder-transparent border rounded-md peer border-white/50 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    placeholder="Username" />
                <label for="username"
                    class="absolute left-4 top-1.5 text-sm text-gray-50 transition-all duration-200 ease-in-out 
                    peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-50
                    peer-focus:top-1 peer-focus:left-3 peer-focus:text-sm peer-focus:text-gray-200">
                    Username
                </label>
            </div>

            <!-- Password -->
            <div class="relative">
                <input type="password" name="password" id="password" required
                    class="w-full px-4 pt-6 pb-2 text-sm text-white placeholder-transparent border rounded-md peer border-white/50 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    placeholder="Password" />
                <label for="password"
                    class="absolute left-4 top-1.5 text-sm text-gray-50 transition-all duration-200 ease-in-out 
                    peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-50 
                    peer-focus:top-1.5 peer-focus:left-3 peer-focus:text-sm peer-focus:text-gray-200">
                    Password
                </label>
            </div>

            <button name="login_user" type="submit"
                class="w-full py-2 font-semibold text-white transition bg-indigo-600 rounded-lg hover:bg-indigo-700">
                Login sebagai User
            </button>
        </form>

        <p class="mt-6 text-xs italic text-center text-white/80">
            Ayo gunakan hak suara kamu!.
        </p>
    </div>


    <script src="<?= $base_url ?>assets/js/sweetalert2.min.js"></script>

    <?php if (isset($error)) : ?>
        <script>
            Swal.fire({
                title: 'Login Gagal!',
                text: '<?= $error ?>',
                icon: 'error',
                confirmButtonColor: '#6366F1',
                confirmButtonText: 'Coba Lagi'
            }).then(() => {
                window.history.replaceState(null, null, window.location.pathname);
            });
        </script>
    <?php endif; ?>

    <?php if (isset($_GET['logout']) && $_GET['logout'] === 'success') : ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Logout Berhasil!',
                text: 'Sampai jumpa kembali 👋',
                timer: 2000,
                showConfirmButton: false,
                timerProgressBar: true
            }).then(() => {
                window.history.replaceState(null, null, window.location.pathname);
            });
        </script>
    <?php endif; ?>

</body>

</html>