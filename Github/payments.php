<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php"); exit;
}
include("db.php");

if(isset($_POST['save'])){
    $member=(int)$_POST['member_id'];
    $amount=(float)$_POST['amount'];
    $date=$_POST['payment_date'];
    $method=mysqli_real_escape_string($conn,trim($_POST['payment_method']));
    mysqli_query($conn,"INSERT INTO payments(member_id,amount,payment_date,payment_method)
        VALUES('$member','$amount','$date','$method')");
    header("Location: payments.php"); exit;
}
if(isset($_GET['delete'])){
    $id=(int)$_GET['delete'];
    mysqli_query($conn,"DELETE FROM payments WHERE id='$id'");
    header("Location: payments.php"); exit;
}
include("header.php");
?>
<div class="card">
<h2>Add Payment</h2>
<form method="post">
<select name="member_id" required>
<option value="">Select Member</option>
<?php $r=mysqli_query($conn,"SELECT id,name FROM members ORDER BY name");
while($row=mysqli_fetch_assoc($r)) echo "<option value='{$row['id']}'>".htmlspecialchars($row['name'])."</option>"; ?>
</select>
<input type="number" step="0.01" name="amount" placeholder="Amount" required>
<input type="date" name="payment_date" value="<?php echo date('Y-m-d'); ?>" required>
<select name="payment_method">
<option>Cash</option>
<option>UPI</option>
<option>Card</option>
<option>Bank Transfer</option>
</select>
<button name="save">Save Payment</button>
</form>
</div>
<div class="card">
<h2>Payments</h2>
<table>
<tr><th>Member</th><th>Amount</th><th>Date</th><th>Method</th><th>Action</th></tr>
<?php
$r=mysqli_query($conn,"SELECT payments.*,members.name AS member_name
    FROM payments LEFT JOIN members ON payments.member_id=members.id
    ORDER BY payments.id DESC");
while($row=mysqli_fetch_assoc($r)):
?>
<tr>
<td><?php echo htmlspecialchars($row['member_name'] ?? ''); ?></td>
<td>₹<?php echo number_format($row['amount'],2); ?></td>
<td><?php echo $row['payment_date']; ?></td>
<td><?php echo htmlspecialchars($row['payment_method']); ?></td>
<td><a href="payments.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Delete payment?')">Delete</a></td>
</tr>
<?php endwhile; ?>
</table>
</div>
<?php include("footer.php"); ?>