<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}
require_once 'db.php';
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);
    $sql = "SELECT id, username FROM users WHERE username='$username' AND password='$password' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        header('Location: dashboard.php');
        exit;
    }
    $message = 'Invalid username or password.';
}
?>
<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>Gym Login</title><link rel="stylesheet" href="css/style.css"></head>
<body class="login-bg">
<div class="login-box">
    <h1>GYM MANAGEMENT</h1>
    <p class="sub">Dreamweaver 8 + PHP + MySQL</p>
    <?php if ($message != '') { ?><div class="error"><?php echo htmlspecialchars($message); ?></div><?php } ?>
    <form method="post">
        <label>Username</label>
        <input type="text" name="username" required>
        <label>Password</label>
        <input type="password" name="password" required>
        <button type="submit">Login</button>
    </form>
    <p class="hint">Demo login: admin / admin123</p>
</div>
</body>
</html>
