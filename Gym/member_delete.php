<?php
require_once 'db.php';
$id = intval($_GET['id']);
mysqli_query($conn, "DELETE FROM members WHERE id=$id");
header('Location: members.php');
exit;
?>
