<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php"); exit;
}
include("db.php");

if(isset($_POST['save'])){
    $member=(int)$_POST['member_id'];
    $exercise=(int)$_POST['exercise_id'];
    $sets=(int)$_POST['sets_count'];
    $reps=(int)$_POST['reps'];
    $date=$_POST['workout_date'];
    mysqli_query($conn,"INSERT INTO workouts(member_id,exercise_id,sets_count,reps,workout_date)
        VALUES('$member','$exercise','$sets','$reps','$date')");
    header("Location: workouts.php"); exit;
}
if(isset($_GET['delete'])){
    $id=(int)$_GET['delete'];
    mysqli_query($conn,"DELETE FROM workouts WHERE id='$id'");
    header("Location: workouts.php"); exit;
}
include("header.php");
?>
<div class="card">
<h2>Assign Workout</h2>
<form method="post">
<select name="member_id" required>
<option value="">Select Member</option>
<?php $r=mysqli_query($conn,"SELECT id,name FROM members ORDER BY name");
while($row=mysqli_fetch_assoc($r)) echo "<option value='{$row['id']}'>".htmlspecialchars($row['name'])."</option>"; ?>
</select>
<select name="exercise_id" required>
<option value="">Select Exercise</option>
<?php $r=mysqli_query($conn,"SELECT id,exercise_name FROM exercises ORDER BY exercise_name");
while($row=mysqli_fetch_assoc($r)) echo "<option value='{$row['id']}'>".htmlspecialchars($row['exercise_name'])."</option>"; ?>
</select>
<input type="number" name="sets_count" placeholder="Sets" required>
<input type="number" name="reps" placeholder="Reps" required>
<input type="date" name="workout_date" value="<?php echo date('Y-m-d'); ?>" required>
<button name="save">Assign Workout</button>
</form>
</div>
<div class="card">
<h2>Workout List</h2>
<table>
<tr><th>Member</th><th>Exercise</th><th>Sets</th><th>Reps</th><th>Date</th><th>Action</th></tr>
<?php
$sql="SELECT workouts.*,members.name AS member_name,exercises.exercise_name
      FROM workouts
      JOIN members ON workouts.member_id=members.id
      JOIN exercises ON workouts.exercise_id=exercises.id
      ORDER BY workouts.id DESC";
$r=mysqli_query($conn,$sql);
while($row=mysqli_fetch_assoc($r)):
?>
<tr>
<td><?php echo htmlspecialchars($row['member_name']); ?></td>
<td><?php echo htmlspecialchars($row['exercise_name']); ?></td>
<td><?php echo $row['sets_count']; ?></td>
<td><?php echo $row['reps']; ?></td>
<td><?php echo $row['workout_date']; ?></td>
<td><a href="workouts.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Delete workout?')">Delete</a></td>
</tr>
<?php endwhile; ?>
</table>
</div>
<?php include("footer.php"); ?>