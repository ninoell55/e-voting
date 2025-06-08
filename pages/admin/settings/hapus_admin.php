<?php
require_once '../../../config/connection.php';


$id = $_GET["id"];

if (deleteAdmin($id) > 0) {
    header("Location: daftar_admin.php?success=hapus");
    exit;
} else {
    header("Location: daftar_admin.php?error=1");
    exit;
};