<?php
$host = "localhost:3308";
$username = "root";
$password = "root";
$database = "gym_project";
$port = 3308; // Change to 3306 if your XAMPP MySQL uses 3306.

$conn = mysqli_connect($host, $username, $password, $database, $port);

if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8");
?>