<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

spl_autoload_register(function ($className) {
    if (file_exists(ROOT . DS . 'includes' . DS . $className . '.inc.php'))
        require_once(ROOT . DS . 'includes' . DS . $className . '.inc.php');
    if (file_exists(ROOT . DS . 'libs' . DS . strtolower($className) . DS . $className . '.class.php'))
        require_once(ROOT . DS . 'libs' . DS . strtolower($className) . DS . $className . '.class.php');
    else if (file_exists(ROOT . DS . 'controllers' . DS . "utility" . DS . $className . '.class.php'))
        require_once(ROOT . DS . 'controllers' . DS . "utility" . DS . $className . '.class.php');
    else if (file_exists(ROOT . DS . 'controllers' . DS . $className . '.class.php'))
        require_once(ROOT . DS . 'controllers' . DS . $className . '.class.php');
    else if (file_exists(ROOT . DS . 'views' . DS . "utility" . DS . $className . '.class.php'))
        require_once(ROOT . DS . 'views' . DS . "utility" . DS . $className . '.class.php');
    else if (file_exists(ROOT . DS . 'views' . DS . $className . '.class.php'))
        require_once(ROOT . DS . 'views' . DS . $className . '.class.php');
    else if (file_exists(ROOT . DS . 'models' . DS . $className . '.class.php'))
        require_once(ROOT . DS . 'models' . DS . $className . '.class.php');
    else if (file_exists(ROOT . DS . 'foundations' . DS . "utility" . DS . $className . '.class.php'))
        require_once(ROOT . DS . 'foundations' . DS . "utility" . DS . $className . '.class.php');
    else if (file_exists(ROOT . DS . 'foundation' . DS . $className . '.class.php'))
        require_once(ROOT . DS . 'foundation' . DS . $className . '.class.php');
});
