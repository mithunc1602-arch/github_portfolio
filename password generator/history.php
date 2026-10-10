<?php
require_once "db.php";
$result = mysqli_query($conn, "SELECT id, password_text, password_length, created_at FROM passwords ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Password History</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container history-container">
    <h1>Password History</h1>
<form action="save_password.php" method="POST">
    <input type="hidden"
           name="password_text"
           id="password_text">

    <button type="submit">Save to History</button>
</form>	
    <?php if (isset($_GET["saved"])): ?><p class="success">Password saved successfully.</p><?php endif; ?>
    <p><a class="link" href="index.php">Generate New Password</a></p>
    <div class="table-wrap">
    <table>
        <tr><th>ID</th><th>Password</th><th>Length</th><th>Date</th><th>Action</th></tr>
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo (int)$row["id"]; ?></td>
                <td class="password-cell"><?php echo htmlspecialchars($row["password_text"], ENT_QUOTES, "UTF-8"); ?></td>
                <td><?php echo (int)$row["password_length"]; ?></td>
                <td><?php echo htmlspecialchars($row["created_at"], ENT_QUOTES, "UTF-8"); ?></td>
                <td><a class="delete" href="delete.php?id=<?php echo (int)$row["id"]; ?>" onClick="return confirm('Delete this saved password?');">Delete</a></td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="5">No passwords found.</td></tr>
        <?php endif; ?>
		
    </table>
    </div>
</div>
</body>
</html>