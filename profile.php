<?php 
require("header.php");
use classes\User;

if( !User::check_auth()){
  User::logout();
}

$arUser = User::find($_SESSION['user']['id']);
?>
<div class="container wrapper background">
   <?php require("navbar.php") ?>

  <div class="row justify-content-center">
    <div class="card profile-box">
        <div class="card-header">
          User Profile
        </div>
        <div class="card-body">
          <form action="auth.php" method="POST">
            <div class="form-group">
              <label for="name">Name</label>
              <input type="text" class="form-control" name="username" placeholder="Enter your name" value="<?php echo $arUser['username'] ?>">
            </div>
            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" class="form-control" name="email" placeholder="Enter your email" value="<?php echo $arUser['email'] ?>">
            </div>
            <div class="form-group">
              <label for="password">New Password</label>
              <input type="password" class="form-control" name="password" placeholder="Enter password">
            </div>
            <div class="form-group">
              <label for="confirmPassword">Confirm Password</label>
              <input type="password" class="form-control" name="confirm_password" placeholder="Confirm password">
            </div>
            <input type="hidden" name="action" value="save_profile">
            <button type="submit" class="btn btn-success">Save</button>
          </form>
        </div>
      </div>
  </div>

</div>

<?php require("footer.php")?>