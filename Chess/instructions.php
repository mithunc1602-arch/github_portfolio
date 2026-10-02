<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>Instructions</title><link rel="stylesheet" href="style.css"></head>
<body>
<?php include("header.php"); ?>
<main class="info-page">
<h1>📖 Chess Instructions</h1>
<h2>Objective</h2>
<p>Checkmate the opponent's king. White moves first and players alternate turns.</p>
<h2>Pieces</h2>
<ul>
<li><b>King:</b> one square in any direction.</li>
<li><b>Queen:</b> any number of squares horizontally, vertically or diagonally.</li>
<li><b>Rook:</b> horizontally or vertically.</li>
<li><b>Bishop:</b> diagonally.</li>
<li><b>Knight:</b> in an L-shaped move.</li>
<li><b>Pawn:</b> forward movement and diagonal captures; it may move two squares from its starting rank.</li>
</ul>
<h2>Game Controls</h2>
<ol>
<li>Enter both player names.</li>
<li>Click Start / New Game.</li>
<li>Click a piece, then click a legal destination square.</li>
<li>Captured pieces are removed from the board.</li>
<li>When the game ends, use Save Result to store the result in MySQL.</li>
</ol>
<h2>Supported Rules</h2>
<p>This project includes basic legal movement, captures, check/checkmate, stalemate, castling, en-passant and pawn promotion.</p>
</main>
<?php include("footer.php"); ?>
</body>
</html>