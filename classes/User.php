<?php
namespace classes;

use Models\User as ModelsUser;

class User extends ModelsUser{

    public $user_id = null;
    
    #user login function
    public static function login($email, $password)
    {
        $user = ModelsUser::where(['email'=>$email])->first();
        if( password_verify( $password, $user['password'] ) ){
            $_SESSION['user'] = $user->toArray();
            return $_SESSION['user'];
        }
    }

    #user register function
    public static function register($request)
    {
        $arUser = $request;
        $passwordHash = password_hash($arUser['password'], PASSWORD_DEFAULT);
        
        $arUser['password'] = $passwordHash;

        return ModelsUser::create($arUser);
    }

    public static function auth_user(){
        if( !empty($_SESSION['user']) ){
            return $_SESSION['user'];
        }
    }


    public function get_user(){
        return $this->find($this->user_id);
    }

    public static function save_profile($request){

        if(empty($request['email'])){
            return false;
        }

        $user = User::find($_SESSION['user']['id']);

        $user->username = !empty($request['username']) ? $request['username'] : $user->username;
        $user->email = $request['email'];

        if(!empty($request['password']) && $request['password'] == $request['confirm_password'] ){
            $user->password = password_hash($request['password'], PASSWORD_DEFAULT);
        }

        return $user->save();
    }

    public static function logout()
    {
        unset($_SESSION['user']);
        session_destroy();
        ob_end_clean();
        header("location:login.php");
    }


    public static function check_auth(){
        return isset($_SESSION['user']);
    }
    
 }