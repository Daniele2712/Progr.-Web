<?php
namespace Foundations;
use \Models\Model as Model;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

abstract class Settings extends Foundation{
    protected static $table = "settings";
    protected static $ID = array("name"=>"k","type"=>"s");

    public static function store(array $obj){
        foreach($obj as $k => $v){
            //TODO: update settings
        }
    }
}
