<?php
require_once 'db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $member_id = intval($_POST['member_id']);
    $amount = floatval($_POST['amount']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    mysqli_query($conn, "INSERT INTO payments(member_id,amount,date) VALUES($member_id,$amount,'$date')");
    header('Location: payments.php');
    exit;
}
require_once 'header.php';
$members = mysqli_query($conn, 'SELECT id,name FROM members ORDER BY name');
$records = mysqli_query($conn, 'SELECT p.id, m.name, p.amount, p.date FROM payments p LEFT JOIN members m ON p.member_id=m.id ORDER BY p.id DESC');
?>
<h2>Payments</h2>
<form method="post" class="inline-form">
<select name="member_id" required><option value="">Select Member</option><?php while ($m = mysqli_fetch_assoc($members)) { ?><option value="<?php echo $m['id']; ?>"><?php echo htmlspecialchars($m['name']); ?></option><?php } ?></select>
<input type="number" step="0.01" name="amount" placeholder="Amount" required>
<input type="date" name="date" value="<?php echo date('Y-m-d'); ?>" required>
<button type="submit">Save Payment</button>
</form>
<table><tr><th>ID</th><th>Member</th><th>Amount</th><th>Date</th></tr>
<?php while ($row = mysqli_fetch_assoc($records)) { ?><tr><td><?php echo $row['id']; ?></td><td><?php echo htmlspecialchars($row['name']); ?></td><td>₹ <?php echo number_format($row['amount'],2); ?></td><td><?php echo $row['date']; ?></td></tr><?php } ?>
</table>
<?php require_once 'footer.php'; ?>
