<?php
 require 'database/db_conn.php';

 session_start();

 if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}
$email = $_SESSION['email'];

if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
</head>
<body>
    <h2><?php echo"$email" ?></h2>

    <form method="POST" style="position: absolute;
            top: 10px;
            right: 10px;">
    <input type="submit" name="logout" value="Logout">
</form>

</body>
</html>