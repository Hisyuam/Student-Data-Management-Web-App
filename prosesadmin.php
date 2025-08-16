<?php
session_start();
include "library/config.php";

// Hapus data
if (isset($_GET['hapus'])) {
  $mahasiswa_id = $_GET['hapus'];

  // Ambil nama file foto
  $queryFoto = "SELECT foto FROM mahasiswa WHERE mahasiswa_id = '$mahasiswa_id'";
  $resultFoto = mysqli_query($conn, $queryFoto);
  if ($resultFoto && mysqli_num_rows($resultFoto) > 0) {
    $row = mysqli_fetch_assoc($resultFoto);
    $foto = $row['foto'];
    if (!empty($foto) && file_exists("uploads/$foto")) {
      unlink("uploads/$foto"); // Hapus file foto dari folder
    }
  }

  // Hapus data dari tabel user_mahasiswa
  mysqli_query($conn, "DELETE FROM user_mahasiswa WHERE mahasiswa_id = '$mahasiswa_id'");

  // Hapus data dari tabel mahasiswa
  $query = "DELETE FROM mahasiswa WHERE mahasiswa_id = '$mahasiswa_id'";
  $sql = mysqli_query($conn, $query);

  if ($sql) {
    header("Location: kelolamahasiswa.php");
    exit();
  } else {
    echo "Gagal menghapus data: " . mysqli_error($conn);
  }
}

// Proses tambah / edit data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $mahasiswa_id = $_POST['mahasiswa_id'] ?? '';
  $nrp = $_POST['nrp'];
  $nama = $_POST['nama'];
  $jenis_kelamin = $_POST['jenis_kelamin'];
  $alamat = $_POST['alamat'];
  $tanggal_lahir = $_POST['tanggal_lahir'];
  $no_hp = $_POST['no_hp'];
  $email = $_POST['email'];
  $kota = $_POST['kota'];

  // Upload foto
  $foto = $_FILES['foto']['name'];
  $foto_tmp = $_FILES['foto']['tmp_name'];
  $foto_path = 'uploads/' . $foto;

  // Ambil foto lama (jika tidak upload baru)
  $existing_foto = $_POST['existing_foto'] ?? '';
  if (!empty($foto)) {
    move_uploaded_file($foto_tmp, $foto_path);
  } else {
    $foto = $existing_foto;
  }

  // Tambah Data
  if (isset($_POST['aksi']) && $_POST['aksi'] === 'add') {
    if (!empty($kota)) {
      // Cek apakah kota valid
      $cekKota = mysqli_query($conn, "SELECT kota_id FROM kota WHERE kota_id = '$kota'");
      if (mysqli_num_rows($cekKota) > 0) {
        // Simpan ke tabel mahasiswa
        $query = "INSERT INTO mahasiswa (nrp, nama, jenis_kelamin, alamat, tanggal_lahir, no_hp, email, foto, kota_id)
                  VALUES ('$nrp', '$nama', '$jenis_kelamin', '$alamat', '$tanggal_lahir', '$no_hp', '$email', '$foto', '$kota')";
        $sql = mysqli_query($conn, $query);

        if ($sql) {
          // Ambil ID mahasiswa yang baru dimasukkan
          $new_mahasiswa_id = mysqli_insert_id($conn);
          $user_id = $_SESSION['user_id'];

          // Hubungkan user dan mahasiswa
          mysqli_query($conn, "INSERT INTO user_mahasiswa (user_id, mahasiswa_id) VALUES ('$user_id', '$new_mahasiswa_id')");

          header("Location: kelolamahasiswa.php");
          exit();
        } else {
          echo "Gagal menambahkan data: " . mysqli_error($conn);
        }
      } else {
        echo "ID Kota tidak valid.";
      }
    } else {
      echo "Kota tidak boleh kosong.";
    }
  }

  // Edit Data
  elseif (isset($_POST['aksi']) && $_POST['aksi'] === 'edit') {
    $query = "UPDATE mahasiswa SET 
                nrp = '$nrp',
                nama = '$nama',
                jenis_kelamin = '$jenis_kelamin',
                alamat = '$alamat',
                tanggal_lahir = '$tanggal_lahir',
                no_hp = '$no_hp',
                email = '$email',
                foto = '$foto',
                kota_id = '$kota'
              WHERE mahasiswa_id = '$mahasiswa_id'";
    $sql = mysqli_query($conn, $query);

    if ($sql) {
      header("Location: kelolamahasiswa.php");
      exit();
    } else {
      echo "Gagal mengupdate data: " . mysqli_error($conn);
    }
  }
}
?>
