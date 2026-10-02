<?php
$conn = mysqli_connect("localhost", "root", "root", "chess_game");
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
mysqli_set_charset($conn, "utf8");
?>