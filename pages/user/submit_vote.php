<?php
require_once '../../config/connection.php';

$id_pemilih = $_SESSION['id_pemilih'] ?? null;
if (!$id_pemilih) {
    header("Location: ../../auth/login_user.php");
    exit;
}

$id_event = $_GET['id_event'] ?? null;
$id_kandidat = $_GET['id_kandidat'] ?? null;

if (!$id_event || !$id_kandidat) {
    header("Location: vote_event.php");
    exit;
}

// Cek apakah pemilih sudah memilih di event ini
$cek = query("SELECT * FROM pilih WHERE id_pemilih = $id_pemilih AND id_event = $id_event");
if ($cek && count($cek) > 0) {
    echo "<script>alert('Anda sudah memilih di event ini!'); window.location.href = 'riwayat.php';</script>";
    exit;
}

// Buat tanda terima (unik)
$tanda_terima = uniqid("TRM-");

// Simpan ke tabel pilih
$stmt = $conn->prepare("INSERT INTO pilih (id_pemilih, id_event, id_kandidat, tanda_terima) VALUES (?, ?, ?, ?)");
$stmt->bind_param("iiis", $id_pemilih, $id_event, $id_kandidat, $tanda_terima);
$sukses = $stmt->execute();

if ($sukses) {
    $_SESSION['vote_success'] = "Pilihan berhasil disimpan! Tanda Terima: $tanda_terima";
    header("Location: lihat_pilihan.php?id_event=$id_event.");
    exit;
} else {
    echo "<script>alert('Terjadi kesalahan saat menyimpan pilihan.'); window.location.href = 'vote_event.php';</script>";
}

$stmt->close();
