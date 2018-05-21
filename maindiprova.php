<?php
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__));
define('EXEC', true);
require_once(ROOT.DS.'includes'.DS.'config.inc.php');
require_once(ROOT.DS.'includes'.DS.'autoload.inc.php');
$t=new FDatabase();
$results = $t->query("SELECT nome, padre FROM prova WHERE id=2");
$row = $results->fetch_array(MYSQLI_ASSOC);
print_r($row);
?>
