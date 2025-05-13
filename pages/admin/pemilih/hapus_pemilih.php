<?php
require_once '../../../config/connection.php';


$id = $_GET["id"];

if (deletePemilih($id) > 0) {
    header("Location: daftar_pemilih.php?success=hapus");
    exit;
} else {
    header("Location: daftar_pemilih.php?error=1");
    exit;
};
