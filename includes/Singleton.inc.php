<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class Singleton{
    private static $DB_handler = null;
    private static $smarty_handelr = null;
    private static $session_handelr = null;

    public static function DB(){
        if(!self::$DB_handler)
            self::$DB_handler = new FDatabase();
        return self::$DB_handler;
    }

    public static function Smarty(){
        if(!self::$smarty_handelr){
            global $config;
            self::$smarty_handelr = new Smarty();
            self::$smarty_handelr->setTemplateDir($config['smarty']['template_dir']);
            self::$smarty_handelr->setCompileDir($config['smarty']['compile_dir']);
            self::$smarty_handelr->setConfigDir($config['smarty']['config_dir']);
            self::$smarty_handelr->setCacheDir($config['smarty']['cache_dir']);
            self::$smarty_handelr->caching = $config['smarty']['caching'];
        }
        return self::$smarty_handelr;
    }

    public static function Session(){
        if(!self::$session_handelr)
            self::$session_handelr = new FSession();
        return self::$session_handelr;
    }
}
