<?php
require_once '../../../config/connection.php';

$id = $_GET['id'];
$id_event = $_GET['id_event'];

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
        alert('Kandidat berhasil dihapus!');
        window.location.href = 'daftar_kandidat.php?id=$id_event';
      </script>";
