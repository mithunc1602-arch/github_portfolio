CHESS GAME MANAGEMENT SYSTEM - BCA PROJECT

INSTALLATION
1. Install XAMPP and start Apache + MySQL.
2. Copy this folder to C:\xampp\htdocs\chess_game\
3. Open HeidiSQL and run database.sql.
4. If MySQL uses port 3308, edit db.php:
   mysqli_connect("localhost","root","","chess_game",3308);
5. Open:
   http://localhost/chess_game/

PAGES
index.php          Homepage
chess.php          Chess game
instructions.php   Rules/instructions
history.php        Saved game history
about.php          Project details
db.php             Database connection
save_game.php      Saves results
style.css          Design
script.js          Chess logic

DREAMWEAVER 8
Open the chess_game folder as a site/project and edit PHP, CSS and JavaScript files normally.

HEIDISQL
Database: chess_game
Table: games
Fields: id, white_player, black_player, winner, result, played_at

NOTE
This is an academic project implementation. It includes legal movement, check/checkmate, castling, en-passant and promotion, but it is intended for educational use rather than tournament certification.
