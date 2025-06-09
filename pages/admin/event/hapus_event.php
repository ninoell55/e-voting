<?php
require_once '../../../config/connection.php';

// Cek login session admin
if (!isset($_SESSION['login_admin'])) {
    header("Location: ../../../auth/login_admin.php");
    exit;
}

$id = $_GET["id"];

if (deleteEvent($id) > 0) {
    header("Location: daftar_event.php?success=hapus");
    exit;
} else {
    header("Location: daftar_event.php?error=1");
    exit;
};
