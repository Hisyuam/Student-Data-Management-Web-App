<?php 

session_start(); 
if (!isset($_SESSION['mahasiswa_is_logged_in']) || $_SESSION['mahasiswa_is_logged_in'] !== true) { 
    header('Location: index.php'); 
    exit; 
} 

include "library/config.php";

$mahasiswaId = $_SESSION['mahasiswa_id']; // Ambil user_id dari session


// Ambil data mahasiswa yang terkait dengan user yang login
$query = "SELECT m.*, k.*, m.mahasiswa_id 
FROM mahasiswa m
JOIN kota k ON m.kota_id = k.kota_id
JOIN user_mahasiswa um ON m.mahasiswa_id = um.mahasiswa_id
WHERE m.mahasiswa_id = '$mahasiswaId'";


$sql = mysqli_query($conn, $query);
if (!$sql) {
    die('Query failed: ' . mysqli_error($conn));
}

$no = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <link href="css/bootstrap.min.css" rel="stylesheet" />
  <script src="js/bootstrap.bundle.min.js"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Data Mahasiswa</title>
</head>
<body>
<nav class="navbar bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Data Mahasiswa</a>
    <a href="logout.php" class="btn btn-danger">Logout</a>
  </div>
</nav>


<div class="container">
  <h1 class="mt-4">DATA MAHASISWA</h1>
  <figure>
    <blockquote class="blockquote">
      <p>Berisi Data mahasiswa yang telah disimpan</p>
    </blockquote>
  </figure>

  <div class="table-responsive">
    <table class="table align-middle table-bordered table-hover">
      <thead>
        <tr>
          <th><center>NO</center></th>
          <th>NRP</th>
          <th>Nama</th>
          <th>Alamat</th>
          <th>Jenis Kelamin</th>
          <th>Tanggal Lahir</th>
          <th>Email</th>
          <th>No HP</th>
          <th>Foto</th>
          <th>Kota</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($result = mysqli_fetch_assoc($sql)) { ?>
          <tr>
            <td><center><?php echo ++$no; ?>.</center></td>
            <td><?php echo $result['nrp']; ?></td>
            <td><?php echo $result['nama']; ?></td>
            <td><?php echo $result['alamat']; ?></td>
            <td><?php echo $result['jenis_kelamin']; ?></td>
            <td><?php echo $result['tanggal_lahir']; ?></td>
            <td><?php echo $result['email']; ?></td>
            <td><?php echo $result['no_hp']; ?></td>
            <td>
              <?php if (!empty($result['foto']) && file_exists("uploads/" . $result['foto'])) { ?>
                <img src="uploads/<?php echo $result['foto']; ?>" alt="Foto" style="width: 100px;">
              <?php } else { echo "Tidak ada foto"; } ?>
            </td>
            <td><?php echo $result['nama_kota']; ?></td>
            <td>
              <a href="kelola.php?ubah=<?php echo $result['mahasiswa_id']; ?>" class="btn btn-success">Edit</a>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>

</body>
</html>
