<?php

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', "/var/www/html/Progr.-Web/");
define('EXEC', true);
define('ECOMMERCE_DIR', '../ecommerce/');
define('SMARTY_DIR', '../smarty-3.1.32/libs/');

require_once(ROOT.DS.'includes'.DS.'config.inc.php');
require_once(ROOT.DS.'includes'.DS.'autoload.inc.php');
// include the setup script
include(ECOMMERCE_DIR . 'libs/ecommerce_setup.php');

// create guestbook object
$ecommerce = new Ecommerce;

// set the current action
$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';

// In base al parametro che passi nel url, puoi fare diverse cose:

switch($_action) {
    
    case 'spesaSenzaLogin':
       
        $arrayDiProdotti= $ecommerce->getArrayDiProdotti();
        //l-Array di prodotti che mi ritorna, e' fatto da tanti item quanti gli item del negozio
        // e ogni item del array a sua volta e un oggetto con tante coppie attributo valre
        // quante sono le colonne della tabella (le attributi sono i nomi delle colonne)
        $ecommerce->displaySpesa($arrayDiProdotti);
        break;
    
    case 'spesaConLogin':
        $ecommerce->displaySpesa();
        break;
    
    case 'submit':
        echo("non dovrei arrivare qui");
        // submitting a guestbook entry
        $guestbook->mungeFormData($_POST);
        if($guestbook->isValidForm($_POST)) {
            $guestbook->addEntry($_POST);
            $guestbook->displayBook($guestbook->getEntries());
        } else {
             echo var_dump($_POST);
            $guestbook->displayForm($_POST);
           
        }
        break;
        
    case 'view':
    default:
        // mostra la pagina iniziale
        $ecommerce->displayMainPage();        
        break;   
}

?>
