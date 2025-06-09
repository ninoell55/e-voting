<?php
require_once '../../../config/connection.php';

// Cek login session admin
if (!isset($_SESSION['login_admin'])) {
    header("Location: ../../../auth/login_admin.php");
    exit;
}

$id = $_GET['id'];
if (!isset($id) || !is_numeric($id)) {
    header("Location: daftar_kandidat.php?success=invalid");
    exit;
}
$id_event = $_GET['id_event'];
if (!isset($id_event) || !is_numeric($id_event)) {
    header("Location: daftar_kandidat.php?success=invalid");
    exit;
}

// ambil data kandidat untuk mengetahui nama file gambar
$kandidat = query("SELECT * FROM kandidat WHERE id_kandidat = $id")[0];

// hapus gambar dari folder jika ada
if ($kandidat['gambar'] && file_exists("../../../assets/img/" . $kandidat['gambar'])) {
    unlink("../../../assets/img/" . $kandidat['gambar']);
}

// hapus dari database
mysqli_query($conn, "DELETE FROM kandidat WHERE id_kandidat = $id");

// redirect kembali ke daftar kandidat
echo "<script>
        window.location.href = 'daftar_kandidat.php?success=hapus';
      </script>";
