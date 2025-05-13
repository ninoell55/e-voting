<?php
require_once '../config/connection.php';

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
            $_SESSION['username'] = $row['username'];
            $_SESSION['nama_lengkap'] = $row['nama_lengkap'];
            $_SESSION['login_user'] = true;
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
</head>

<body class="flex items-center justify-center min-h-screen bg-gradient-to-br from-indigo-100 to-white">

    <div class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-md border border-gray-200">
        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-indigo-600">Login User</h1>
            <?php if (isset($error)) : ?>
                <div class="mt-4 p-3 text-sm text-red-700 bg-red-100 border border-red-300 rounded-md">
                    <?= $error ?>
                </div>
            <?php endif; ?>
        </div>

        <form method="POST" class="space-y-6">
            <!-- Username -->
            <div class="relative">
                <input type="text" name="username" id="username" required
                    class="peer w-full px-4 pt-5 pb-2 text-sm border border-gray-300 rounded-md placeholder-transparent focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    placeholder="Username" />
                <label for="username"
                    class="absolute left-3 text-sm text-gray-500 bg-white px-1 transition-all duration-200 peer-placeholder-shown:top-3 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-focus:top-[-10px] peer-focus:text-sm peer-focus:text-indigo-600">
                    Username
                </label>
            </div>

            <!-- Password -->
            <div class="relative">
                <input type="password" name="password" id="password" required
                    class="peer w-full px-4 pt-5 pb-2 text-sm border border-gray-300 rounded-md placeholder-transparent focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    placeholder="Password" />
                <label for="password"
                    class="absolute left-3 text-sm text-gray-500 bg-white px-1 transition-all duration-200 peer-placeholder-shown:top-3 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-focus:top-[-10px] peer-focus:text-sm peer-focus:text-indigo-600">
                    Password
                </label>
            </div>

            <button name="login_user" type="submit"
                class="w-full py-2 font-semibold text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition">
                Login sebagai User
            </button>
        </form>

        <p class="mt-6 text-xs text-center text-gray-400 italic">
            Ayo gunakan hak suara kamu!
        </p>
    </div>

</body>

</html>