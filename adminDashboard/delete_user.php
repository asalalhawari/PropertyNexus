<?php
include("connection.php");

// if (isset($_POST['userID'])) {
//     $userID = intval($_POST['userID']);
//     $query = "DELETE FROM users WHERE userID = $userID";
//     if (mysqli_query($db_conn, $query)) {
//         echo "User deleted successfully.";
//     } else {
//         echo "Error deleting user: " . mysqli_error($db_conn);
//     }
// }


include("connection.php");

if (isset($_POST['userID'])) {
    // $s_q = "SELECT userID FROM users WHERE isAdmin = 0";
    if (mysqli_query($db_conn, "SELECT userID FROM users WHERE isAdmin = 0")) {
        $userID = intval($_POST['userID']);
        $query = "DELETE FROM users WHERE userID = $userID";
        if (mysqli_query($db_conn, $query)) {
            echo "User deleted successfully.";
        }else {
            echo "Error deleting user: " . mysqli_error($db_conn);
        }
    }if (mysqli_query($db_conn, "SELECT userID FROM users WHERE isAdmin = 1")) {
        echo '<script>alert("You cant delete admin, please contact with DB administration")</script>'; 
    }

};
