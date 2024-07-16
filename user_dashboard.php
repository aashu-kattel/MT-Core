<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

$email = $_SESSION['email'];

// Fetch user_id from the database
require 'database/db_conn.php';
$stmt = $conn->prepare("SELECT id FROM user WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($user_id);
$stmt->fetch();
$stmt->close();

// Handle form submission for adding a task
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_task'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $subtitle = mysqli_real_escape_string($conn, $_POST['subtitle']);
    $short_description = mysqli_real_escape_string($conn, $_POST['short_description']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $timestamps = date('Y-m-d H:i:s');
    $start_datetime = $timestamps;

    // Insert task into tasks table
    $stmt = $conn->prepare("INSERT INTO tasks (title, subtitle, short_description, status, timestamps, user_id) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssi", $title, $subtitle, $short_description, $status, $timestamps, $user_id);
    $stmt->execute();
    $stmt->close();

    // Insert start_datetime into clocked table
    $stmt = $conn->prepare("INSERT INTO clocked (user_id, start_datetime, timestamps) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user_id, $start_datetime, $timestamps);
    $stmt->execute();
    $stmt->close();
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['logout'])) {
    $end_datetime = date('Y-m-d H:i:s');


    $stmt = $conn->prepare("UPDATE clocked SET end_datetime = ? WHERE user_id = ? AND end_datetime IS NULL");
    $stmt->bind_param("si", $end_datetime, $user_id);
    $stmt->execute();
    $stmt->close();


    session_destroy();
    header("Location: index.php");
    exit();
}


$result = $conn->query("SELECT title, subtitle, short_description, status, timestamps FROM tasks WHERE user_id = $user_id");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
</head>
<body>
    <h2><?php echo htmlspecialchars($email); ?></h2>

    <form method="POST" style="position: absolute; top: 10px; right: 10px;">
        <input type="submit" name="logout" value="Logout">
    </form>
    <br>

    <h3>Add Task</h3>
    <form method="POST" action="">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required><br>
        <br>
        <label for="subtitle">Subtitle:</label>
        <input type="text" id="subtitle" name="subtitle" required><br>
        <br>
        <label for="short_description">Short Description:</label>
        <input type="text" id="short_description" name="short_description" required></input><br>
        <br>
        <label for="status">Status:</label>
        <select id="status" name="status">
            <option value="Not Started">Not Started</option>
            <option value="In Progress">In Progress</option>
            <option value="Completed">Completed</option>
        </select>
        <br>
        <br>
        <input type="submit" name="add_task" value="Add Task">
    </form>

    <div id="line" style="position: absolute; top: 45%; width: 100%; right:10px; height: 2px; background-color: black;"></div>
    <br>

    <h3>Tasks</h3>
    <table border="1">
        <tr>
            <th>Title</th>
            <th>Subtitle</th>
            <th>Short Description</th>
            <th>Status</th>
            <th>Timestamps</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row["title"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["subtitle"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["short_description"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["status"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["timestamps"]) . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No tasks found</td></tr>";
        }
        $conn->close();
        ?>
    </table>
</body>
</html>