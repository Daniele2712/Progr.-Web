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
            $user = \Singleton::Session()->getUser();
            echo "<pre> kkk";
            echo var_dump($req);
            print_r($user);
            echo "</pre>";
            echo "e da qui in poi ti do la pagina di spesa";
            
            //header('Location: '.$newURL);
        }catch(\ModelException $e){         // c-e errore con questo model, che cosa e??
            echo "NADAAAA";
            echo "asddasd";
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
