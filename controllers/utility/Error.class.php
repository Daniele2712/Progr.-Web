<?php
namespace Controllers;
use \Views\Request as Request;
use \Exception as Exception;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class Error implements Controller{
    public static function Error400(Request $req){
        $v = new \Views\Error();
        if(!$req->isRest()){
            $session = \Singleton::Session();
            if($session->isLogged())
                $v->setUser($session->getUser());
        }
        $v->isRest($req->isRest());
        $v->error(400);
        die();
    }

    public static function Error404(Request $req){
        $v = new \Views\Error();
        if(!$req->isRest()){
            $session = \Singleton::Session();
            if($session->isLogged())
                $v->setUser($session->getUser());
        }
        $v->isRest($req->isRest());
        $v->error(404);
        die();
    }

    public static function Error405(Request $req){
        $v = new \Views\Error();
        if(!$req->isRest()){
            $session = \Singleton::Session();
            if($session->isLogged())
                $v->setUser($session->getUser());
        }
        $v->isRest($req->isRest());
        $v->error(405);
        die();
    }

    public static function Error410(Request $req){
        $v = new \Views\Error();
        if(!$req->isRest()){
            $session = \Singleton::Session();
            if($session->isLogged())
                $v->setUser($session->getUser());
        }
        $v->isRest($req->isRest());
        $v->error(410);
        die();
    }

    public static function ErrorController(Request $req){
        $v = new \Views\Error();
        if(!$req->isRest()){
            $session = \Singleton::Session();
            if($session->isLogged())
                $v->setUser($session->getUser());
        }
        $v->isRest($req->isRest());
        $v->error(404, "Controller Not Found");
        die();
    }

    public static function ErrorAction(Request $req){
        $v = new \Views\Error();
        if(!$req->isRest()){
            $session = \Singleton::Session();
            if($session->isLogged())
                $v->setUser($session->getUser());
        }
        $v->isRest($req->isRest());
        $v->error(404, "Action Not Found");
        die();
    }

    /**
     * Errore generico
     */
    public static function ErrorUnknown(Request $req){
        $v = new \Views\Error();
        if(!$req->isRest()){
            $session = \Singleton::Session();
            if($session->isLogged())
                $v->setUser($session->getUser());
        }
        $v->isRest($req->isRest());
        $v->error(500, "Uknown Server Error");
        die();
    }

    /**
     * Errore eccezione non gestita
     */
    public static function ErrorException(Request $req, Exception $e){
        $v = new \Views\Error();
        if(!$req->isRest()){
            $session = \Singleton::Session();
            if($session->isLogged())
                $v->setUser($session->getUser());
        }
        $v->isRest($req->isRest());
        $message = "PHP Fatal error<br/>".$e->getMessage();
        global $config;
        if($config['debug'])
            //$message .= "<pre>".$e->getTrace()."</pre>";
            $message = "PHP Fatal error: {$e->getMessage()}<br/>{$e->getFile()}({$e->getLine()})<br/>" . "<pre>{$e->getTraceAsString()}</pre>";
        $v->error(500, $message);
        die();
    }

    /**
     * azione di default
     */
    public static function default(Request $req){
        return self::ErrorUnknown($req);
    }
}
