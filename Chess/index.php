<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Chess Master - BCA Project</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<?php include("header.php"); ?>
<section class="hero">
  <div>
    <h1>CHESS MASTER</h1>
    <p>Chess Game Management System</p>
    <p class="muted">BCA Academic Project using PHP, MySQL, JavaScript and CSS</p>
    <a class="btn" href="chess.php">Start New Game</a>
  </div>
</section>
<main class="container">
  <h2>Project Features</h2>
  <div class="cards">
    <div class="card"><span>♟</span><h3>Play Chess</h3><p>Two-player chessboard with legal movement, captures and turn control.</p></div>
    <div class="card"><span>🏆</span><h3>Game Results</h3><p>Finished games can be saved to the MySQL database.</p></div>
    <div class="card"><span>📜</span><h3>History</h3><p>View saved matches, winners and dates.</p></div>
    <div class="card"><span>📖</span><h3>Instructions</h3><p>Learn the objective, pieces and basic chess rules.</p></div>
  </div>
</main>
<?php include("footer.php"); ?>
</body>
</html>