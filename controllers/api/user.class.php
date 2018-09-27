<?php
namespace Controllers\Api;
use \Controllers\Controller as Controller;
use \Views\Request as Request;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class user implements Controller{

    public static function get(Request $req){
        $p = $req->getParam(0);
        if($p==="addresses"){
            return self::addresses($req);
        }else
            Error::Error400($request);
    }

    public static function default(Request $req){
        self::get($req);
    }

    private static function addresses(Request $req){
        $session = \Singleton::Session();
        if($session->isLogged()){
            $user = $session->getUser();
            if(is_a($user,"\\Models\\UtenteRegistrato")){
                $v = new \Views\Api\IndirizziUtente(array("r"=>200));
                $v->setIndirizzi($user->getIndirizzi());
                $v->setIndirizzoPreferito($user->getIndirizzoPreferito());
                $v->render();
            }else{
                $v = new \Views\JSONView(array("r"=>403));
                $v->render();
            }
        }else{
            $v = new \Views\JSONView(array("r"=>403));
            $v->render();
        }
    }
}