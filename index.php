<?php
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__));
define('EXEC', true);
require_once(ROOT.DS.'includes'.DS.'config.inc.php');
require_once(ROOT.DS.'includes'.DS.'autoload.inc.php');
//test dei modelli
var_dump(FOfferta::find(1));
