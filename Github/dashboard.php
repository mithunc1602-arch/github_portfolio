<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include("db.php");
include("header.php");
?>

<h2>Dashboard</h2>

<?php if ($_SESSION['role'] === 'admin'): ?>

<?php
$members = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM members"))['total'];
$trainers = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM trainers"))['total'];
$payments = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COALESCE(SUM(amount),0) AS total FROM payments"))['total'];
?>

<div class="grid">
    <div class="stat"><h2><?php echo $members; ?></h2><p>Total Members</p></div>
    <div class="stat"><h2><?php echo $trainers; ?></h2><p>Total Trainers</p></div>
    <div class="stat"><h2>₹<?php echo number_format($payments, 2); ?></h2><p>Total Payments</p></div>
</div>

<div class="card">
    <h3>Admin Menu</h3>
    <a class="btn" href="members.php">Members</a>
    <a class="btn" href="trainers.php">Trainers</a>
    <a class="btn" href="plans.php">Plans</a>
    <a class="btn" href="exercises.php">Exercises</a>
    <a class="btn" href="workouts.php">Workouts</a>
    <a class="btn" href="diet.php">Diet</a>
    <a class="btn" href="attendance.php">Attendance</a>
    <a class="btn" href="payments.php">Payments</a>
    <a class="btn" href="progress.php">Progress</a>
</div>

<?php else: ?>

<?php
$user_id = (int)$_SESSION['user_id'];
$result = mysqli_query($conn, "SELECT * FROM members WHERE user_id='$user_id' LIMIT 1");
$member = mysqli_fetch_assoc($result);
?>

<div class="card">
    <h3>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?></h3>

    <?php if ($member): ?>
        <p><b>Name:</b> <?php echo htmlspecialchars($member['name']); ?></p>
        <p><b>Phone:</b> <?php echo htmlspecialchars($member['phone']); ?></p>
        <p><b>Status:</b> <?php echo htmlspecialchars($member['status']); ?></p>
    <?php endif; ?>
</div>

<div class="card">
    <a class="btn" href="member_workouts.php">My Workouts</a>
    <a class="btn" href="member_diet.php">My Diet</a>
    <a class="btn" href="member_progress.php">My Progress</a>
    <a class="btn" href="bmi.php">BMI Calculator</a>
</div>

<?php endif; ?>

<?php include("footer.php"); ?>