<?php
$severname = "localhost";
$username = "root";
$password = "";
$dbname = "transporte_bd";

// create conection witht password
$conn = mysqli_connect($severname, $username, $password, $dbname);

// check connection
if(!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfull";
mysqli_close($conn);
