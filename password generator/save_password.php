
<?php
require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit;
}

// Get generated password
$password_text = trim($_POST["password_text"] ?? "");

// Validate password
if ($password_text === "") {
    die("Error: Password is empty. Please generate a password first.");
}

// Calculate actual password length
$password_length = strlen($password_text);

// Insert into database
$sql = "INSERT INTO passwords (password_text, password_length)
        VALUES (?, ?)";

$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    die("SQL prepare error: " . mysqli_error($conn));
}

mysqli_stmt_bind_param(
    $stmt,
    "si",
    $password_text,
    $password_length
);

if (mysqli_stmt_execute($stmt)) {
    mysqli_stmt_close($stmt);
    header("Location: history.php?saved=1");
    exit;
} else {
    echo "Error saving password: " . mysqli_stmt_error($stmt);
    mysqli_stmt_close($stmt);
}
?>
