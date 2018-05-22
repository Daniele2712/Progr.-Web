<?php
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__));
define('EXEC', true);
require_once(ROOT.DS.'includes'.DS.'config.inc.php');
require_once(ROOT.DS.'includes'.DS.'autoload.inc.php');
//$cat=array();
//$cat=FCategoria::getCategoriaByid(3);
//print_r($cat);
$pre=new EMoney(1.90, 'EUR');
print_r($pre);
$it=array();
$it=FItem::getCarrelloItems(1);
print_r($it);
//$car=array();
//$car=FCarrello::all();
//print_r($car);
?>
