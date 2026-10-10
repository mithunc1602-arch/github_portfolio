<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$host = "localhost";
$port = 3308; // Change to 3306 if that is your MySQL port.
$username = "root";
$password = "root"; // Use "" if your MySQL root account has no password.
$database = "password generator";

try {
    $conn = mysqli_connect($host, $username, $password, $database, $port);
    mysqli_set_charset($conn, "utf8");
} catch (mysqli_sql_exception $e) {
    die("Database connection failed. Check that MySQL is running and db.php has the correct port, username, and password. Details: " . htmlspecialchars($e->getMessage()));
}
?>