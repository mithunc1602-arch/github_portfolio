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
<h2>My Diet Plan</h2>
<table>
<tr><th>Meal</th><th>Food</th><th>Calories</th><th>Notes</th></tr>
<?php
if($member){
    $member_id=(int)$member['id'];
    $r=mysqli_query($conn,"SELECT * FROM diet_plans WHERE member_id='$member_id' ORDER BY id DESC");
    while($row=mysqli_fetch_assoc($r)):
?>
<tr>
<td><?php echo htmlspecialchars($row['meal_time']); ?></td>
<td><?php echo htmlspecialchars($row['food']); ?></td>
<td><?php echo $row['calories']; ?></td>
<td><?php echo htmlspecialchars($row['notes']); ?></td>
</tr>
<?php endwhile; } ?>
</table>
</div>
<?php include("footer.php"); ?>