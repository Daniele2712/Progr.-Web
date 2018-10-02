<?php
namespace Controllers\Api;
use \Controllers\Controller as Controller;
use \Views\Request as Request;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class carrello implements Controller{
    public static function get(Request $req){
        $session = \Singleton::Session();
        if($session->isLogged() && is_a($session->getUser(),"\\Models\\UtenteRegistrato") || !$session->isLogged()){
            $v = new \Views\Api\Carrello(array("r"=>200));
            $v->setCart($session->getCart(),$session->getUser());
            $v->render();
        }else{                                                      //non autorizzato
            $v = new \Views\JSONView(array("r"=>403));
            $v->render();
        }
    }

    public static function post(Request $req){
        $p = $req->getParam(0);
        if($p === "address")
            return self::address($req);
        else
            Error::Error400($request);

    }

    public static function default(Request $req){
        self::get($req);
    }

    private static function address(Request $req){
        $session = \Singleton::Session();
        if(!$session->checkCSRF($req->getCSRF())){
            $v = new \Views\JSONView(array("r"=>410));                  //Token non valido
            return $v->render();
        }
        if($session->isLogged()){
            $user = $session->getUser();
            if(is_a($user,"\\Models\\UtenteRegistrato")){
                if($req->getParam(1)==="add"){
                    $id_comune = $req->getInt("comuneId",0,"POST");
                    $via = $req->getString("via","","POST");
                    $civico = $req->getString("civico","","POST");
                    $note = $req->getString("note","","POST");
                    try{
                        $user->setNewCartAddress($id_comune,$via,$civico,$note);
                    }catch(\ModelException $e){
                        if($e->getCode()===2){                                  //indirizzo errato
                            $v = new \Views\JSONView(array("r"=>404));
                            $v->render();
                        }else
                            throw $e;
                    }
                }else{
                    try{
                        $user->setCartAddress($req->getParam(1));
                    }catch(\ModelException $e){
                        $v = new \Views\JSONView(array("r"=>403));          //Id indirizzo non valido
                        $v->render();
                    }
                }
                $v = new \Views\JSONView(array("r"=>200));
                $v->render();
            }else{                                                      //Utente non valido
                $v = new \Views\JSONView(array("r"=>403));
                $v->render();
            }
        }else{                                                          //Visitatore
            $id_comune = $req->getInt("comuneId",0,"POST");
            $via = $req->getString("via","","POST");
            $civico = $req->getString("civico","","POST");
            $note = $req->getString("note","","POST");
            try{
                $session->setGuestAddress($id_comune, $via, $civico, $note);
            }catch(\ModelException $e){
                if($e->getCode()===2){                                  //indirizzo errato
                    $v = new \Views\JSONView(array("r"=>404));
                    $v->render();
                }else
                    throw $e;
            }
            $v = new \Views\JSONView(array("r"=>200));
            $v->render();
        }
    }
}
