<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php"); exit;
}
include("db.php");

if(isset($_POST['save'])){
    $member=(int)$_POST['member_id'];
    $date=$_POST['date'];
    $status=$_POST['status'];
    mysqli_query($conn,"INSERT INTO attendance(member_id,attendance_date,status)
        VALUES('$member','$date','$status')");
    header("Location: attendance.php"); exit;
}
include("header.php");
?>
<div class="card">
<h2>Member Attendance</h2>
<form method="post">
<select name="member_id" required>
<option value="">Select Member</option>
<?php $r=mysqli_query($conn,"SELECT id,name FROM members ORDER BY name");
while($row=mysqli_fetch_assoc($r)) echo "<option value='{$row['id']}'>".htmlspecialchars($row['name'])."</option>"; ?>
</select>
<input type="date" name="date" value="<?php echo date('Y-m-d'); ?>" required>
<select name="status">
<option value="Present">Present</option>
<option value="Absent">Absent</option>
</select>
<button name="save">Save Attendance</button>
</form>
</div>
<div class="card">
<h2>Attendance History</h2>
<table>
<tr><th>Member</th><th>Date</th><th>Status</th></tr>
<?php
$r=mysqli_query($conn,"SELECT attendance.*,members.name AS member_name
    FROM attendance JOIN members ON attendance.member_id=members.id
    ORDER BY attendance.attendance_date DESC, attendance.id DESC");
while($row=mysqli_fetch_assoc($r)):
?>
<tr>
<td><?php echo htmlspecialchars($row['member_name']); ?></td>
<td><?php echo $row['attendance_date']; ?></td>
<td><?php echo htmlspecialchars($row['status']); ?></td>
</tr>
<?php endwhile; ?>
</table>
</div>
<?php include("footer.php"); ?>