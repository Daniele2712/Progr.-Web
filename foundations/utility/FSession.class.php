<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}


class FSession{
    private $user;
    private $logged = false;

    public function __construct(){
        session_start();
    }

    public function login($username,$password){
        if($username !== NULL && $username !== '' && $password !== NULL && $password !== ''){
            $this->user = FUtente::login($username,$password);
            return $this->user;
        }else{
            return false;
        }
    }

    public function isLogged(){
        return $this->user!=NULL;
    }
}
