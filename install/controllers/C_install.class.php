<?php
namespace Install\Controllers;
use \Views\Request as Request;
use \Install\Views as Views;
use \Controllers\Controller as Controller;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class C_install implements Controller{
    public static function welcome(Request $req){
        $v = new Views\V_Welcome();
        $v->render();
    }

    public static function default(Request $req){
        return self::welcome($req);
    }

}
