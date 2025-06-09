<?php
// Cek login session admin
if (!isset($_SESSION['login_admin'])) {
    header("Location: ../auth/login_user.php");
    exit;
}
session_start();

$_SESSION = [];
session_unset();
session_destroy();

header("Location: login_user.php?logout=success");
exit;