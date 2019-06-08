<?php
namespace Install\Controllers\Api;
use \Views\Request as Request;
use \Controllers\Controller as Controller;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class C_install implements Controller{
    public static function post(Request $req){

    }

    public static function default(Request $req){
        return self::post($req);
    }
}
