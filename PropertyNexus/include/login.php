<!-- Include top -->
<?php include 'top.php'; ?>

<!-- Include nav -->
<?php include 'nav.php'; ?>

<!-- Form Box -->
<div class="form-box">
  <!-- Login Form -->
  <div class="login-container" id="login">
    <div class="top">
      <span>Don't have an account? <a href="#" onclick="register()">Sign Up</a></span>
      <header>Login</header>
    </div>
    <form method="post" action="login_process.php">
      <div class="input-box">
        <input type="text" name="username" class="input-field" placeholder="Username or Email" required>
        <i class="bx bx-user"></i>
      </div>
      <div class="input-box">
        <input type="password" name="password" class="input-field" placeholder="Password" required>
        <i class="bx bx-lock-alt"></i>
      </div>
      <div class="input-box">
        <input type="submit" class="submit" value="Sign In">
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
    </form>
  </div>

  <!-- Registration Form -->
  <div class="register-container" id="register">
    <div class="top">
      <span>Have an account? <a href="#" onclick="login()">Login</a></span>
      <header>Sign Up</header>
    </div>
    <form method="post" action="register_process.php">
      <div class="two-forms">
        <div class="input-box">
          <input type="text" name="firstname" class="input-field" placeholder="Firstname" required>
          <i class="bx bx-user"></i>
        </div>
        <div class="input-box">
          <input type="text" name="lastname" class="input-field" placeholder="Lastname" required>
          <i class="bx bx-user"></i>
        </div>
      </div>
      <div class="input-box">
        <input type="text" name="email" class="input-field" placeholder="Email" required>
        <i class="bx bx-envelope"></i>
      </div>
      <div class="input-box">
        <input type="password" name="password" class="input-field" placeholder="Password" required>
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
    </form>
  </div>
</div>

<!-- Include footer -->
<?php include 'footer.php'; ?>

<!-- Include bottom -->
<?php include 'bottom.php'; ?>