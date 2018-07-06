<?php
namespace Controllers;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class user{
    public function getIndirizzi($req){
        $sessione = \Singleton::Session();
        if(!$sessione->isLogged())
            echo "non loggato";
        $user = $sessione->getUser();
        if(get_class($user)==="\\Models\\UtenteRegistrato"){
            echo "<pre>";
            print_r($user->getIndirizzi());
            echo "</pre>";
        }
        //$v = new VHome();
        //$v->render();
    }

    public function login($req){
        $user = $req->getString("username");
        $pw = $req->getString("password");
        try{
            \Singleton::Session()->login($user,$pw);
            $user = \Singleton::Session()->getUser();
            echo "<pre>";
            print_r($user);
            echo "</pre>";
        }catch(\ModelException $e){
            echo "<pre>";
            echo str_replace("\n", "<br>", $e);
            echo "</pre>";
        }
    }

    public function logout($req){
        \Singleton::Session()->logout();
        echo "logged out";
    }
}
