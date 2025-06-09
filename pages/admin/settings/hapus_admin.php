<?php
require_once '../../../config/connection.php';

// Cek login session admin
if (!isset($_SESSION['login_admin'])) {
    header("Location: ../../../auth/login_admin.php");
    exit;
}

$id = $_GET["id"];

if (deleteAdmin($id) > 0) {
    header("Location: daftar_admin.php?success=hapus");
    exit;
} else {
    header("Location: daftar_admin.php?error=1");
    exit;
};