<?php
require_once "db.php";

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
if (!$id || $id < 1) {
    die("Invalid password ID.");
}

$stmt = mysqli_prepare($conn, "DELETE FROM passwords WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

header("Location: history.php");
exit;
?>