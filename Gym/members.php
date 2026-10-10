<?php
require_once 'db.php';
require_once 'header.php';
$result = mysqli_query($conn, 'SELECT * FROM members ORDER BY id DESC');
?>
<div class="title-row"><h2>Members</h2><a class="button" href="member_add.php">+ Add Member</a></div>
<table>
<tr><th>ID</th><th>Name</th><th>Phone</th><th>Gender</th><th>Join Date</th><th>Plan</th><th>Action</th></tr>
<?php while ($row = mysqli_fetch_assoc($result)) { ?>
<tr>
<td><?php echo $row['id']; ?></td>
<td><?php echo htmlspecialchars($row['name']); ?></td>
<td><?php echo htmlspecialchars($row['phone']); ?></td>
<td><?php echo htmlspecialchars($row['gender']); ?></td>
<td><?php echo htmlspecialchars($row['join_date']); ?></td>
<td><?php echo htmlspecialchars($row['plan']); ?></td>
<td><a href="member_edit.php?id=<?php echo $row['id']; ?>">Edit</a> | <a href="member_delete.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Delete this member?');">Delete</a></td>
</tr>
<?php } ?>
</table>
<?php require_once 'footer.php'; ?>
