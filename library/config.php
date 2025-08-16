<?php 
$dbhost = 'localhost'; 
$dbuser = 'root'; 
$dbpass = ''; 
$dbname = 'db_mis'; 

$conn = mysqli_connect($dbhost, $dbuser , $dbpass, $dbname);

mysqli_select_db($conn, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
