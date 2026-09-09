<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

include("db.php");

$message = "";

if (isset($_POST['save'])) {
    $name = mysqli_real_escape_string($conn, trim($_POST['name']));
    $phone = mysqli_real_escape_string($conn, trim($_POST['phone']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $trainer = (int)$_POST['trainer_id'];
    $plan = (int)$_POST['plan_id'];
    $join_date = $_POST['join_date'];

    $sql = "INSERT INTO members
            (name,phone,email,gender,trainer_id,plan_id,join_date,status)
            VALUES
            ('$name','$phone','$email','$gender','$trainer','$plan','$join_date','Active')";

    if (mysqli_query($conn, $sql)) {
        $message = "Member added successfully.";
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    mysqli_query($conn, "DELETE FROM members WHERE id='$id'");
    header("Location: members.php");
    exit;
}

include("header.php");
?>

<div class="card">
    <h2>Add Member</h2>

    <?php if ($message): ?><div class="message"><?php echo htmlspecialchars($message); ?></div><?php endif; ?>

    <form method="post">
        <input name="name" placeholder="Member Name" required>
        <input name="phone" placeholder="Phone">
        <input type="email" name="email" placeholder="Email">
        <select name="gender">
          <option value="Male">Male</option>
          <option value="Female">Female</option>
          <option value="Other">Other</option>
        </select>
        <select name="trainer_id">
            <option value="0">Select Trainer</option>
            <?php
            $result = mysqli_query($conn, "SELECT id,name FROM trainers ORDER BY name");
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='{$row['id']}'>" . htmlspecialchars($row['name']) . "</option>";
            }
            ?>
        </select>

        <select name="plan_id">
            <option value="0">Select Plan</option>
            <?php
            $result = mysqli_query($conn, "SELECT id,plan_name FROM membership_plans ORDER BY plan_name");
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='{$row['id']}'>" . htmlspecialchars($row['plan_name']) . "</option>";
            }
            ?>
        </select>

        <input type="date" name="join_date" value="<?php echo date('Y-m-d'); ?>" required>
        <button type="submit" name="save">Save Member</button>
    </form>
</div>

<div class="card">
    <h2>Members List</h2>
    <table>
        <tr><th>ID</th><th>Name</th><th>Phone</th><th>Email</th><th>Action</th></tr>
        <?php
        $result = mysqli_query($conn, "SELECT * FROM members ORDER BY id DESC");
        while ($row = mysqli_fetch_assoc($result)):
        ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo htmlspecialchars($row['name']); ?></td>
            <td><?php echo htmlspecialchars($row['phone']); ?></td>
            <td><?php echo htmlspecialchars($row['email']); ?></td>
            <td>
                <a href="members.php?delete=<?php echo $row['id']; ?>"
                   onclick="return confirm('Delete member?')">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

<?php include("footer.php"); ?>