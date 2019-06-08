<?php
namespace Controllers\Api;
use \Controllers\Controller as Controller;
use \Controllers\Error as Error;
use \Views\Request as Request;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class C_address implements Controller{

    public static function post(Request $req){
        $cmd = $req->getString("cmd","add","POST");
        if($cmd === "check_id")
            return self::checkId($req);
        elseif($cmd === "check")
            return self::check($req);
        else
            Error::Error400($req);

    }

    public static function default(Request $req){
        self::post($req);
    }

    private static function checkId(Request $req){
        $session = \Singleton::Session();
        if($session->isLogged() && is_a($session->getUser(),"\\Models\\Utenti\\M_UtenteRegistrato")){
            $data = \Models\M_Magazzino::checkUserAddress($req->get(0));
            $v = new \Views\Api\V_CheckAddress(array("r"=>$data["r"]));
            $v->setItems($data["items"]);
            $v->render();
        }else{                                                                  //non autorizzato
            $v = new \Views\JSONView(array("r"=>403));
            $v->render();
        }
    }

    private static function check(Request $req){
        $session = \Singleton::Session();
        if($session->isLogged() && is_a($session->getUser(),"\\Models\\Utenti\\M_UtenteRegistrato") || !$session->isLogged()){
            $data = \Models\M_Magazzino::checkNewAddress($req);
            $v = new \Views\Api\V_CheckAddress(array("r"=>$data["r"]));
            $v->setItems($data["items"]);
            $v->render();
        }else{                                                                  //non autorizzato
            $v = new \Views\JSONView(array("r"=>403));
            $v->render();
        }
    }
}
