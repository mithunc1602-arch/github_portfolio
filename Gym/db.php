<?php
$host = "localhost:3308";
$username = "root";
$password = "root";
$database = "gym_management";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}else{
echo "";
}
mysqli_set_charset($conn, "utf8");

?>
