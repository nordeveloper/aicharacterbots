<?php 
require(__DIR__."/header.php");
use classes\User;

if( !User::check_auth()){
    User::logout();
}?>

<div class="container wrapper background">
    <?php require("navbar.php") ?>

    <form method="POST" class="settings-form row justify-content-center pb-3" action="api.php" enctype="multipart/form-data">
        <div class="col-10">
            <div class="form-group">
                <label>Character File must be json format</label><br>
                <input type="file" name="char_file">
            </div>
            <div class="form-group">
                <input type="hidden"  name="action" value="import">
                <button class="btn btn-info">Import</button>
            </div>
        </div>
    </form>

</div>    
<?php require("footer.php")?>