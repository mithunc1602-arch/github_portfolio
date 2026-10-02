<?php
include("db.php");
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: chess.php");
    exit;
}
$white = trim($_POST["white_player"]);
$black = trim($_POST["black_player"]);
$winner = trim($_POST["winner"]);
$result = trim($_POST["result"]);

$stmt = mysqli_prepare($conn, "INSERT INTO games (white_player, black_player, winner, result) VALUES (?, ?, ?, ?)");
mysqli_stmt_bind_param($stmt, "ssss", $white, $black, $winner, $result);

if (mysqli_stmt_execute($stmt)) {
    header("Location: history.php?saved=1");
    exit;
}
die("Unable to save game: " . mysqli_error($conn));
?>