<?php
namespace Views;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class HTTPView{
    public static function redirect(string $url){
        header("location: ".$url);
        die();
    }

    public static function Ok(){
        header("HTTP/1.1 200 OK");
    }
}
