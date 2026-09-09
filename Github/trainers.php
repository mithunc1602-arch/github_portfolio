<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php"); exit;
}
include("db.php");

if (isset($_POST['save'])) {
    $name = mysqli_real_escape_string($conn, trim($_POST['name']));
    $phone = mysqli_real_escape_string($conn, trim($_POST['phone']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $specialization = mysqli_real_escape_string($conn, trim($_POST['specialization']));
    mysqli_query($conn, "INSERT INTO trainers(name,phone,email,specialization)
        VALUES('$name','$phone','$email','$specialization')");
    header("Location: trainers.php"); exit;
}

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    mysqli_query($conn, "DELETE FROM trainers WHERE id='$id'");
    header("Location: trainers.php"); exit;
}

include("header.php");
?>
<div class="card">
<h2>Add Trainer</h2>
<form method="post">
<input name="name" placeholder="Trainer Name" required>
<input name="phone" placeholder="Phone">
<input type="email" name="email" placeholder="Email">
<input name="specialization" placeholder="Specialization">
<button name="save">Save Trainer</button>
</form>
</div>

<div class="card">
<h2>Trainers</h2>
<table>
<tr><th>ID</th><th>Name</th><th>Phone</th><th>Email</th><th>Specialization</th><th>Action</th></tr>
<?php
$r=mysqli_query($conn,"SELECT * FROM trainers ORDER BY id DESC");
while($row=mysqli_fetch_assoc($r)):
?>
<tr>
<td><?php echo $row['id']; ?></td>
<td><?php echo htmlspecialchars($row['name']); ?></td>
<td><?php echo htmlspecialchars($row['phone']); ?></td>
<td><?php echo htmlspecialchars($row['email']); ?></td>
<td><?php echo htmlspecialchars($row['specialization']); ?></td>
<td><a href="trainers.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Delete trainer?')">Delete</a></td>
</tr>
<?php endwhile; ?>
</table>
</div>
<?php include("footer.php"); ?>