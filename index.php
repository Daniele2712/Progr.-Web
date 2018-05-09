<?php
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__));
define('EXEC', true);
require_once (ROOT . DS . 'includes' . DS . 'autoload.inc.php');


//test dei modelli
$u = new EUtente("Mario", "Rossi", "+39 328 123456", new DateTime("2004-08-16"));
var_dump($u);
echo "<br><br>";

$c = new EComune("L'Aquila","67028","AQ");
var_dump($c);
echo "<br><br>";

$i = new EIndirizzo($c, "XX Settembre", 4, "interno 8");
var_dump($i);
echo "<br><br>";

$ur = new EUtenteRegistrato("Mario", "Rossi", "+39 328 123456", new DateTime("2004-08-16"),array(),array($i),array(),"rossi@mar.io");
var_dump($ur);
echo "<br><br>";
