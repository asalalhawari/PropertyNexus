<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/login.css">
    <title>Document</title>
</head>
<body>
  

    
   
</form>

</body>
</html>
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
           echo' <script>alert("No user found with this email")</script>';
            
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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="styles.css">
    <title></title>
</head>
<body>
    <div class="login">
        <img src="pic.img.jpg" alt="login image" class="login__img">
 <div class="wrapper">
    <!-- <nav class="nav">
        <div class="nav-logo">
            

            <p>Property nexus</p>
        </div>
       
        <div class="nav-menu" id="navMenu">
            <ul>
                <li><a href="#" class="link active">Home</a></li>
                <li><a href="#" class="link">About</a></li>
                <li><a href="#" class="link">Services</a></li>
                <li><a href="#" class="link">Contact</a></li>
            </ul>
        </div>
        <div class="nav-button">
            <button class="btn white-btn" id="loginBtn" onclick="login()">Sign In</button>
            <button class="btn" id="registerBtn" onclick="register()">Sign Up</button>
        </div> -->
        <!-- <div class="nav-menu-btn">
            <i class="bx bx-menu" onclick="myMenuFunction()"></i>
        </div>
    </nav> -->

<!----------------------------- Form box ----------------------------------->    
    <div class="form-box">
        <form class="login-container" id="login" method="post" action="login.php">
            <div class="top">
                <span>Don't have an account? <a href="#" onclick="register()">Sign Up</a></span>
                <header>Login</header>
            </div>
            <div class="input-box">
            <label for="u_email">Email:</label>
            <input class="input-field" placeholder="Email" type="email" name="u_email" required><br>
                <i class="bx bx-user"></i>
            </div>
            <div class="input-box">
            <label for="u_pw">Password:</label>
    <input class="input-field" placeholder="Password" type="password" name="u_pw" required><br>
                <i class="bx bx-lock-alt"></i>
            </div>
            <div class="input-box">
            <input type="submit" name="login" value="Login" class="submit">
    
            </div>
            <div class="two-col">
                <div class="one">
                    <input type="checkbox" id="login-check">
                    <label for="login-check"> Remember Me</label>
                </div>
                <div class="two">
                    <label><a href="#">Forgot password?</a></label>
                </div>
            </div>
        </div>

        <!------------------- registration form -------------------------->
        <div class="register-container" id="register">
            <div class="top">
                <span>Have an account? <a href="#" onclick="login()">Login</a></span>
                <header>Sign Up</header>
            </div>
            <div class="two-forms">
                <div class="input-box">
                    <input type="text" class="input-field" placeholder="Firstname">
                    <i class="bx bx-user"></i>
                </div>
                <div class="input-box">
                    <input type="text" class="input-field" placeholder="Lastname">
                    <i class="bx bx-user"></i>
                </div>
            </div>
            <div class="input-box">
                <input type="text" class="input-field" placeholder="Email">
                <i class="bx bx-envelope"></i>
            </div>
            <div class="input-box">
                <input type="password" class="input-field" placeholder="Password">
                <i class="bx bx-lock-alt"></i>
            </div>
            <div class="input-box">
                <input type="submit" class="submit" value="Register">
            </div>
            <div class="two-col">
                <div class="one">
                    <input type="checkbox" id="register-check">
                    <label for="register-check"> Remember Me</label>
                </div>
                <div class="two">
                    <label><a href="#">Terms & conditions</a></label>
                </div>
            </div>
        </div>
    </div>
</div>   
    </div>
  <script src="login.js"></script>
 

</body>
</html>