<?php
include("db.php");
$result = mysqli_query($conn, "SELECT * FROM games ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Game History</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<?php include("header.php"); ?>
<main class="info-page">
<h1>📜 Game History</h1>
<?php if(isset($_GET["saved"])) echo '<div class="success">Game result saved successfully.</div>'; ?>
<table>
<tr><th>ID</th><th>White</th><th>Black</th><th>Winner</th><th>Result</th><th>Date</th></tr>
<?php if(mysqli_num_rows($result)): while($row=mysqli_fetch_assoc($result)): ?>
<tr>
<td><?php echo $row["id"]; ?></td>
<td><?php echo htmlspecialchars($row["white_player"]); ?></td>
<td><?php echo htmlspecialchars($row["black_player"]); ?></td>
<td><?php echo htmlspecialchars($row["winner"]); ?></td>
<td><?php echo htmlspecialchars($row["result"]); ?></td>
<td><?php echo $row["played_at"]; ?></td>
</tr>
<?php endwhile; else: ?>
<tr><td colspan="6">No games recorded yet.</td></tr>
<?php endif; ?>
</table>
</main>
<?php include("footer.php"); ?>
</body>
</html>