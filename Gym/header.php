<?php require_once 'auth.php'; ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Gym Management</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="topbar">
    <div class="brand">GYM MANAGEMENT</div>
    <div class="user">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?> | <a href="logout.php">Logout</a></div>
</div>
<div class="nav">
    <a href="dashboard.php">Dashboard</a>
    <a href="members.php">Members</a>
    <a href="trainers.php">Trainers</a>
    <a href="attendance.php">Attendance</a>
    <a href="payments.php">Payments</a>
</div>
<div class="container">
