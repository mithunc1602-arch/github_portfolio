<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php"); exit;
}
include("db.php");

if(isset($_POST['save'])){
    $member=(int)$_POST['member_id'];
    $date=$_POST['record_date'];
    $weight=(float)$_POST['weight'];
    $height=(float)$_POST['height'];
    $notes=mysqli_real_escape_string($conn,trim($_POST['notes']));
    mysqli_query($conn,"INSERT INTO progress(member_id,record_date,weight,height,notes)
        VALUES('$member','$date','$weight','$height','$notes')");
    header("Location: progress.php"); exit;
}
include("header.php");
?>
<div class="card">
<h2>Add Member Progress</h2>
<form method="post">
<select name="member_id" required>
<option value="">Select Member</option>
<?php $r=mysqli_query($conn,"SELECT id,name FROM members ORDER BY name");
while($row=mysqli_fetch_assoc($r)) echo "<option value='{$row['id']}'>".htmlspecialchars($row['name'])."</option>"; ?>
</select>
<input type="date" name="record_date" value="<?php echo date('Y-m-d'); ?>" required>
<input type="number" step="0.1" name="weight" placeholder="Weight (KG)" required>
<input type="number" step="0.1" name="height" placeholder="Height (CM)" required>
<input name="notes" placeholder="Notes">
<button name="save">Save Progress</button>
</form>
</div>
<div class="card">
<h2>Progress Records</h2>
<table>
<tr><th>Member</th><th>Date</th><th>Weight</th><th>Height</th><th>Notes</th></tr>
<?php
$r=mysqli_query($conn,"SELECT progress.*,members.name AS member_name
    FROM progress JOIN members ON progress.member_id=members.id
    ORDER BY progress.record_date DESC, progress.id DESC");
while($row=mysqli_fetch_assoc($r)):
?>
<tr>
<td><?php echo htmlspecialchars($row['member_name']); ?></td>
<td><?php echo $row['record_date']; ?></td>
<td><?php echo $row['weight']; ?> KG</td>
<td><?php echo $row['height']; ?> CM</td>
<td><?php echo htmlspecialchars($row['notes']); ?></td>
</tr>
<?php endwhile; ?>
</table>
</div>
<?php include("footer.php"); ?>