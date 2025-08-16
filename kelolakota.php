<?php
session_start();
if (!isset($_SESSION['user_is_logged_in']) || $_SESSION['user_is_logged_in'] !== true) {
    header('Location: loginadmin.php');
    exit;
}

include "library/config.php";

// Cek apakah sedang dalam mode edit
$nama_kota = '';
$id = '';

if (isset($_GET['ubah'])) {
    $id = $_GET['ubah'];
    $query = "SELECT * FROM kota WHERE kota_id = '$id'";
    $sql = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($sql);
    $nama_kota = $data['nama_kota'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="css/bootstrap.min.css" rel="stylesheet" />
    <script src="js/bootstrap.bundle.min.js"></script>
    <title>Form Kota</title>
</head>
<body>
<div class="container mt-4">
    <h2><?php echo isset($_GET['ubah']) ? "Edit Kota" : "Tambah Kota"; ?></h2>
    <form action="proseskota.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <div class="mb-3">
            <label for="nama_kota" class="form-label">Nama Kota</label>
            <input type="text" class="form-control" id="nama_kota" name="nama_kota" value="<?php echo $nama_kota; ?>" required>
        </div>
        <button type="submit" name="<?php echo isset($_GET['ubah']) ? 'edit' : 'tambah'; ?>" class="btn btn-primary">
            <?php echo isset($_GET['ubah']) ? 'Simpan Perubahan' : 'Tambah'; ?>
        </button>
        <a href="kotadata.php" class="btn btn-secondary">Batal</a>
    </form>
</div>
</body>
</html>
