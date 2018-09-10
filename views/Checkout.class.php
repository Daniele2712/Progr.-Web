<?php
namespace Views;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class Checkout extends HTMLView{
    public function __construct(){
        parent::__construct();
        $this->layout = "layout";       // NB se c-era scritto solo $layout = layout, in reala ti creava una nuova variabile , non sovrascriveva va vecchia, che e $this->layout
        $this->content = "checkout/checkout";
        $this->addCSS("checkout/css/checkout.css");
        $this->addJS("checkout/js/checkout.js");
        

        $this->smarty->assign('username', 'Marcello');     /* IL tpl profile ha bisogno di una variablile $username*/
        $this->smarty->assign('templateLoginOrProfileIncludes', 'profile/profile.tpl');
        $this->addCSS("profile/css/profile.css");
        $this->addJS("profile/js/profile.js");
     
    }
}
    