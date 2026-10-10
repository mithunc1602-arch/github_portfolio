<?php
require_once 'db.php';
$id = intval($_GET['id']);
$res = mysqli_query($conn, "SELECT * FROM members WHERE id=$id");
$member = mysqli_fetch_assoc($res);
if (!$member) { die('Member not found.'); }
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, trim($_POST['name']));
    $phone = mysqli_real_escape_string($conn, trim($_POST['phone']));
    $gender = mysqli_real_escape_string($conn, trim($_POST['gender']));
    $join_date = mysqli_real_escape_string($conn, $_POST['join_date']);
    $plan = mysqli_real_escape_string($conn, trim($_POST['plan']));
    mysqli_query($conn, "UPDATE members SET name='$name', phone='$phone', gender='$gender', join_date='$join_date', plan='$plan' WHERE id=$id");
    header('Location: members.php');
    exit;
}
require_once 'header.php';
?>
<h2>Edit Member</h2>
<form method="post" class="form-box">
<label>Name</label><input type="text" name="name" value="<?php echo htmlspecialchars($member['name']); ?>" required>
<label>Phone</label><input type="text" name="phone" value="<?php echo htmlspecialchars($member['phone']); ?>" required>
<label>Gender</label><select name="gender"><option <?php if($member['gender']=='Male') echo 'selected'; ?>>Male</option><option <?php if($member['gender']=='Female') echo 'selected'; ?>>Female</option><option <?php if($member['gender']=='Other') echo 'selected'; ?>>Other</option></select>
<label>Join Date</label><input type="date" name="join_date" value="<?php echo htmlspecialchars($member['join_date']); ?>" required>
<label>Plan</label><input type="text" name="plan" value="<?php echo htmlspecialchars($member['plan']); ?>" required>
<button type="submit">Update Member</button>
<a class="button secondary" href="members.php">Back</a>
</form>
<?php require_once 'footer.php'; ?>
