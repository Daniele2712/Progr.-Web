<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

spl_autoload_register(function ($fullClassName){
    $class = explode("\\", $fullClassName);
    $className = array_pop($class);
    $path = count($class)?strtolower(join(DS, $class)) . DS : '';
    //echo $path . $className."<br>";
    if (file_exists(ROOT . DS . 'includes' . DS . $className . '.inc.php'))
        require_once(ROOT . DS . 'includes' . DS . $className . '.inc.php');
    elseif (file_exists(ROOT . DS . 'libs' . DS . strtolower($className) . DS . $className . '.class.php'))
        require_once(ROOT . DS . 'libs' . DS . strtolower($className) . DS . $className . '.class.php');
    elseif (file_exists(ROOT . DS . $path . "utility" . DS . $className . '.class.php'))
        require_once(ROOT . DS . $path . "utility" . DS . $className . '.class.php');
    elseif (file_exists(ROOT . DS . $path . $className . '.class.php'))
        require_once(ROOT . DS . $path . $className . '.class.php');
    /*elseif (file_exists(ROOT . DS . 'controllers' . DS . "utility" . DS . $className . '.class.php'))
        require_once(ROOT . DS . 'controllers' . DS . "utility" . DS . $className . '.class.php');
    elseif (file_exists(ROOT . DS . 'controllers' . DS . $className . '.class.php'))
        require_once(ROOT . DS . 'controllers' . DS . $className . '.class.php');
    elseif (file_exists(ROOT . DS . 'views' . DS . "utility" . DS . $className . '.class.php'))
        require_once(ROOT . DS . 'views' . DS . "utility" . DS . $className . '.class.php');
    elseif (file_exists(ROOT . DS . 'views' . DS . $className . '.class.php'))
        require_once(ROOT . DS . 'views' . DS . $className . '.class.php');
    elseif (file_exists(ROOT . DS . 'models' . DS . "utility" . DS . $className . '.class.php'))
        require_once(ROOT . DS . 'models' . DS . "utility" . DS . $className . '.class.php');
    elseif (file_exists(ROOT . DS . 'models' . DS . $className . '.class.php'))
        require_once(ROOT . DS . 'models' . DS . $className . '.class.php');
    elseif (file_exists(ROOT . DS . 'foundations' . DS . "utility" . DS . $className . '.class.php'))
        require_once(ROOT . DS . 'foundations' . DS . "utility" . DS . $className . '.class.php');
    elseif (file_exists(ROOT . DS . 'foundations' . DS . $className . '.class.php'))
        require_once(ROOT . DS . 'foundations' . DS . $className . '.class.php');*/
});
