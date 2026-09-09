<?php
session_start();

/* Check login */
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

/* Database connection */
include("db.php");

/* Header */
include("header.php");

/* Logged-in user ID */
$user_id = (int)$_SESSION['user_id'];

/* Get member details */
$sql_member = "SELECT * FROM members WHERE user_id = $user_id LIMIT 1";
$result_member = mysqli_query($conn, $sql_member);

$member = mysqli_fetch_assoc($result_member);
?>

<div class="card">

    <h2>My Profile</h2>

    <?php if ($member) { ?>

    <table width="500" border="1" align="center" cellpadding="8" cellspacing="0">

        <tr>
            <td><strong>User ID</strong></td>
            <td><?php echo htmlspecialchars($member['user_id']); ?></td>
        </tr>

        <tr>
            <td><strong>Name</strong></td>
            <td><?php echo htmlspecialchars($member['name']); ?></td>
        </tr>

        <tr>
            <td><strong>Gender</strong></td>
            <td><?php echo htmlspecialchars($member['gender']); ?></td>
        </tr>

        <tr>
            <td><strong>Email</strong></td>
            <td><?php echo htmlspecialchars($member['email']); ?></td>
        </tr>

        <tr>
            <td><strong>Phone</strong></td>
            <td><?php echo htmlspecialchars($member['phone']); ?></td>
        </tr>

        <tr>
            <td><strong>Trainer ID</strong></td>
            <td><?php echo htmlspecialchars($member['trainer_id']); ?></td>
        </tr>

        <tr>
            <td><strong>Plan ID</strong></td>
            <td><?php echo htmlspecialchars($member['plan_id']); ?></td>
        </tr>

        <tr>
            <td><strong>Join Date</strong></td>
            <td><?php echo htmlspecialchars($member['join_date']); ?></td>
        </tr>

        <tr>
            <td><strong>Status</strong></td>
            <td><?php echo htmlspecialchars($member['status']); ?></td>
        </tr>

    </table>

    <?php } else { ?>

        <p style="text-align:center;">
            Member details not found.
        </p>

    <?php } ?>


    <h2>My Workouts</h2>

    <table width="956" border="1" align="center" cellpadding="8" cellspacing="0">

        <tr>
            <th>Exercise</th>
            <th>Sets</th>
            <th>Reps</th>
            <th>Date</th>
        </tr>

        <?php

        if ($member) {

            $member_id = (int)$member['id'];

            $sql_workouts = "
                SELECT workouts.*, exercises.exercise_name
                FROM workouts
                JOIN exercises
                    ON workouts.exercise_id = exercises.id
                WHERE workouts.member_id = $member_id
                ORDER BY workouts.workout_date DESC
            ";

            $result_workouts = mysqli_query($conn, $sql_workouts);

            if ($result_workouts && mysqli_num_rows($result_workouts) > 0) {

                while ($row = mysqli_fetch_assoc($result_workouts)) {

        ?>

        <tr>
            <td>
                <?php echo htmlspecialchars($row['exercise_name']); ?>
            </td>

            <td>
                <?php echo htmlspecialchars($row['sets_count']); ?>
            </td>

            <td>
                <?php echo htmlspecialchars($row['reps']); ?>
            </td>

            <td>
                <?php echo htmlspecialchars($row['workout_date']); ?>
            </td>
        </tr>

        <?php
                }

            } else {
        ?>

        <tr>
            <td colspan="4" align="center">
                No workouts found.
            </td>
        </tr>

        <?php
            }
        }
        ?>

    </table>

</div>

<?php
/* Footer */
include("footer.php");
?>
```
