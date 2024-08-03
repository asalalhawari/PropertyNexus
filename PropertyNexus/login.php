<?php
include_once("adminDashboard/connection.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    // Retrieve form data
    $u_email = $_POST['u_email'];
    $u_pw = $_POST['u_pw'];

    // Basic validation
    if (empty($u_email) || empty($u_pw)) {
        echo "<h6 style='color: red;'>Both email and password are required.</h6>";
    } else {
        // Prepare and execute SQL query to check if the user exists
        $stmt = $db_conn->prepare("SELECT userID, userPW, isAdmin FROM Users WHERE userEmail = ?");
        $stmt->bind_param("s", $u_email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 0) {
            // No user found
            echo "<h6 style='color: red;'>No user found with this email.</h6>";
        } else {
            // Bind result variables
            $stmt->bind_result($user_id, $stored_pw, $isAdmin);
            $stmt->fetch();

            // Verify the password (plaintext comparison)
            if ($u_pw === $stored_pw) {
                echo "<h6 style='color: green;'>Login successful!</h6>";

                // Start a session and store user info
                session_start();
                $_SESSION['userID'] = $user_id;
                $_SESSION['userEmail'] = $u_email;
                $_SESSION['isAdmin'] = $isAdmin;

                // Redirect to a secure area or home page
                header('Location: index.php'); // Replace with your secure page
                exit();
            } else {
                echo "<h6 style='color: red;'>Incorrect password.</h6>";
            }
        }
        $stmt->close();
    }
    $db_conn->close();
}
?>

<!-- HTML Form for Login -->
<form method="post" action="login.php">
    <label for="u_email">Email:</label>
    <input type="email" name="u_email" required><br>

    <label for="u_pw">Password:</label>
    <input type="password" name="u_pw" required><br>

    <input type="submit" name="login" value="Login">
</form>
