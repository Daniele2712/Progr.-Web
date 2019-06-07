<?php
namespace Controllers\Api;
use \Controllers\Controller as Controller;
use \Views\Request as Request;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class C_paypal implements Controller{

    public static function post(Request $req){
        if(\Models\Pagamenti\M_PayPal::verifyIPN($req)){
            echo "ok";
        }
        \Views\HTTPView::Ok();
    }

    public static function default(Request $req){
        self::post($req);
    }
}
