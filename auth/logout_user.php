<?php
session_start();

// Cek login session admin
if (!isset($_SESSION['login_user'])) {
    header("Location: ../auth/login_user.php");
    exit;
}

$_SESSION = [];
session_unset();
session_destroy();

header("Location: login_user.php?logout=success");
exit;