<?php
namespace Controllers;
use \Views\Request as Request;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class checkout implements Controller{

public static function displayCheckout(Request $req){
        $v = new \Views\Checkout();
        $v->render();
    }

 public static function default(Request $req){
     echo "azione di defaiult del controllore checkout";
 }
}


?>
