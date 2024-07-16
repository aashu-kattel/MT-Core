<?php
require 'database/db_conn.php';

if (isset($_GET['id'])) {
    $user_id = intval($_GET['id']);

$tasksResult = $conn->query("SELECT * FROM tasks WHERE user_id = $user_id");

    // Fetch user details from the database
    $stmt = $conn->prepare("SELECT first_name, last_name, email, online_status, timestamps FROM user WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($first_name, $last_name, $email, $online_status, $timestamps);
    $stmt->fetch();
    $stmt->close();
} else {
    echo "No user ID provided.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Detail</title>
</head>
<body>
    <h2>User Detail</h2>
    <p><strong>First Name:</strong> <?php echo htmlspecialchars($first_name); ?></p>
    <p><strong>Last Name:</strong> <?php echo htmlspecialchars($last_name); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
    <p><strong>Online Status:</strong> <?php echo htmlspecialchars($online_status); ?></p>
    <p><strong>Timestamps:</strong> <?php echo htmlspecialchars($timestamps); ?></p>

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
        while ($row = $tasksResult->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['title']) . "</td>";
            echo "<td>" . htmlspecialchars($row['subtitle']) . "</td>";
            echo "<td>" . htmlspecialchars($row['short_description']) . "</td>";
            echo "<td>" . htmlspecialchars($row['status']) . "</td>";
            echo "<td>" . htmlspecialchars($row['timestamps']) . "</td>";
            echo "</tr>";
        }
        ?>
    </table>
    <br>
    <a href="admin_dashboard.php">Back to Dashboard</a>
</body>
</html>