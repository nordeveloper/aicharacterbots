<div class="d-flex nav-nox">
<nav class="navbar" id="menu-container">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">

    <?php if(\classes\User::check_auth()): ?>

      <li class="nav-item active">
        <a href="index.php?char_id=<?php echo $char['name']?>">Chat <span class="sr-only">(current)</span></a>
      </li>

      <li class="nav-item active">
      <a class="nav-link" href="settings.php">Settings</a>
      </li>

      <li class="nav-item">
      <a class="nav-link" href="characters.php">Characters</a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="profile.php">Profile</a>
      </li> 

      <li class="nav-item">
      <a class="nav-link" href="auth.php?logout=y">Logout</a>
      </li>

     <?php else: ?>
        <li class="nav-item">
        <a class="nav-link" href="login.php">Login</a>
        </li>

        <li class="nav-item">
        <a class="nav-link" href="register.php">Register</a>
        </li>
     <?php endif?>
    </ul>
  </div>
</nav>

<?php if( \classes\User::check_auth() && !empty($char['char_name']) && !empty($char['name']) ): ?>
  <div class="char-icon">
    <div class="char-name">
      <a class="remove-history" href="api.php?char_id=<?php echo $char['name']?>&delete=y">Delete History</a>
      <?php echo $char['char_name']?>
    </div>
      <?php
      $charbgimg = 'background-image:url(img/bot.png)';
      if( !empty($char['char_image']) ){
        $charbgimg = 'background-image:url('.CHAR_PUBLIC_DIR.$char['char_image'].')';
      }
      ?>    
    <div class="chat-iamge" title="<?php echo $char['char_name']?>" style="<?php echo $charbgimg?>"></div> 
  </div>
<?php endif ?>

</div>
