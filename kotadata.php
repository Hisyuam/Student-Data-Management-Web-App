<?php 

session_start(); 
if (!isset($_SESSION['user_is_logged_in']) || $_SESSION['user_is_logged_in'] !== true) { 
    header('Location: loginadmin.php'); 
    exit; 
} 

include "library/config.php";

$query = "SELECT k.*
FROM kota k";

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
  <title>Data Kota</title>
</head>
<body>
<nav class="navbar bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Data Kota</a>
    
    <a href="logout.php" class="btn btn-danger">Logout</a>
  </div>
</nav>


<div class="container">
  <h1 class="mt-4">DATA KOTA</h1>
  <figure>
    <blockquote class="blockquote">
      <p>Berisi data Kota Yang Telah disimpan </p>
    </blockquote>
  </figure> 
  
  <a href="kelolakota.php?tambah" type="button" class="btn btn-primary mb-4">Tambah Data</a>
  <a href="mainadmin.php" type="button" class="btn btn-secondary mb-4">Kembali ke Main</a>
 
  <div class="table-responsive">
    <table class="table align-middle table-bordered table-hover">
    <thead>
  <tr>
    <th><center>No</center></th>
    <th>Nama Kota</th>
    <th>Aksi</th>
  </tr>
    </thead>
    <tbody>
    <?php while ($result = mysqli_fetch_assoc($sql)) { ?>
        <tr>
            <td><center><?php echo ++$no; ?></center></td>
            <td><?php echo $result['nama_kota']; ?></td>
            <td>
                <a href="kelolakota.php?ubah=<?php echo $result['kota_id']; ?>" class="btn btn-success">Edit</a>
                <a href="proseskota.php?hapus=<?php echo $result['kota_id']; ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus kota ini?')">Hapus</a>
            </td>
        </tr>
         <?php } ?>
</tbody>
    </table>
  </div>
</div>

</body>
</html>
