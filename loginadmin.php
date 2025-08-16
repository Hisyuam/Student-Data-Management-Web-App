<?php 
session_start(); 
$errorMessage = ''; 

if (isset($_POST['txtUserId']) && isset($_POST['txtPassword'])) { 
  include 'library/config.php'; 
  include 'library/opendb.php'; 

  $username = $_POST['txtUserId']; 
  $password = $_POST['txtPassword']; 

  // Cek apakah username dan password sesuai
  $sql = "SELECT user_id, username FROM user WHERE username = '$username' AND password = '$password'"; 
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) == 1) { 
    $row = mysqli_fetch_assoc($result);
    $_SESSION['user_id'] = $row['user_id']; 
    $_SESSION['user_is_logged_in'] = true;
    header('Location: mainadmin.php'); // Ganti dengan halaman data yang kamu pakai
    exit;
  } else { 
    $errorMessage = 'Sorry, wrong user id / password'; 
  } 

  include 'library/closedb.php'; 
} 
?>

<!DOCTYPE html>
<html lang="en"> 
<head> 
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title> 
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head> 
<body class="bg-light">

  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card shadow-lg">
          <div class="card-header text-center">
            <h3 class="mb-0">Login Admin</h3>
          </div>
          <div class="card-body">

            <?php if ($errorMessage != '') { ?> 
              <div class="alert alert-danger text-center"><?php echo $errorMessage; ?></div>
            <?php } ?>

            <form method="post" id="frmLogin">
              <div class="mb-3">
                <label for="txtUserId" class="form-label">Username</label>
                <input name="txtUserId" type="text" class="form-control" id="txtUserId" required>
              </div>

              <div class="mb-3">
                <label for="txtPassword" class="form-label">Password</label>
                <input name="txtPassword" type="password" class="form-control" id="txtPassword" required>
              </div>

              <div class="d-grid">
                <button type="submit" name="btnLogin" class="btn btn-primary">Login</button>
              </div>

              <div class="text-center mt-3">
                <small>Login Mahasiswa <a href="index.php">Login Disini</a></small>
              </div>  
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>

</body> 
</html>