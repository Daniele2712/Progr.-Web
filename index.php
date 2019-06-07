<?php
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__));
define('EXEC', true);
require_once(ROOT.DS.'includes'.DS.'config.inc.php');
require_once(ROOT.DS.'includes'.DS.'autoload.inc.php');
Controllers\FrontController::route(new Views\Request());
/*
$prodottoA=\Foundations\Prodotto::find(1);
$prodottoB=\Foundations\Prodotto::find(2);
$itemA= new \Models\Item($prodottoA,NULL, 3);
$itemB= new \Models\Item($prodottoB,NULL, 15);
$items[]=$itemA;
$items[]=$itemB;
$indirizzo=\Foundations\Indirizzo::find(1);
$datiAna=\Foundations\DatiAnagrafici::find(1);
$ordine=new \Models\Ordine($items, $indirizzo, $datiAna);

ob_start();
var_dump($indirizzo);
$result=ob_get_content();
ob_end_clean();
$a=var_dump($ordine);


$ord=\Foundations\Ordine::find(1);
echo \Foundations\Ordine::orderToJson($ord);
 */
//$res=\Foundations\Ordine::itemsOfOrderJson(1);

//var_dump(\Foundations\Ordine::codeExists(111));
//var_dump(\Foundations\Indirizzo::getIndirizziByUserIdFull(1));
