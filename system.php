<?php
session_start();
ob_start();
require __DIR__.'/bootstrap.php';
require(__DIR__."/helper.php");

define('CHARACTERS_DIR', __DIR__.'/characters');
define('CHAR_PUBLIC_DIR', 'characters/');

use classes\Character;


if( !empty($_REQUEST['char_id']) ){
    $character = new Character();
    $char = $character->getCharacter($_REQUEST['char_id']);

    if( !empty($char) ){
        $_SESSION['char_id'] = $char['name'];        
    }
    
}else{
    $_SESSION['char_id'] = 'default';
    $char['name'] =  'default';
    $char['char_name'] =  'default';
}


// setCorsHeaders();