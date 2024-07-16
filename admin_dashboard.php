<?php
 require 'database/db_conn.php';

 session_start();

 if (!isset($_SESSION['email']) || $_SESSION['isAdmin'] != 1) {
    header("Location: index.php");
    exit();
}

if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}

if (isset($_POST["create_user"])) {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $stmt = $conn->prepare("INSERT INTO user (first_name, last_name, email, Password, isAdmin) VALUES (?, ?, ?, ?, 0)");
    $stmt->bind_param("ssss", $firstName, $lastName, $email, $password);
    $stmt->execute();
    $stmt->close();
}

$result = $conn->query("SELECT id, first_name, last_name, email, online_status, timestamps FROM user WHERE isAdmin = 0");



if (isset($_POST['delete_user'])) {
    require 'database/db_conn.php';

    $email = mysqli_real_escape_string($conn, $_POST['email']);

    $stmt = $conn->prepare("DELETE FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    header("Location: admin_dashboard.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>
<body>
<h2>Admin Dashboard!</h2>

<form method="POST" style="position: absolute;
            top: 10px;
            right: 10px;">
    <input type="submit" name="logout" value="Logout">
</form>

<div id="line" style = "position: absolute;
            top: 50px;
            width: 100%;
            right:10px;
            height: 2px;
            background-color: black;"></div>

<div id="create user">
    <b>Create User</b>
    <form method="POST">
        <p>First Name</p>
        <input type="text" name="firstName" placeholder="Enter Fname">
        <p>Last Name:</p>
        <input type="text" name="lastName" placeholder="Enter Lname">
        <p>Email:</p>
        <input type="email" name="email" placeholder="Enter Email">
        <p>Password:</p>
        <input type="password" name="password" placeholder="Enter Password"> <br>
        <br>
        <input type="submit" name="create_user" value="Create User"><br>
    </form>

    <div id="line" style = "position: absolute;
            top: 56%;
            width: 100%;
            right:10px;
            height: 2px;
            background-color: black;"></div>
            <br>

    <b>Users</b>

    <table border="1">
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Online Status</th>
            <th>Timestamps</th>
            <th>Actions</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td><a href='user_detail.php?id=" . $row["id"] . "'>" . htmlspecialchars($row["first_name"]) . "</a></td>";
                echo "<td>" . $row["last_name"] . "</td>";
                echo "<td>" . $row["email"] . "</td>";
                echo "<td>" . $row["online_status"] . "</td>";
                echo "<td>" . $row["timestamps"] . "</td>";
                echo "<td>";
                echo "<form method='POST' action='' style='display:inline;'>";
                echo "<input type='hidden' name='email' value='" . htmlspecialchars($row["email"]) . "'>";
                echo "<input type='submit' name='delete_user' value='Delete'>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No users found</td></tr>";
        }
        $conn->close();
        ?>
    </table>
</div>
</body>
</html>