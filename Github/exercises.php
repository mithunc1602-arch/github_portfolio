<?php
session_start();

if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

include("db.php");

/* ADD EXERCISE */
if (isset($_POST['save'])) {

    $name = mysqli_real_escape_string($conn, trim($_POST['name']));
    $muscle = mysqli_real_escape_string($conn, trim($_POST['muscle']));
    $description = mysqli_real_escape_string($conn, trim($_POST['description']));

    if ($name != "") {

        $sql = "INSERT INTO exercises
                (exercise_name, muscle_group, description)
                VALUES
                ('$name', '$muscle', '$description')";

        if (mysqli_query($conn, $sql)) {
            header("Location: exercises.php");
            exit;
        } else {
            $error = "Error adding exercise: " . mysqli_error($conn);
        }
    }
}

/* DELETE EXERCISE */
if (isset($_GET['delete'])) {

    $id = (int) $_GET['delete'];

    $sql = "DELETE FROM exercises WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        header("Location: exercises.php");
        exit;
    } else {
        $error = "Error deleting exercise: " . mysqli_error($conn);
    }
}

include("header.php");
?>

<div class="card">

    <h2>Add Exercise</h2>

    <?php
    if (isset($error)) {
        echo "<p style='color:red;'>" . htmlspecialchars($error) . "</p>";
    }
    ?>

    <form method="post" action="exercises.php">

        <p>
            <label>Exercise Name</label><br>
            <input type="text" name="name"
                   placeholder="Exercise Name"
                   required>
        </p>

        <p>
            <label>Muscle Group</label><br>
            <input type="text" name="muscle"
                   placeholder="Muscle Group">
        </p>

        <p>
            <label>Description</label><br>
            <textarea name="description"
                      placeholder="Description"
                      rows="5"></textarea>
        </p>

        <button type="submit" name="save">
            Save Exercise
        </button>

    </form>

</div>


<div class="card">

    <h2>Exercises</h2>

    <table width="100%" border="1" cellpadding="8" cellspacing="0">

        <tr>
            <th>ID</th>
            <th>Exercise</th>
            <th>Muscle</th>
            <th>Description</th>
            <th>Action</th>
        </tr>

        <?php

        $sql = "SELECT * FROM exercises ORDER BY id DESC";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {

            while ($row = mysqli_fetch_assoc($result)) {
        ?>

        <tr>

            <td>
                <?php echo (int)$row['id']; ?>
            </td>

            <td>
                <?php
                echo htmlspecialchars($row['exercise_name']);
                ?>
            </td>

            <td>
                <?php
                echo htmlspecialchars($row['muscle_group']);
                ?>
            </td>

            <td>
                <?php
                echo htmlspecialchars($row['description']);
                ?>
            </td>

            <td>
                <a href="exercises.php?delete=<?php echo (int)$row['id']; ?>"
                   onclick="return confirm('Are you sure you want to delete this exercise?');">
                    Delete
                </a>
            </td>

        </tr>

        <?php
            }

        } else {
        ?>

        <tr>
            <td colspan="5" align="center">
                No exercises found.
            </td>
        </tr>

        <?php
        }
        ?>

    </table>

</div>

<?php
include("footer.php");
?>
```
