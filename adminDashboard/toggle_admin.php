<?php
include("connection.php");

if (isset($_POST['userID']) && isset($_POST['isAdmin'])) {
    $userID = intval($_POST['userID']);
    $isAdmin = intval($_POST['isAdmin']);
    $query = "UPDATE users SET isAdmin = $isAdmin WHERE userID = $userID";
    if (mysqli_query($db_conn, $query)) {
        echo "User admin status updated successfully.";
    } else {
        echo "Error updating admin status: " . mysqli_error($db_conn);
    }
}
?>
