<?php
require_once 'db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, trim($_POST['name']));
    $phone = mysqli_real_escape_string($conn, trim($_POST['phone']));
    $specialization = mysqli_real_escape_string($conn, trim($_POST['specialization']));
    mysqli_query($conn, "INSERT INTO trainers(name,phone,specialization) VALUES('$name','$phone','$specialization')");
    header('Location: trainers.php');
    exit;
}
require_once 'header.php';
$result = mysqli_query($conn, 'SELECT * FROM trainers ORDER BY id DESC');
?>
<h2>Trainers</h2>
<form method="post" class="inline-form">
<input type="text" name="name" placeholder="Trainer name" required>
<input type="text" name="phone" placeholder="Phone" required>
<input type="text" name="specialization" placeholder="Specialization" required>
<button type="submit">Add Trainer</button>
</form>
<table>
<tr><th>ID</th><th>Name</th><th>Phone</th><th>Specialization</th></tr>
<?php while ($row = mysqli_fetch_assoc($result)) { ?>
<tr><td><?php echo $row['id']; ?></td><td><?php echo htmlspecialchars($row['name']); ?></td><td><?php echo htmlspecialchars($row['phone']); ?></td><td><?php echo htmlspecialchars($row['specialization']); ?></td></tr>
<?php } ?>
</table>
<?php require_once 'footer.php'; ?>
