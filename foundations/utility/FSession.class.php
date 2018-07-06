<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}


class FSession{
    public function __construct(){
        session_start();
    }

    public function login($username,$password){
        if($username !== NULL && $username !== '' && $password !== NULL && $password !== ''){
            $_SESSION["userId"] = FUtente::login($username,$password);
            return $_SESSION["userId"];
        }else
            return false;
    }

    public function logout(){
        session_unset();
        session_destroy();
    }

    public function getUser(): EUtente{
        return FUtente::find($_SESSION["userId"]);
    }

    public function isLogged(){
        return $_SESSION["userId"]!==NULL;
    }
}
