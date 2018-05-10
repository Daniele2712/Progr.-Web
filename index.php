<?php
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__));
define('EXEC', true);
require_once(ROOT.DS.'includes'.DS.'autoload.inc.php');
//test dei modelli
$ut = new EUtente("Mario", "Rossi", "+39 328 123456", new DateTime("2004-08-16"));
var_dump($ut);
echo "<br><br>";
$com = new EComune("L'Aquila",67100,"AQ");
var_dump($com);
echo "<br><br>";
$ind = new EIndirizzo($com, "via XX Settembre", 4, "interno 8");
var_dump($ind);
echo "<br><br>";
$ut_r = new EUtenteRegistrato("Mario", "Rossi", "+39 328 123456", new DateTime("2004-08-16"),array(),array($ind),array(),"rossi@mar.io");
var_dump($ut_r);
echo "<br><br>";
$ges = new EGestore("Mario", "Rossi", "+39 328 123456", new DateTime("2004-08-16"));
var_dump($ges);
echo "<br><br>";
$mag = new EMagazzino(new EIndirizzo(new EComune("San Demetrio ne'Vestini",67028,"AQ"), "via Verdi", 1));
var_dump($mag);
echo "<br><br>";
$car = new ECarrello('123456');
var_dump($car);
echo "<br><br>";
$fil = new EFiltro('Display', 'Elettronica', 'Computer');
var_dump($fil);
echo "<br><br>";

?>
