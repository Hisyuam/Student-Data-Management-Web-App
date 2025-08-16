<?php
session_start();
if (!isset($_SESSION['user_is_logged_in']) || $_SESSION['user_is_logged_in'] !== true) {
    header('Location: loginadmin.php');
    exit;
}

include "library/config.php";

// Tambah Kota
if (isset($_POST['tambah'])) {
    $nama_kota = mysqli_real_escape_string($conn, $_POST['nama_kota']);
    $query = "INSERT INTO kota (nama_kota) VALUES ('$nama_kota')";
    mysqli_query($conn, $query);
    header("Location: kotadata.php");
    exit;
}

// Edit Kota
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $nama_kota = mysqli_real_escape_string($conn, $_POST['nama_kota']);
    $query = "UPDATE kota SET nama_kota = '$nama_kota' WHERE kota_id = '$id'";
    mysqli_query($conn, $query);
    header("Location: kotadata.php");
    exit;
}

// Hapus Kota
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];

    // Cek apakah kota sedang digunakan oleh mahasiswa
    $cek = mysqli_query($conn, "SELECT COUNT(*) as total FROM mahasiswa WHERE kota_id = '$id'");
    $data = mysqli_fetch_assoc($cek);

    if ($data['total'] > 0) {
        // Jika kota sedang digunakan, tampilkan pesan dan kembali
        echo "<script>
            alert('Kota tidak bisa dihapus karena sedang digunakan oleh data mahasiswa.');
            window.location.href = 'kotadata.php';
        </script>";
        exit;
    }

    // Jika tidak digunakan, hapus kota
    $query = "DELETE FROM kota WHERE kota_id = '$id'";
    if (mysqli_query($conn, $query)) {
        header("Location: kotadata.php");
        exit;
    } else {
        echo "<script>
            alert('Terjadi kesalahan saat menghapus kota.');
            window.location.href = 'kotadata.php';
        </script>";
    }
}
