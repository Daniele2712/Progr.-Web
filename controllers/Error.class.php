<?php
namespace Controllers;
use \Views\Request as Request;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class Error implements Controller{
    public function Error404(Request $req){
        $v = new \Views\Error();
        $v->isRest($req->isRest());
        $v->error(404);
        die();
    }

    public function Error405(Request $req){
        $v = new \Views\Error();
        $v->isRest($req->isRest());
        $v->error(405);
        die();
    }

    public function ErrorController(Request $req){
        $v = new \Views\Error();
        $v->isRest($req->isRest());
        $v->error(404, "Controller Not Found");
        die();
    }

    public function ErrorAction(Request $req){
        $v = new \Views\Error();
        $v->isRest($req->isRest());
        $v->error(404, "Action Not Found");
        die();
    }

    /**
     * Errore generico
     */
    public function ErrorUnknown(Request $req){
        $v = new \Views\Error();
        $v->isRest($req->isRest());
        $v->error(500, "Uknown Server Error");
        die();
    }

    /**
     * azione di default
     */
    public function default(Request $req){
        return $this->ErrorUnknown($req);
    }
}
