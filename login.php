<?php 
require("header.php");
?>
<div class="container wrapper background">
  <?php require("navbar.php") ?>

  <div class="row justify-content-center">
    <div class="col-md-6 col-12">
      <h2 class="mt-2">CharBotsAi</h2>  
      <div class="card login-box">
        <div class="card-header">
          <h4>Authorization</h4>
        </div>
        <div class="card-body">
          <form action="auth.php" method="post">
              <?php if(isset($_SESSION['flush_message'])): ?>
              <p class="alert alert-danger"><?=$_SESSION['flush_message']?></p>
              <?php endif?>
            <div class="form-group">
              <label for="email">Email</label>
              <input type="text" class="form-control" id="email" name="email" placeholder="Enter username">
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
            </div>
            <input type="hidden" name="action" value="login">
            <button type="submit" class="btn btn-primary mr-3">Login</button>  <a class="btn" href="register.php">Registration</a>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<?php require("footer.php")?>