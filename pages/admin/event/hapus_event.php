<?php
require_once '../../../config/connection.php';


$id = $_GET["id"];

if (deleteEvent($id) > 0) {
    header("Location: daftar_event.php?success=hapus");
    exit;
} else {
    header("Location: daftar_event.php?error=1");
    exit;
};
