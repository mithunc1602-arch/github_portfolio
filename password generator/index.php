<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Random Password Generator</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Random Password Generator</h1>
    <p class="subtitle">Generate a strong random password</p>
    <form action="generate.php" method="post">
        <label for="length">Password Length:</label>
        <input id="length" type="number" name="length" value="12" min="8" max="64" required>
        <div class="checkbox">
            <label><input type="checkbox" name="uppercase" value="1" checked> Uppercase Letters (A-Z)</label>
            <label><input type="checkbox" name="lowercase" value="1" checked> Lowercase Letters (a-z)</label>
            <label><input type="checkbox" name="numbers" value="1" checked> Numbers (0-9)</label>
            <label><input type="checkbox" name="symbols" value="1" checked> Special Characters</label>
        </div>
        <button type="submit">Generate Password</button>
    </form>
    <p><a class="history" href="history.php">View Password History</a></p>
</div>
</body>
</html>