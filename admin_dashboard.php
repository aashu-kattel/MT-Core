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
            left:10px;
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
</div>
</body>
</html>