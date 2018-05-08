<?php
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__));
define('EXEC', true);
require_once (ROOT . DS . 'includes' . DS . 'autoload.inc.php');


//test del modello
$u = new EUtente("Mario", "Rossi", "+39 328 123456", new DateTime("2004-08-16"));
var_dump($u);
