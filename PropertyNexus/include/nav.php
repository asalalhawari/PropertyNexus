<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once("adminDashboard/connection.php");

// Function to fetch the user's first name and admin status
function getUserInfo($userID, $db_conn) {
    $stmt = $db_conn->prepare("SELECT userFname, isAdmin FROM Users WHERE userID = ?");
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $stmt->bind_result($userFname, $isAdmin);
    $stmt->fetch();
    $stmt->close();
    return [$userFname, $isAdmin];
}

// Handle sign out
if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header('Location: index.php'); // Redirect to index page after logout
    exit();
}
?>

<header>
  <nav>
    <div class="links">
      <img src="images/logo.png" alt="Property Nexus Logo">
      <a href="#home">HOME</a>
      <a href="#service">SERVICE</a> 
      <a href="#about">ABOUT</a>
      <a href="#contact">CONTACT</a>
    </div>

    <div class="home_btn2">
      <?php if (!isset($_SESSION['userID'])): ?>
        <!-- Show Sign In and Register if not logged in -->
        <button class="nav_btns"><a class="link" href="./login.php">Sign In</a></button>
        <button class="nav_btns"><a class="link" href="./register.php">Register</a></button>
      <?php else: ?>
        <!-- Show Hello username and Sign Out if logged in -->
        <?php
        $userID = $_SESSION['userID'];
        list($userFname, $isAdmin) = getUserInfo($userID, $db_conn);
        ?>
        <button class="nav_btns"><a class="link" href="./profile.php">Hello <?php echo htmlspecialchars($userFname); ?></a></button>
        <?php if ($isAdmin): ?>
          <button class="nav_btns"><a class="link" href="adminDashboard/Dashboard.php">Admin Dashboard</a></button>
        <?php endif; ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" style="display:inline;">
          <button class="nav_btns" name="logout" type="submit">Sign Out</button>
        </form>
      <?php endif; ?>
    </div> 
  </nav>
</header>
