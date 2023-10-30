<?php
require("header.php");

use classes\Character;
use classes\User;

if (!User::check_auth()) {
    User::logout();
}
?>

<div class="container wrapper background">
        <?php require("navbar.php") ?>

        <div class="row pt-3">
            <div class="col-lg-5 col-12">
                <a class="btn btn-success" href="character.php">Add Character</a>
            </div>
            <div class="col-lg-7 col-12">
                <a href="import.php" class="btn btn-info">Import Character</a>
            </div>
        </div>

        <div class="row">
            <div class="chars-list col-lg-12">
                <?php
                $character = new Character();
                $arCharacters = $character->getCharacters();

                if (!empty($arCharacters)) {
                    foreach ($arCharacters as $char) {
                        echo $character->ShowCharacter($char);
                    }
                }
                ?>
            </div>
        </div>
</div>
<?php require("footer.php") ?>