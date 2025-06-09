<?php
// Cek login session admin
if (!isset($_SESSION['login_admin'])) {
    header("Location: ../auth/login_admin.php");
    exit;
}
session_start();

$_SESSION = [];
session_unset();
session_destroy();

header("Location: login_admin.php?logout=success");
exit;
