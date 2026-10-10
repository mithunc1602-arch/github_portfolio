<?php
require_once 'db.php';
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, trim($_POST['name']));
    $phone = mysqli_real_escape_string($conn, trim($_POST['phone']));
    $gender = mysqli_real_escape_string($conn, trim($_POST['gender']));
    $join_date = mysqli_real_escape_string($conn, $_POST['join_date']);
    $plan = mysqli_real_escape_string($conn, trim($_POST['plan']));
    mysqli_query($conn, "INSERT INTO members(name,phone,gender,join_date,plan) VALUES('$name','$phone','$gender','$join_date','$plan')");
    header('Location: members.php');
    exit;
}
require_once 'header.php';
?>
<h2>Add Member</h2>
<form method="post" class="form-box">
<label>Name</label><input type="text" name="name" required>
<label>Phone</label><input type="text" name="phone" required>
<label>Gender</label><select name="gender"><option>Male</option><option>Female</option><option>Other</option></select>
<label>Join Date</label><input type="date" name="join_date" value="<?php echo date('Y-m-d'); ?>" required>
<label>Plan</label><input type="text" name="plan" placeholder="Monthly" required>
<button type="submit">Save Member</button>
<a class="button secondary" href="members.php">Back</a>
</form>
<?php require_once 'footer.php'; ?>
