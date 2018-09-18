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

    public static function load(){
        $DB = \Singleton::DB();
        $sql = "SELECT * FROM ".self::$table;
        $res = $DB->query($sql);
        $r = array();
        while($row = $res->fetch_assoc())
            $r[] = $row;
        \Models\Settings::load($r);
    }

    public static function store(array $obj){
        foreach($obj as $k => $v){

        }
    }
}
