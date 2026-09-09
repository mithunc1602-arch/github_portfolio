<?php
/*
Run this file once after importing database.sql:
http://localhost/gym_project/setup.php
Then delete setup.php for safety.
*/
include("db.php");

$name = "Administrator";
$email = "admin@gmail.com";
$password = password_hash("admin123", PASSWORD_DEFAULT);
$role = "admin";

$check = mysqli_query($conn, "SELECT id FROM users WHERE email='$email' LIMIT 1");

if (mysqli_num_rows($check) === 0) {
    mysqli_query($conn, "INSERT INTO users(name,email,password,role)
        VALUES('$name','$email','$password','$role')");
    echo "Admin account created.<br>";
} else {
    echo "Admin account already exists.<br>";
}

echo "Email: admin@gmail.com<br>Password: admin123<br>";
echo "Delete setup.php after running it.";
?>