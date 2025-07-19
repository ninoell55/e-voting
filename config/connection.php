<?php
session_start();
$base_url = "/e_voting/";

$host = "localhost";
$username = "root";
$password = "";
$dbname = "e_voting";

$conn = mysqli_connect($host, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


// <<< SELECT DATA
function query($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Query error: " . mysqli_error($conn)); // tampilkan error MySQL
    }

    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    return $rows;
}
// SELECT DATA >>>



// <<< FUNCTION ADMIN-start
// Add
function addAdmin($data)
{
    global $conn;

    $username = htmlspecialchars($data["username"]);
    $password = htmlspecialchars($data["password"]);
    $role = htmlspecialchars($data["role"]);

    $query = "INSERT INTO admin
                VALUES
                    ('', '$username', '$password', '$role')
            ";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}


// Update
function updateAdmin($data)
{
    global $conn;

    $id_admin = $data["id_admin"];
    $username = htmlspecialchars($data["username"]);
    $password = htmlspecialchars($data["password"]);
    $role = htmlspecialchars($data["role"]);

    $query = "UPDATE admin SET
                username = '$username',
                password = '$password',
                role = '$role'
            WHERE id_admin = $id_admin
            ";
    mysqli_query($conn, $query);

    return (mysqli_affected_rows($conn) >= 0) ? 1 : 0;
}


// Delete
function deleteAdmin($id_admin)
{
    global $conn;
    mysqli_query($conn, "DELETE FROM admin WHERE id_admin = $id_admin");
    return mysqli_affected_rows($conn);
}
// end-FUNCTION ADMIN >>>



// <<< FUNCTION PEMILIH-start
// Add
function addPemilih($data)
{
    global $conn;

    $username = htmlspecialchars($data["username"]);
    $password = htmlspecialchars($data["password"]);
    $nama_lengkap = htmlspecialchars($data["nama_lengkap"]);
    $kelas = htmlspecialchars($data["kelas"]);
    $gender = htmlspecialchars($data["gender"]);

    $query = "INSERT INTO pemilih 
                VALUES
                    ('', '$username', '$password', '$nama_lengkap', '$kelas', '$gender')
            ";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}


// Update
function updatePemilih($data)
{
    global $conn;

    $id_pemilih = $data["id_pemilih"];
    $username = htmlspecialchars($data["username"]);
    $password = htmlspecialchars($data["password"]);
    $nama_lengkap = htmlspecialchars($data["nama_lengkap"]);
    $kelas = htmlspecialchars($data["kelas"]);
    $gender = htmlspecialchars($data["gender"]);

    $query = "UPDATE pemilih SET
                username = '$username',
                password = '$password',
                nama_lengkap = '$nama_lengkap',
                kelas = '$kelas',
                gender = '$gender'
            WHERE id_pemilih = $id_pemilih
            ";
    mysqli_query($conn, $query);

    return (mysqli_affected_rows($conn) >= 0) ? 1 : 0;
}


// Delete
function deletePemilih($id_pemilih)
{
    global $conn;
    mysqli_query($conn, "DELETE FROM pemilih WHERE id_pemilih = $id_pemilih");
    return mysqli_affected_rows($conn);
}
// end-FUNCTION PEMILIH >>>



// <<< FUNCTION EVENT-start
// Add
function addEvent($data)
{
    global $conn;

    $nama_event = htmlspecialchars($data["nama_event"]);
    $tgl_mulai = htmlspecialchars($data["tgl_mulai"]);
    $tgl_selesai = htmlspecialchars($data["tgl_selesai"]);

    // Validate date format
    if ($tgl_selesai < $tgl_mulai) {
        return 0; // Invalid date range
    }

    // Set status to 'active' by default
    $today = date("Y-m-d");
    $status = ($today >= $tgl_mulai && $today <= $tgl_selesai) ? 'aktif' : 'nonaktif';

    $query = "INSERT INTO event (nama_event, tgl_mulai, tgl_selesai, status)
                VALUES
                    ('$nama_event', '$tgl_mulai', '$tgl_selesai', '$status')
            ";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}


// Update
function updateEvent($data)
{
    global $conn;

    $id_event = $data["id_event"];
    $nama_event = htmlspecialchars($data["nama_event"]);
    $tgl_mulai = htmlspecialchars($data["tgl_mulai"]);
    $tgl_selesai = htmlspecialchars($data["tgl_selesai"]);

    $query = "UPDATE event SET
                nama_event = '$nama_event',
                tgl_mulai = '$tgl_mulai',
                tgl_selesai = '$tgl_selesai'
            WHERE id_event = $id_event
            ";
    mysqli_query($conn, $query);

    return (mysqli_affected_rows($conn) >= 0) ? 1 : 0;
}


// Delete
function deleteEvent($id_event)
{
    global $conn;
    mysqli_query($conn, "DELETE FROM event WHERE id_event = $id_event");
    return mysqli_affected_rows($conn);
}


function updateEventStatus()
{
    global $conn;

    // Nonaktifkan event saat ini sudah memasuki tgl_selesai
    $query = "UPDATE event SET status = 'nonaktif' WHERE tgl_selesai <= CURDATE()";
    $conn->query($query);

    // Aktifkan event yang sedang berjalan (optional)
    $queryAktif = "UPDATE event SET status = 'aktif' WHERE tgl_mulai <= CURDATE() AND tgl_selesai > CURDATE()";
    $conn->query($queryAktif);
}
// end-FUNCTION EVENT >>>



// <<< FUNCTION KANDIDAT-start
// Add
function addKandidat($data)
{
    global $conn;

    $id_event = htmlspecialchars($data["id_event"]);
    $nama_kandidat = htmlspecialchars($data["nama_kandidat"]);
    $keterangan = htmlspecialchars($data["keterangan"]);

    // upload gambar
    $gambar = upload();
    if (!$gambar) {
        return false;
    }

    // Generate kode_kandidat: format E{id_event}-{nomor urut 2 digit}
    $result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM kandidat WHERE id_event = $id_event");
    $data = mysqli_fetch_assoc($result);
    $jumlah_kandidat = isset($data['total']) ? (int)$data['total'] : 0;
    $nomor = str_pad($jumlah_kandidat + 1, 2, '0', STR_PAD_LEFT);

    $kode_kandidat = "E$id_event-$nomor";

    $query = "INSERT INTO kandidat (id_event, kode_kandidat, nama_kandidat, gambar, keterangan)
                VALUES
                    ('$id_event', '$kode_kandidat', '$nama_kandidat', '$gambar', '$keterangan')
            ";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}


// Upload Gambar
function upload()
{
    $fileSize = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    // Cek apakah tidak ada gambar yang diupload
    if ($error === 4) {
        echo "<script>alert('Silakan upload gambar terlebih dahulu!');</script>";
        return false;
    }

    // Validasi MIME type menggunakan getimagesize()
    $imageInfo = getimagesize($tmpName);
    if ($imageInfo === false) {
        echo "<script>alert('File yang Anda upload bukan gambar.');</script>";
        return false;
    }

    // Cek ukuran file (maksimal 5MB)
    if ($fileSize > 5000000) {
        echo "<script>alert('Ukuran file terlalu besar. Maksimal 5MB.');</script>";
        return false;
    }

    // Ekstensi file yang valid berdasarkan MIME
    $mimeToExt = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/gif' => 'gif',
        'image/webp' => 'webp',
        'image/bmp' => 'bmp',
        'image/svg+xml' => 'svg',
        'image/x-icon' => 'ico'
    ];

    $mimeType = $imageInfo['mime'];
    if (!array_key_exists($mimeType, $mimeToExt)) {
        echo "<script>alert('Tipe gambar tidak didukung.');</script>";
        return false;
    }

    // Generate nama file unik
    $newFileName = uniqid() . '.' . $mimeToExt[$mimeType];
    $uploadDir = '../../../assets/img/';

    // Pindahkan file
    if (!move_uploaded_file($tmpName, $uploadDir . $newFileName)) {
        echo "<script>alert('Gagal menyimpan gambar.');</script>";
        return false;
    }

    return $newFileName;
}


// Update
function updateKandidat($data)
{
    global $conn;

    $id_kandidat = htmlspecialchars($data["id_kandidat"]);
    $id_event = htmlspecialchars($data["id_event"]);
    $nama_kandidat = htmlspecialchars($data["nama_kandidat"]);
    $keterangan = htmlspecialchars($data["keterangan"]);
    $gambarLama = htmlspecialchars($data["gambar_lama"]);

    // cek apakah user pilih gambar baru
    if ($_FILES['gambar']['error'] === 4) {
        $gambar = $gambarLama;
    } else {
        $gambar = upload();
        if (!$gambar) {
            return false;
        }

        // hapus gambar lama
        if (file_exists("../../../assets/img/" . $gambarLama)) {
            unlink("../../../assets/img/" . $gambarLama);
        }
    }

    $query = "UPDATE kandidat SET
                id_event = '$id_event',
                nama_kandidat = '$nama_kandidat',
                gambar = '$gambar',
                keterangan = '$keterangan'
            WHERE id_kandidat = '$id_kandidat'";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}





// <<< PESAN SUKSES
function showSuccessAlert()
{
    if (!isset($_GET['success'])) return;

    $type = $_GET['success'];
    $message = match ($type) {
        'tambah' => 'Data berhasil ditambahkan!',
        'edit' => 'Data berhasil diedit!',
        'hapus' => 'Data berhasil dihapus!',
        'invalid' => 'Something wrong...  !',
        'error' => 'Error! Pages not found.',
        default => 'Aksi berhasil dilakukan.'
    };

    $icon = ($type === 'hapus' || $type === 'invalid' || $type === 'error') ? 'error' : 'success';

    echo "
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: '$message',
                icon: '$icon',
                confirmButtonText: 'OK'
            }).then(() => {
                window.history.replaceState(null, null, window.location.pathname);
            }).then(() => {
                Swal.fire({
                    toast: true,
                    position: 'bottom-end',
                    icon: '$icon',
                    title: '$message',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });
            });
        });
    </script>
    ";
}




// <<< SIDEBAR-isActive
function isActive($target)
{
    $currentFile = basename($_SERVER['PHP_SELF']);
    $currentUri = $_SERVER['REQUEST_URI'];


    if (strpos($target, '/') !== false) {
        return strpos($currentUri, $target) !== false;
    }

    return $currentFile === $target;
}
// SIDEBAR-isActive >>>