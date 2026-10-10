<?php
require_once 'db.php';
require_once 'header.php';
$members = mysqli_fetch_assoc(mysqli_query($conn, 'SELECT COUNT(*) AS total FROM members'))['total'];
$trainers = mysqli_fetch_assoc(mysqli_query($conn, 'SELECT COUNT(*) AS total FROM trainers'))['total'];
$attendance = mysqli_fetch_assoc(mysqli_query($conn, 'SELECT COUNT(*) AS total FROM attendance'))['total'];
$payments = mysqli_fetch_assoc(mysqli_query($conn, 'SELECT COUNT(*) AS total FROM payments'))['total'];
?>
<h2>Dashboard</h2>
<div class="cards">
    <div class="card"><h3><?php echo $members; ?></h3><p>Total Members</p></div>
    <div class="card"><h3><?php echo $trainers; ?></h3><p>Total Trainers</p></div>
    <div class="card"><h3><?php echo $attendance; ?></h3><p>Attendance Records</p></div>
    <div class="card"><h3><?php echo $payments; ?></h3><p>Payments</p></div>
</div>
<div class="panel">
<h3>Project Modules</h3>
<p>Use the menu above to add members, trainers, attendance and payments.</p>
</div>
<?php require_once 'footer.php'; ?>
