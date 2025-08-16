<?php 

session_start(); 
if (!isset($_SESSION['user_is_logged_in']) || $_SESSION['user_is_logged_in'] !== true) { 
    header('Location: loginadmin.php'); 
    exit; 
} 

include "library/config.php";

  $userId = $_SESSION['user_id'];

  $user_id = '';
  $nrp=''; 
  $nama='';
  $jenis_kelamin='';
  $alamat=''; 
  $tanggal_lahir= ''; 
  $no_hp=''; 
  $email= ''; 
  $foto=''; 
  $kota= '';


  if (isset($_GET['ubah'])) {
    $mahasiswa_id = $_GET['ubah'];  // ini harus $mahasiswa_id bukan $user_id

    $queryCheck = "SELECT m.* FROM mahasiswa m 
    JOIN user_mahasiswa um ON m.mahasiswa_id = um.mahasiswa_id 
    WHERE m.mahasiswa_id = '$mahasiswa_id'";
    $sqlCheck = mysqli_query($conn, $queryCheck);

    $result = mysqli_fetch_assoc($sqlCheck);
    $nrp = $result['nrp'];
    $nama = $result['nama'];
    $jenis_kelamin = $result['jenis_kelamin'];
    $alamat = $result['alamat'];
    $tanggal_lahir = $result['tanggal_lahir'];
    $no_hp = $result['no_hp'];
    $email = $result['email'];
    $kota = $result['kota_id'];
    $foto = $result['foto'];
}


  // Jika mode tambah (form kosong)
if (isset($_GET['tambah'])) {
  // Kosongkan semua variabel supaya form kosong
  $mahasiswa_id = '';
  $nrp = '';
  $nama = '';
  $jenis_kelamin = '';
  $alamat = '';
  $tanggal_lahir = '';
  $no_hp = '';
  $email = '';
  $foto = '';
  $kota = '';
}
  // Cek apakah user sudah punya data mahasiswa (kalau BUKAN mode edit)
  
?>

