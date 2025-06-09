 <?php
    require_once '../../../config/connection.php';
    $pageTitle = "Log Suara";

    // Cek login session admin
    if (!isset($_SESSION['login_admin'])) {
        header("Location: ../../../auth/login_admin.php");
        exit;
    }

    $query = "SELECT 
                p.username, 
                e.nama_event, 
                k.nama_kandidat, 
                pl.tanda_terima, 
                pl.created_at
            FROM pilih pl
            JOIN pemilih p ON pl.id_pemilih = p.id_pemilih
            JOIN kandidat k ON pl.id_kandidat = k.id_kandidat
            JOIN event e ON pl.id_event = e.id_event
            ORDER BY pl.created_at DESC
          ";
    $data = mysqli_query($conn, $query);

    include '../../../includes/header.php';
    include '../../../includes/sidebar.php';
    ?>

 <main id="mainContent" class="flex-1 p-6 mt-16 ml-64 transition-all duration-300 bg-gray-100">

     <div class="mb-6">
         <nav class="mb-1 text-sm text-gray-500">
             <ol class="flex list-reset">
                 <li><a href="#" class="text-blue-600 hover:underline">Pages</a></li>
                 <li><span class="mx-2">/</span></li>
                 <li class="text-gray-800"><?= $pageTitle ?></li>
             </ol>
         </nav>
         <h1 class="text-2xl font-bold text-gray-800"><?= $pageTitle ?></h1>
     </div>


     <div class="w-full max-w-full p-6 bg-white shadow-lg rounded-xl">
         <div class="flex items-center justify-center mb-4 sm:justify-between">
             <h2 class="text-2xl font-semibold text-gray-700">Log Suara Pemilih</h2>
         </div>

         <table id="dataTables"
             class="min-w-full overflow-x-auto text-sm text-gray-800 border border-gray-200 rounded-lg display responsive nowrap">
             <thead class="font-semibold text-gray-700 bg-gray-100">
                 <tr class="text-sm font-semibold text-left text-gray-700 bg-gray-100">
                     <th class="px-6 py-3">No</th>
                     <th class="px-6 py-3">Username</th>
                     <th class="px-6 py-3">Event</th>
                     <th class="px-6 py-3">Kandidat yang dipilih</th>
                     <th class="px-6 py-3">Tanda Terima</th>
                     <th class="px-6 py-3">Waktu Memilih</th>
                 </tr>
             </thead>
             <tbody>
                 <?php $no = 1; ?>
                 <?php foreach ($data as $row) : ?>
                     <tr class="transition hover:bg-gray-100">
                         <td class="px-6 py-4"><?= $no++ ?></td>
                         <td class="px-6 py-4"><?= htmlspecialchars($row['username']) ?></td>
                         <td class="px-6 py-4"><?= htmlspecialchars($row['nama_event']) ?></td>
                         <td class="px-6 py-4"><?= htmlspecialchars($row['nama_kandidat']) ?></td>
                         <td class="px-6 py-4"><?= htmlspecialchars($row['tanda_terima']) ?></td>
                         <td class="px-6 py-4"><?= date('d M Y, H:i', strtotime($row['created_at'])) ?></td>
                     </tr>
                 <?php endforeach; ?>
             </tbody>
         </table>
     </div>
 </main>

 <?php include '../../../includes/footer.php'; ?>