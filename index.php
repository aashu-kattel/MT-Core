<?php
    require 'database/db_conn.php';

    session_start();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $password = md5($password);

        $stmt = $conn->prepare("SELECT isAdmin FROM user WHERE email = ? AND Password = ?");
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($isAdmin);
            $stmt->fetch();

            $_SESSION['email'] = $email;
            $_SESSION['isAdmin'] = $isAdmin;

            if ($isAdmin == 1) {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: user_dashboard.php");
            }
            exit();
        } else {
            echo"No match found";
        }

        $stmt->close();
        $conn->close();
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>TMS Login</title>
</head>
<body>
    <center>
    <div class="loginbox">
        <h1>Task Management System - Login</h1>
        <form method="POST">
            <p>Email:</p>
            <input type="email" name="email" placeholder="Enter Email">
            <p>Password:</p>
            <input type="password" name="password" placeholder="Enter Password"> <br>
            <br>
            <input type="submit" name="submit" value="Login"><br>
            <a href="resetpw.php">Forgot password?</a><br>
        </for>
    </div>
    </center>
</body>
</html>