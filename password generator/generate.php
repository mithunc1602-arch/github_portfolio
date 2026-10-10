<?php
session_start();

$generated_password = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $length = filter_input(INPUT_POST, "length", FILTER_VALIDATE_INT);
    if ($length === false || $length === null) {
        $length = 12;
    }
    $length = max(8, min(64, $length));

    $sets = [];
    if (isset($_POST["uppercase"])) $sets[] = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    if (isset($_POST["lowercase"])) $sets[] = "abcdefghijklmnopqrstuvwxyz";
    if (isset($_POST["numbers"])) $sets[] = "0123456789";
    if (isset($_POST["symbols"])) $sets[] = "!@#$%&*()-_=+[]{}?";

    if (!$sets) {
        $error = "Select at least one character type.";
    } else {
        $all = implode("", $sets);
        // Include at least one character from each selected set.
        foreach ($sets as $set) {
            $generated_password .= $set[random_int(0, strlen($set) - 1)];
        }
        while (strlen($generated_password) < $length) {
            $generated_password .= $all[random_int(0, strlen($all) - 1)];
        }
        $generated_password = substr(str_shuffle($generated_password), 0, $length);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Generated Password</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Password Generator</h1>
    <?php if ($error !== ""): ?>
        <p class="error"><?php echo htmlspecialchars($error, ENT_QUOTES, "UTF-8"); ?></p>
        <p><a href="index.php">Back</a></p>
    <?php elseif ($generated_password !== ""): ?>
        <p>Your generated password:</p>
        <input class="generated" type="text" id="generatedPassword" readonly
               value="<?php echo htmlspecialchars($generated_password, ENT_QUOTES, "UTF-8"); ?>">
        <button type="button" onClick="copyPassword()">Copy Password</button>
        <form method="post" action="save_password.php">
            <input type="hidden" name="password_text" value="<?php echo htmlspecialchars($generated_password, ENT_QUOTES, "UTF-8"); ?>">
            <input type="hidden" name="password_length" value="<?php echo strlen($generated_password); ?>">
            <button type="submit">Save to History</button>
        </form>
    <?php else: ?>
        <p>No password generated yet.</p>
    <?php endif; ?>
    <p><a href="index.php">Generate Another</a> | <a href="history.php">View History</a></p>
</div>
<script>
function copyPassword() {
    const field = document.getElementById("generatedPassword");
    field.select();
    field.setSelectionRange(0, 9999);
    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(field.value).then(() => alert("Password copied."));
    } else {
        document.execCommand("copy");
        alert("Password copied.");
    }
}
</script>
</body>
</html>