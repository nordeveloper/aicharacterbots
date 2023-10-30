<?php
require(__DIR__."/system.php");
use classes\User;


// user login, register, logout
if( !empty($_REQUEST['action']) && $_REQUEST['action']=='login' && !empty($_REQUEST['email']) && !empty($_REQUEST['password'])){
   
    $authorize = User::login($_REQUEST['email'], $_REQUEST['password']);

    if($authorize){
        ob_end_clean();
        header("location:index.php");
    }else{
        ob_end_clean();
        $_SESSION['flush_message'] = "Wrong email or password";
        header("location:login.php");
    }
}

if( !empty($_REQUEST['action']) && $_REQUEST['action']=='register' && !empty($_REQUEST['email']) && !empty($_REQUEST['password']) ){

    $register = User::register($_REQUEST);
    if($register){
        ob_end_clean();
        header("location:login.php");
    }
}

if( !empty($_REQUEST['action']) && $_REQUEST['action']=='save_profile' && !empty($_REQUEST['email']) ){
    User::save_profile($_REQUEST);
    header("location:profile.php");
}

if( !empty($_REQUEST['logout']) ){
    User::logout();
}