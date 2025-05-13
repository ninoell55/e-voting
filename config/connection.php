<?php
session_start();
$base_url = "/e-voting/";

$host = "localhost";
$username = "root";
$password = "";
$dbname = "e-voting";

$conn = mysqli_connect($host, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


// <<< SELECT DATA
function query($query)
{
    global $conn;

    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    return $rows;
}
// SELECT DATA >>>


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


// Status Update
function updateEventStatus()
{
    global $conn;
    $today = date("Y-m-d");

    $query = "UPDATE event
                SET status = 
                    CASE
                        WHEN '$today' BETWEEN tgl_mulai AND tgl_selesai THEN 'aktif'
                        ELSE 'nonaktif'
                    END
              ";

    mysqli_query($conn, $query);
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
        'tambah' => 'berhasil ditambahkan.',
        'edit' => 'berhasil diedit.',
        'hapus' => 'berhasil dihapus.',
        default => 'Aksi berhasil dilakukan.'
    };

    $isHapus = ($type === 'hapus');
    $bgColor = $isHapus ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700';
    $hoverColor = $isHapus ? 'hover:text-red-900' : 'hover:text-green-900';

    echo "
        <div id='alert-box' class='$bgColor p-4 rounded mb-4 flex justify-between items-center'>
            <span>$message</span>
            <button onclick=\"document.getElementById('alert-box').style.display='none'\"
                class='text-xl font-bold px-2 leading-none $hoverColor'>&times;</button>
        </div>
    ";
}
// PESAN SUKSES >>>



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