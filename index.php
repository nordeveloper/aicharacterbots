<?php 
require("header.php");
use classes\User;
$user = User::auth_user();

if( !User::check_auth()){
   User::logout();
}
?>
   <div class="container wrapper chat-page background">
      <?php require("navbar.php") ?>

      <div id="messages-box" class="chat-messages">

      </div>

      <form id="input-form" class="input-message" method="post">
         <input type="hidden" id="char_id" name="char_id" value="<?php echo $char['name']?>">
         <textarea class="msg-input" name="msg" placeholder="Type your message"></textarea>
         <button id="btn-send" type="button"></button>
      </form>      
   </div>
<?php require("footer.php")?>
