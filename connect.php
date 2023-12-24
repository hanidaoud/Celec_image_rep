<?php
$host = "localhost";
$user = "root";
$password = "";
$db="celec";

$connect = @mysqli_connect($host,$user,$password,$db);

// Check connection
if ($connect->connect_error) {
  die("Connection failed: " . $connect->connect_error);
}
?> 