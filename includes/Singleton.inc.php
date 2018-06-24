<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class Singleton{
    private static $DB_handler = null;
    private static $Smarty_Handelr = null;

    public static function DB(){
        if(!self::$DB_handler)
            self::$DB_handler = new FDatabase();
        return self::$DB_handler;
    }

    public static function Smarty(){
        if(!self::$Smarty_Handelr){
            global $config;
            self::$Smarty_Handelr = new Smarty();
            self::$Smarty_Handelr->setTemplateDir($config['smarty']['template_dir']);
            self::$Smarty_Handelr->setCompileDir($config['smarty']['compile_dir']);
            self::$Smarty_Handelr->setConfigDir($config['smarty']['config_dir']);
            self::$Smarty_Handelr->setCacheDir($config['smarty']['cache_dir']);
            self::$Smarty_Handelr->caching = $config['smarty']['caching'];
        }
        return self::$Smarty_Handelr;
    }
}
