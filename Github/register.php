<?php
session_start();
include("db.php");

$message = "";

if (isset($_POST['register'])) {
    $name = mysqli_real_escape_string($conn, trim($_POST['name']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $phone = mysqli_real_escape_string($conn, trim($_POST['phone']));
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $password = $_POST['password'];

    if (strlen($password) < 6) {
        $message = "Password must contain at least 6 characters.";
    } else {
        $check = mysqli_query($conn, "SELECT id FROM users WHERE email='$email' LIMIT 1");

        if (mysqli_num_rows($check) > 0) {
            $message = "Email already registered.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);

            mysqli_begin_transaction($conn);

            try {
                $sql = "INSERT INTO users (name,email,password,role)
                        VALUES ('$name','$email','$hash','member')";
                if (!mysqli_query($conn, $sql)) {
                    throw new Exception(mysqli_error($conn));
                }

                $user_id = mysqli_insert_id($conn);

                $sql = "INSERT INTO members (user_id,name,phone,email,gender,join_date,status)
                        VALUES ('$user_id','$name','$phone','$email','$gender',CURDATE(),'Active')";
                if (!mysqli_query($conn, $sql)) {
                    throw new Exception(mysqli_error($conn));
                }

                mysqli_commit($conn);
                $message = "Registration successful. You can now login.";
            } catch (Exception $e) {
                mysqli_rollback($conn);
                $message = "Registration failed: " . $e->getMessage();
            }
        }
    }
}

include("header.php");
?>

<div class="card">
    <h2>Member Registration</h2>

    <?php if ($message): ?>
        <div class="message"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <form method="post">
        <label>Name</label>
        <input type="text" name="name" required>

        <label>Email</label>
        <input type="email" name="email" required>

        <label>Phone</label>
        <input type="text" name="phone">

        <label>Gender</label>
        <select name="gender">
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
        </select>

        <label>Password</label>
        <input type="password" name="password" minlength="6" required>

        <button type="submit" name="register">Register</button>
    </form>
</div>

<?php include("footer.php"); ?>