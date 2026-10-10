<?php
require_once 'db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $member_id = intval($_POST['member_id']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    mysqli_query($conn, "INSERT INTO attendance(member_id,date,status) VALUES($member_id,'$date','$status')");
    header('Location: attendance.php');
    exit;
}
require_once 'header.php';
$members = mysqli_query($conn, 'SELECT id,name FROM members ORDER BY name');
$records = mysqli_query($conn, 'SELECT a.id, m.name, a.date, a.status FROM attendance a LEFT JOIN members m ON a.member_id=m.id ORDER BY a.id DESC');
?>
<h2>Attendance</h2>
<form method="post" class="inline-form">
<select name="member_id" required><option value="">Select Member</option><?php while ($m = mysqli_fetch_assoc($members)) { ?><option value="<?php echo $m['id']; ?>"><?php echo htmlspecialchars($m['name']); ?></option><?php } ?></select>
<input type="date" name="date" value="<?php echo date('Y-m-d'); ?>" required>
<select name="status"><option>Present</option><option>Absent</option></select>
<button type="submit">Save Attendance</button>
</form>
<table><tr><th>ID</th><th>Member</th><th>Date</th><th>Status</th></tr>
<?php while ($row = mysqli_fetch_assoc($records)) { ?><tr><td><?php echo $row['id']; ?></td><td><?php echo htmlspecialchars($row['name']); ?></td><td><?php echo $row['date']; ?></td><td><?php echo $row['status']; ?></td></tr><?php } ?>
</table>
<?php require_once 'footer.php'; ?>
