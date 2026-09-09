<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php"); exit;
}
include("db.php");

if(isset($_POST['save'])){
    $member=(int)$_POST['member_id'];
    $meal=mysqli_real_escape_string($conn,trim($_POST['meal']));
    $food=mysqli_real_escape_string($conn,trim($_POST['food']));
    $calories=(int)$_POST['calories'];
    $notes=mysqli_real_escape_string($conn,trim($_POST['notes']));
    mysqli_query($conn,"INSERT INTO diet_plans(member_id,meal_time,food,calories,notes)
        VALUES('$member','$meal','$food','$calories','$notes')");
    header("Location: diet.php"); exit;
}
if(isset($_GET['delete'])){
    $id=(int)$_GET['delete'];
    mysqli_query($conn,"DELETE FROM diet_plans WHERE id='$id'");
    header("Location: diet.php"); exit;
}
include("header.php");
?>
<div class="card">
<h2>Create Diet Plan</h2>
<form method="post">
<select name="member_id" required>
<option value="">Select Member</option>
<?php $r=mysqli_query($conn,"SELECT id,name FROM members ORDER BY name");
while($row=mysqli_fetch_assoc($r)) echo "<option value='{$row['id']}'>".htmlspecialchars($row['name'])."</option>"; ?>
</select>
<input name="meal" placeholder="Breakfast / Lunch / Dinner" required>
<input name="food" placeholder="Food" required>
<input type="number" name="calories" placeholder="Calories">
<input name="notes" placeholder="Notes">
<button name="save">Save Diet</button>
</form>
</div>
<div class="card">
<h2>Diet Plans</h2>
<table>
<tr><th>Member</th><th>Meal</th><th>Food</th><th>Calories</th><th>Notes</th><th>Action</th></tr>
<?php
$r=mysqli_query($conn,"SELECT diet_plans.*,members.name AS member_name
    FROM diet_plans JOIN members ON diet_plans.member_id=members.id
    ORDER BY diet_plans.id DESC");
while($row=mysqli_fetch_assoc($r)):
?>
<tr>
<td><?php echo htmlspecialchars($row['member_name']); ?></td>
<td><?php echo htmlspecialchars($row['meal_time']); ?></td>
<td><?php echo htmlspecialchars($row['food']); ?></td>
<td><?php echo $row['calories']; ?></td>
<td><?php echo htmlspecialchars($row['notes']); ?></td>
<td><a href="diet.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Delete diet plan?')">Delete</a></td>
</tr>
<?php endwhile; ?>
</table>
</div>
<?php include("footer.php"); ?>