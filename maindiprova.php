<?php
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__));
define('EXEC', true);
require_once(ROOT.DS.'includes'.DS.'config.inc.php');
require_once(ROOT.DS.'includes'.DS.'autoload.inc.php');
//$cat=array();
//$cat=FCategoria::getCategoriaByid(3);
//print_r($cat);
//$pro=array();
//$pro=FProdotto::getProdottoByid(1);
//print_r($pro);
//$it=array();
//$it=FItem::getCarrelloItems(1);
//print_r($it);
//$car=array();
//$car=FCarrello::all();
//print_r($car);
//$com=array();
//$com=FComune::getComuneByid(1);
//print_r($com);
$ind=array();
$ind=FIndirizzo::getIndirizzoByid(1);
print_r($ind);
?>
