<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); exit;
}
include("db.php");
include("header.php");

$user_id=(int)$_SESSION['user_id'];
$member=mysqli_fetch_assoc(mysqli_query($conn,"SELECT id FROM members WHERE user_id='$user_id' LIMIT 1"));
?>
<div class="card">
<h2>My Progress</h2>
<table>
<tr><th>Date</th><th>Weight</th><th>Height</th><th>Notes</th></tr>
<?php
if($member){
    $member_id=(int)$member['id'];
    $r=mysqli_query($conn,"SELECT * FROM progress WHERE member_id='$member_id' ORDER BY record_date DESC");
    while($row=mysqli_fetch_assoc($r)):
?>
<tr>
<td><?php echo $row['record_date']; ?></td>
<td><?php echo $row['weight']; ?> KG</td>
<td><?php echo $row['height']; ?> CM</td>
<td><?php echo htmlspecialchars($row['notes']); ?></td>
</tr>
<?php endwhile; } ?>
</table>
</div>
<?php include("footer.php"); ?>