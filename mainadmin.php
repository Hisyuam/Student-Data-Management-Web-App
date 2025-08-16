<?php 
session_start(); 
if (!isset($_SESSION['user_is_logged_in']) || $_SESSION['user_is_logged_in'] !== true) { 
    header('Location: loginadmin.php'); 
    exit; 
} 

include "library/config.php";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Halaman Admin</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            min-height: 100vh;
            background-color: #f8f9fa;
            display: flex;
            flex-direction: column;
        }
        main {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem;
        }
        .welcome-text {
            margin-bottom: 50px;
            font-weight: 600;
            font-size: 2rem;
            text-align: center;
        }
        .btn-custom-lg {
            padding: 3rem 6rem;
            font-size: 1.75rem;
            border-radius: 0.5rem;
            white-space: nowrap;
        }
    </style>
</head>
<body>

<nav class="navbar bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Data Mahasiswa</a>
    <div class="d-flex gap-2">
      <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
  </div>
</nav>

<main>
    <div class="welcome-text">
        <?php 
            echo "Selamat datang, admin!";
        ?>
    </div>

    <div class="d-flex gap-4">
        <a href="kotadata.php" class="btn btn-primary btn-custom-lg">Kelola Kota</a>
        <a href="kelolamahasiswa.php" class="btn btn-success btn-custom-lg">Kelola Mahasiswa</a>
    </div>
</main>
</body>
</html>
