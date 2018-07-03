<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}


class FSession{
    private $user;

    public function __construct(){
        session_start();
    }

    public function login($username,$password){
        if($username !== undefined && $username !== '' && $password !== undefined && $password !== ''){
            $this->user = FUtente::login($username,$password);
        }else{
            return false;
        }
    }
}