<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link href="css/bootstrap.min.css" rel="stylesheet" />
    <script src="js/bootstrap.bundle.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Kelola</title>
  </head>
  <body>
    <nav class="navbar bg-body-tertiary mb-5">
      <div class="container-fluid">
        <a class="navbar-brand" href="#"> KELOLA DATA </a>
      </div>
    </nav>
    <div class="container">
      <form method="POST" action="prosesadmin.php" enctype="multipart/form-data">
        <input type="hidden" value="<?php echo $mahasiswa_id; ?>" name="mahasiswa_id">
        
        <!-- Input NRP -->
        <div class="mb-3 row">
          <label for="nrp" class="col-sm-2 col-form-label">NRP</label>
          <div class="col-sm-10">
            <input required type="text" name="nrp" class="form-control" id="nrp" placeholder="xxxx" value="<?php echo $nrp ?>" />
          </div>
        </div>

        <!-- Input Nama -->
        <div class="mb-3 row">
          <label for="nama" class="col-sm-2 col-form-label">NAMA</label>
          <div class="col-sm-10">
            <input required type="text" name="nama" class="form-control" id="nama" placeholder="xxxx" value="<?php echo $nama ?>" />
          </div>
        </div>

        <!-- Dropdown Jenis Kelamin -->
        <div class="mb-3 row">
          <label for="jkel" class="col-sm-2 col-form-label">JENIS KELAMIN</label>
          <div class="col-sm-10">
            <select required id="jkel" name="jenis_kelamin" class="form-select">
              <option <?php if (empty($jenis_kelamin)) echo "selected"; ?>>Pilih Jenis Kelamin</option>
              <option <?php if ($jenis_kelamin == 'Laki-Laki') echo "selected"; ?> value="Laki-Laki">Laki-Laki</option>
              <option <?php if ($jenis_kelamin == 'Perempuan') echo "selected"; ?> value="Perempuan">Perempuan</option>
            </select>
          </div>
        </div>

        <!-- Input Foto -->
        <div class="mb-3 row">
          <label for="foto" class="col-sm-2 col-form-label">FOTO</label>
          <div class="col-sm-10">
            <!-- Jika sedang mengedit dan foto ada, tampilkan foto lama -->
            <?php if (isset($_GET['ubah']) && !empty($foto)): ?>
              <img src="uploads/<?php echo $foto; ?>" alt="Foto Mahasiswa" width="100" height="100" />
              <br><br>
            <?php endif; ?>
            <input type="file" class="form-control" name="foto" id="foto" accept="image/*" <?php if(!isset($_GET['ubah'])) { echo "required"; } ?> />
              <?php if (isset($_GET['ubah']) && !empty($foto)): ?>
            <input type="hidden" name="existing_foto" value="<?php echo $foto; ?>">
              <?php endif; ?>
          </div>
        </div>

        <!-- Input Tanggal Lahir -->
        <div class="mb-3 row">
          <label for="tanggal_lahir" class="col-sm-2 col-form-label">Tanggal Lahir</label>
          <div class="col-sm-10">
            <input required type="date" name="tanggal_lahir" class="form-control" id="tanggal_lahir" value="<?php echo $tanggal_lahir; ?>" />
          </div>
        </div>

        <!-- Input No HP -->
        <div class="mb-3 row">
          <label for="no_hp" class="col-sm-2 col-form-label">No HP</label>
          <div class="col-sm-10">
            <input required type="text" name="no_hp" class="form-control" id="no_hp" placeholder="08123456789" value="<?php echo $no_hp; ?>" />
          </div>
        </div>

        <!-- Input Email -->
        <div class="mb-3 row">
          <label for="email" class="col-sm-2 col-form-label">Email</label>
          <div class="col-sm-10">
            <input required type="email" name="email" class="form-control" id="email" placeholder="email@example.com" value="<?php echo $email; ?>" />
          </div>
        </div>

        <!-- Dropdown Kota -->
        <div class="mb-3 row">
  <label for="kota" class="col-sm-2 col-form-label">Kota</label>
  <div class="col-sm-10">
    <select required name="kota" id="kota" class="form-select">
      <option value="">Pilih Kota</option>
      <?php
        // Query untuk mengambil data kota dari database
        $queryKota = "SELECT * FROM kota";
        $sqlKota = mysqli_query($conn, $queryKota);
        while ($kotaData = mysqli_fetch_assoc($sqlKota)) {
          // Pastikan value yang dikirim adalah id_kota, bukan nama_kota
          $selected = ($kotaData['kota_id'] == $kota) ? "selected" : "";
          echo "<option value='" . $kotaData['kota_id'] . "' $selected>" . $kotaData['nama_kota'] . "</option>";
        }
      ?>
    </select>
  </div>
</div>

        <!-- Input Alamat -->
        <div class="mb-3 row">
          <label for="alamat" class="col-sm-2 col-form-label">ALAMAT</label>
          <div class="col-sm-10">
            <textarea required class="form-control" placeholder="Alamat lengkap" name="alamat" id="alamat" style="height: 100px"><?php echo $alamat; ?></textarea>
          </div>
        </div>

        <!-- Button Submit -->
        <div class="mb-3 row mt-3">
          <div class="col-sm-10">
            <?php if(isset($_GET['ubah'])): ?>
              <button href="kelolamahasiswa.php" type="submit" name="aksi" value="edit" class="btn btn-primary">Simpan Perubahan</button>
            <?php else: ?>
              <button href="kelolamahasiswa.php" type="submit" name="aksi" value="add" class="btn btn-primary">Tambahkan</button>
            <?php endif; ?>
            <a href="kelolamahasiswa.php" type="button" class="btn btn-danger">Batal</a>
          </div>
        </div>

      </form>
    </div>
  </body>
</html>
