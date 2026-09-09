<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php"); exit;
}
include("db.php");

if (isset($_POST['save'])) {
    $name=mysqli_real_escape_string($conn,trim($_POST['plan_name']));
    $duration=(int)$_POST['duration'];
    $price=(float)$_POST['price'];
    mysqli_query($conn,"INSERT INTO membership_plans(plan_name,duration,price)
        VALUES('$name','$duration','$price')");
    header("Location: plans.php"); exit;
}
if(isset($_GET['delete'])){
    $id=(int)$_GET['delete'];
    mysqli_query($conn,"DELETE FROM membership_plans WHERE id='$id'");
    header("Location: plans.php"); exit;
}
include("header.php");
?>
<div class="card">
<h2>Add Membership Plan</h2>
<form method="post">
<input name="plan_name" placeholder="Plan Name" required>
<input type="number" name="duration" placeholder="Duration in days" required>
<input type="number" step="0.01" name="price" placeholder="Price" required>
<button name="save">Save Plan</button>
</form>
</div>
<div class="card">
<h2>Plans</h2>
<table>
<tr><th>ID</th><th>Plan</th><th>Duration</th><th>Price</th><th>Action</th></tr>
<?php $r=mysqli_query($conn,"SELECT * FROM membership_plans ORDER BY id DESC");
while($row=mysqli_fetch_assoc($r)): ?>
<tr>
<td><?php echo $row['id']; ?></td>
<td><?php echo htmlspecialchars($row['plan_name']); ?></td>
<td><?php echo $row['duration']; ?> days</td>
<td>₹<?php echo number_format($row['price'],2); ?></td>
<td><a href="plans.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Delete plan?')">Delete</a></td>
</tr>
<?php endwhile; ?>
</table>
</div>
<?php include"footer.php"; 
?>