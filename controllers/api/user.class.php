<?php
namespace Controllers\Api;
use \Controllers\Controller as Controller;
use \Views\Request as Request;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class user implements Controller{
    /*public static function login(Request $req){
        $user = $req->getString("username");
        $pw = $req->getString("password");
        $session = \Singleton::Session();
        try{
            //  controllare se si tratta di un gestore o di un utente 
            $session->login($user,$pw);
            $user = $session->getUser();   // questo e' un MODELS Utente, quindi ha la funzione getId()

            if(is_subclass_of($user, "\\Models\\Dipendente"))
                header('Location: '. '../shop/gestore');
            else header('Location: '."../shop/spesaConLogin");

        }catch(\ModelException $e){         // c-e errore con questo model, che cosa e??
            $session->logout();
            echo "<pre>";
            echo str_replace("\n", "<br>", $e);
            echo "</pre>";
        }
    }*/

    public static function default(Request $req){}
}
