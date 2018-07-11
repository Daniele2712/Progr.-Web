<?php
namespace Controllers;
use \Views\Request as Request;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class User implements Controller{
    public function getIndirizzi(Request $req){
        $sessione = \Singleton::Session();
        if(!$sessione->isLogged()){
            echo "non loggato";
            die();
        }
        $user = $sessione->getUser();
        if(get_class($user)==="Models\\UtenteRegistrato"){
            echo "<pre>";
            print_r($user->getIndirizzi());
            echo "</pre>";
        }
        //$v = new VHome();
        //$v->render();
    }

    public function login(Request $req){

        $user = $req->getString("username", NULL, "POST");
        $pw = $req->getString("password", NULL, "POST");
        try{
            \Singleton::Session()->login($user,$pw);
            $user = \Singleton::Session()->getUser();
            echo "<pre>";
            print_r($user);
            echo "</pre>";
            //header('Location: '.$newURL);
        }catch(\ModelException $e){         // c-e errore con questo model, che cosa e??
            \Singleton::Session()->logout();
            echo "<pre>";
            echo str_replace("\n", "<br>", $e);
            echo "</pre>";
        }
    }

    public function logout(Request $req){
        \Singleton::Session()->logout();
        echo "logged out";
    }

    public function default(Request $req){
        return $this->login($req);
    }
}
