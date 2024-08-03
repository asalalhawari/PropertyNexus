<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="style.css">

<?php
include("connection.php");

// Error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Form handling
if (isset($_POST['addusr'])) {
    $fname = mysqli_real_escape_string($db_conn, $_POST['userFname']);
    $lname = mysqli_real_escape_string($db_conn, $_POST['userLname']);
    $pw = mysqli_real_escape_string($db_conn, $_POST['userPW']);
    $email = mysqli_real_escape_string($db_conn, $_POST['userEmail']);
    $adress = mysqli_real_escape_string($db_conn, $_POST['userAdress']);
    $mobile = mysqli_real_escape_string($db_conn, $_POST['userMobile']);
    $isAdmin = (int)$_POST['isAdmin'];

    if (empty($fname) || empty($lname) || empty($pw) || empty($email) || empty($mobile)) {
        header('Location: admin.php?message=All fields are required. Please fill all fields.');
        exit();
    } else {
        $insert_Q = "INSERT INTO users (userFname, userLname, userAdress, userPW, userMobile, userEmail, isAdmin) VALUES ('$fname', '$lname', '$adress', '$pw', '$mobile', '$email', '$isAdmin')";
        if (mysqli_query($db_conn, $insert_Q)) {
            header('Location: admin.php?insrt_msg=User data has been added successfully!');
        } else {
            die("Query Failed: " . mysqli_error($db_conn));
        }
        exit();
    }
}
?>

<!-- Bootstrap table -->
<div class="container">
    <div class="subContainer">
        <h2>Users</h2>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addUsrModal">Add user</button>
    </div>

    <table class="table table-hover table-bordered table-striped">
        <thead>
            <tr>
                <th>User ID</th>
                <th>User First Name</th>
                <th>/user Last Name</th>
                <th>Mobile number</th>
                <th>Email adress</th>
                <th>Admin status</th>
                <th>Activety</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $select_Q = "SELECT * FROM users";
            $select_r = mysqli_query($db_conn, $select_Q);
            while ($rec = mysqli_fetch_assoc($select_r)) {
                $userID = $rec['userID'];
                echo "
                        <tr>
                            <td>{$rec['userID']}</td>
                            <td>{$rec['userFname']}</td>
                            <td>{$rec['userLname']}</td>
                            <td>{$rec['userMobile']}</td>
                            <td>{$rec['userEmail']}</td>
                            <td>" . ($rec['isAdmin'] ? 'Admin' : 'User') . "</td>
                            <td>
                                <a href='edit_user.php?userID={$rec['userID']}' class='btn btn-warning btn-sm edit-btn' data-id='{$userID}'>
                                    <i class='fa-solid fa-user-pen'></i>
                                </a>
                                <button class='btn btn-danger btn-sm delete-btn' data-id='{$userID}'>
                                    <i class='fa-solid fa-user-minus'></i>
                                </button>
                                <button class='btn btn-info btn-sm toggle-admin-btn' data-id='{$userID}' data-isadmin='{$rec['isAdmin']}'>
                                    <i class='fa-solid fa-user-tie'></i>
                                </button>
                            </td>
                        </tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- add -->
    <?php
    //validation
    if (isset($_POST['addusr'])) {
        $fname = $_POST['userFname'];
        $lname = $_POST['userLname'];
        $pw = $_POST['userPW'];
        $lname = $_POST['userMobile'];
        $lname = $_POST['userEmail'];
        $lname = $_POST['isAdmin'];

        if ($userFname == "" || $userLname == "" || $userMobile == "") {
            header('location: ../database.php?message=All fields are required. Please fill all fields.');
            // $errorMsg = "All fields are required. Please fill all fields.";
            // echo "<h6>" . $errorMsg . "</h6>";
        } else {
            //     $successMsg = "Student added successfully.";
            $insert_Q = "INSERT INTO students (userFname, userLname, userPW, userMobile, userEmail, isAdmin) VALUES ('$userFname', '$userLname', '$userMobile', '$userEmail', '$isAdmin');";
            $insert_r = mysqli_query($db_conn, $insert_Q);
            if (!$insert_r) {
                die("Query Failed, try again" . mysqli_error($db_conn));
            } else {
                header('location: ../database.php?insrt_msg=Student data has been added successfully!');
            }
            // mysqli_close($db_conn);
        }
    }
    ?>

    <!-- Add User Modal -->
    <form action="admin.php" method="POST">
        <div class="modal fade" id="addUsrModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fs-5" id="exampleModalLabel"><b>Add User Information</b></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="userFname">First Name</label>
                            <input type="text" name="userFname" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="userLname">Last Name</label>
                            <input type="text" name="userLname" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="userPW">User Password</label>
                            <input type="password" name="userPW" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="userEmail">Email</label>
                            <input type="email" name="userEmail" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="userAdress">Adress</label>
                            <input type="text" name="userAdress" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="userMobile">Mobile Number</label>
                            <input type="text" name="userMobile" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="isAdmin">Admin Status</label>
                            <select name="isAdmin" class="form-control" required>
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <input type="submit" class="btn btn-success" name="addusr" value="ADD">
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- edit -->


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- ajax -->
    <script>
        $(document).ready(function() {
            // Populate Edit Modal with User Data
            $('.edit-btn').on('click', function() {
                var userID = $(this).data('id');

                $.ajax({
                    url: 'get_user.php',
                    method: 'POST',
                    data: {
                        userID: userID
                    },
                    dataType: 'json',
                    success: function(data) {
                        $('#editUserID').val(data.userID);
                        $('#editUserFname').val(data.userFname);
                        $('#editUserLname').val(data.userLname);
                        $('#editUserEmail').val(data.userEmail);
                        $('#editUserMobile').val(data.userMobile);
                    }
                });
            });

            // Handle Edit Form Submission
            $('#editUserForm').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: 'edit_user.php',
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        alert(response);
                        location.reload();
                    }
                });
            });

            // Handle Delete Button Click
            $('.delete-btn').on('click', function() {
                if (confirm('Are you sure you want to delete this user?')) {
                    var userID = $(this).data('id');

                    $.ajax({
                        url: 'delete_user.php',
                        method: 'POST',
                        data: {
                            userID: userID
                        },
                        success: function(response) {
                            alert(response);
                            location.reload();
                        }
                    });
                }
            });

            // Handle Toggle Admin Button Click
            $('.toggle-admin-btn').on('click', function() {
                var userID = $(this).data('id');
                var isAdmin = $(this).data('isadmin') ? 0 : 1;

                $.ajax({
                    url: 'toggle_admin.php',
                    method: 'POST',
                    data: {
                        userID: userID,
                        isAdmin: isAdmin
                    },
                    success: function(response) {
                        alert(response);
                        location.reload();
                    }
                });
            });
        });
    </script>