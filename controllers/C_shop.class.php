<?php
namespace Controllers;
use \Views\Request as Request;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class C_shop{
    public static function home(Request $req){
        $v = new \Views\Home();
        $v->render();
    }

    public static function gestore(Request $req){

         $session = \Singleton::Session();
            if($session->isLogged())            //nel caso l-utente abbia digitato direttamente l-indirizzo senza essersi loggato, lo mando alla home
            {
                $v = new \Views\Gestore();
                $v->setUser();
                $v->render();
            }
            else header('Location: '."http://".$req->getServerName());
    }

    public static function amministratore(Request $req){

         $session = \Singleton::Session();
            if($session->isLogged())            //nel caso l-utente abbia digitato direttamente l-indirizzo senza essersi loggato, lo mando alla home
            {
                $v = new \Views\Amministratore();
                $v->setUser();
                $v->render();
            }
            else header('Location: '."http://".$req->getServerName());
    }


    public static function default(Request $req){
        return self::home($req);
    }
}
