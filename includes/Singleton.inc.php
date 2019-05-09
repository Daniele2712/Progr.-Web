<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class Singleton{
    private static $DB_handler = null;
    private static $smarty_handler = null;
    private static $session_handler = null;
    private static $settings_handler = null;

    public static function DB() : \Foundations\Database{
        if(!self::$DB_handler)
            self::$DB_handler = new Foundations\Database();
        return self::$DB_handler;
    }

    public static function Smarty(){
        if(!self::$smarty_handler){
            global $config;
            self::$smarty_handler = new Smarty();
            self::$smarty_handler->setTemplateDir($config['smarty']['template_dir']);
            self::$smarty_handler->setCompileDir($config['smarty']['compile_dir']);
            self::$smarty_handler->setConfigDir($config['smarty']['config_dir']);
            self::$smarty_handler->setCacheDir($config['smarty']['cache_dir']);
            self::$smarty_handler->caching = $config['smarty']['caching'];
        }
        return self::$smarty_handler;
    }

    public static function Session() : \Foundations\Session {
        if(!self::$session_handler)
            self::$session_handler = new \Foundations\Session();
        return self::$session_handler;
    }

    public static function Settings(){
        if(!self::$settings_handler)
            self::$settings_handler = new \Models\M_Settings();
        return self::$settings_handler;
    }
}
