<?php
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__));
define('EXEC', true);
require_once(ROOT.DS.'includes'.DS.'autoload.inc.php');
//test dei modelli
$utente = new EUtente("Mario", "Rossi", "+39 328 123456", new DateTime("2004-08-16"));
var_dump($utente);
echo "<br><br>";
$comune = new EComune("L'Aquila",67100,"AQ");
var_dump($comune);
echo "<br><br>";
$indirizzo = new EIndirizzo($comune, "via XX Settembre", 4, "interno 8");
var_dump($indirizzo);
echo "<br><br>";
$utente_reg = new EUtenteRegistrato("Mario", "Rossi", "+39 328 123456", new DateTime("2004-08-16"),array(),array($indirizzo),array(),"rossi@mar.io");
var_dump($utente_reg);
echo "<br><br>";
$gestore = new EGestore("Mario", "Rossi", "+39 328 123456", new DateTime("2004-08-16"));
var_dump($gestore);
echo "<br><br>";
$magazzino = new EMagazzino(new EIndirizzo(new EComune("San Demetrio ne'Vestini",67028,"AQ"), "via Verdi", 1));
var_dump($magazzino);
echo "<br><br>";
$prezzo = new EMoney(0,'Euro');
var_dump($prezzo);
echo "<br><br>";
$carrello = new ECarrello('123456');
var_dump($carrello);
echo "<br><br>";
$categoria = new ECategoria('Elettronica');
var_dump($categoria);
echo "<br><br>";
$prodotto = new EProdotto('macbook', $categoria, $prezzo);
var_dump($prodotto);
echo "<br><br>";
?>