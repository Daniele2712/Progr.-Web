<?php
namespace Models;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class Settings extends Model{
    private static $settings = array();

    public static function getSiteName():string{
        self::loadedCheck();
        return self::$settings["title"];
    }

    public static function getBackground():int{
        self::loadedCheck();
        return self::$settings["background"];
    }

    public static function getArray():array{
        self::loadedCheck();
        $r = array();
        foreach(self::$settings as $k => $v)
            $r[$k] = $v;
        return $r;
    }

    private static function loadedCheck(){
        if(empty(self::$settings))
            \Foundations\Settings::load();
    }

    public static function load(array $data){
        foreach($data as $i => $v)
            self::$settings[$v["k"]] = $v["v"];
    }

    public static function store(){
        if(!is_empty(self::$settings))
            \Foundations\Settings::store(self::getArray());
    }
}
