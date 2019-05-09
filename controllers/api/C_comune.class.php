<?php
namespace Controllers\Api;
use \Controllers\Controller as Controller;
use \Views\Request as Request;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class C_comune implements Controller{
    public static function get(Request $req){
        echo $req->getInt(0);
    }

    public static function search(Request $req){
        $search = $req->getString(0);
        $comuni = \Foundations\F_Comune::searchByName($search);
        $v = new \Views\Api\V_Comuni();
        $v->setComuni($comuni);
        $v->render();
    }

    /**
     * azione di default
     */
    public static function default(Request $req){
        return self::get($req);
    }
}
