<?php

session_start();
require_once("adminDashboard/connection.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fname = $_POST['uFname'];
    $lname = $_POST['uLname'];
    $password =$_POST['u_pw'];
    $email = $_POST['u_email'];
    $address = $_POST['u_adress'];
    $mobile = $_POST['u_mob'];

    $stmt = $db_conn->prepare("INSERT INTO users (userFname, userLname, userPW, userEmail, userAdress, userMobile, isAdmin) VALUES (?, ?, ?, ?, ?, ?, 0)");
    $stmt->bind_param("ssssss", $fname, $lname, $password, $email, $address, $mobile);

    if ($stmt->execute()) {
        echo "Sign-up successful!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $db_conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>
</head>
<body>
    <form method="post" action="signup.php">
        <label for="uFname">First Name:</label>
        <input type="text" name="uFname" required><br>

        <label for="uLname">Last Name:</label>
        <input type="text" name="uLname" required><br>

        <label for="u_pw">Password:</label>
        <input type="password" name="u_pw" required><br>

        <label for="u_email">Email:</label>
        <input type="email" name="u_email" required><br>

        <label for="u_adress">Address:</label>
        <input type="text" name="u_adress" required><br>

        <label for="u_mob">Mobile:</label>
        <input type="text" name="u_mob" required><br>

        <input type="submit" name="signup" value="Sign Up">
    </form>
</body>
</html>
