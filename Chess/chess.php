<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Play Chess - Chess Master</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<?php include("header.php"); ?>
<main class="game-page">
  <h1>♟ Play Chess</h1>
  <div class="player-row">
    <label>White Player
      <input type="text" id="whitePlayer" placeholder="White player name">
    </label>
    <label>Black Player
      <input type="text" id="blackPlayer" placeholder="Black player name">
    </label>
  </div>
  <div class="status">
    <strong>Turn:</strong> <span id="turnText">White</span>
    <span id="statusText">Enter player names and click Start Game.</span>
  </div>
  <div id="board" aria-label="Chess board"></div>
  <div class="controls">
    <button onclick="startGame()">Start / New Game</button>
    <button onclick="resetGame()">Reset</button>
    <button onclick="saveResult()">Save Result</button>
    <a class="btn secondary" href="index.php">Home</a>
  </div>
  <div id="promotion" class="promotion hidden">
    <p>Choose promotion:</p>
    <button onclick="promote('queen')">♕ Queen</button>
    <button onclick="promote('rook')">♖ Rook</button>
    <button onclick="promote('bishop')">♗ Bishop</button>
    <button onclick="promote('knight')">♘ Knight</button>
  </div>
</main>
<script src="script.js"></script>
</body>
</html>