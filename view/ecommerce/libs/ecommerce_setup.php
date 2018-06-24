<?php


require(ECOMMERCE_DIR . 'libs/ecommerce.lib.php');
require(SMARTY_DIR . 'Smarty.class.php');

// smarty configuration
// questa classe fa tipo un istanza di smarty e le dice dove sono le cartelle che le
//  servono. In particolare
//  In templates metteremo i template
//  In templates_c saranno messi i template compilati. Non dobbiamo toccare questa cartella, qui mette mano solo smarty
//  In configs ci saranno delle variabili globali che potrebbero servire a smarty
//  In cache ci saranno ....bho...cose in cache...?
class Ecommerce_Smarty extends Smarty {
    function __construct() {
      parent::__construct();
      $this->setTemplateDir(ECOMMERCE_DIR . 'templates');
      $this->setCompileDir(ECOMMERCE_DIR . 'templates_c');
      $this->setConfigDir(ECOMMERCE_DIR . 'configs');
      $this->setCacheDir(ECOMMERCE_DIR . 'cache');
      
      // tutte ste cose, fanno parte della classe Smary e sono ereditate, non importa cosa fanno....la
      // cosa che c'e da sapere e' che smarty ha bisogno di questi 4 file x funzionare...tutto qui...
    }
}
      
?>
