<?php
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__));
define('EXEC', true);
require_once(ROOT.DS.'includes'.DS.'config.inc.php');
require_once(ROOT.DS.'includes'.DS.'autoload.inc.php');
 $results = Singleton::DB()->query("SELECT nome, padre FROM prova");
 if($results){
   $row=$result->fetch_array();
   var_dump($row);
 }
?>
