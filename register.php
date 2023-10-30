<?php 
require("header.php");
?>
<div class="container wrapper background">
  <?php require("navbar.php") ?>
  <div class="row justify-content-center">
    <div class="col-md-5 col-12">
    <h2 class="mt-2">CharBotsAi</h2>  
      <div class="card login-box">
        <div class="card-header">
          <h4>Register</h4>
        </div>
        <div class="card-body">
          <form action="auth.php" method="POST">
            <div class="form-group">
              <label>Name</label>
              <input type="text" class="form-control" name="username" placeholder="Enter your name">
            </div>
            <div class="form-group">
              <label>Email</label>
              <input type="email" class="form-control" name="email" placeholder="Enter your email">
            </div>
            <div class="form-group">
              <label>Password</label>
              <input type="password" class="form-control" name="password" placeholder="Enter password">
            </div>
            <div class="form-group">
              <label>Confirm Password</label>
              <input type="password" class="form-control" name="confirm_password" placeholder="Confirm password">
            </div>
            <input type="hidden" name="action" value="register">
            <button type="submit" class="btn btn-primary mr-3">Register</button> <a class="btn" href="login.php">Login</a>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<?php require("footer.php")?>