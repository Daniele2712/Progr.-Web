<?php
namespace Views;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class Spesa extends HTMLView{
    
    public function __construct(){
    parent::__construct();
    $this->layout = "layout";       // NB se c-era scritto solo $layout = layout, in reala ti creava una nuova variabile , non sovrascriveva va vecchia, che e $this->layout
    $this->content = "spesa";
    $this->addCSS("spesa.css");
   
    $this->smarty->assign('username', 'Marcello');     /* IL tpl profile ha bisogno di una variablile $username*/
    $this->smarty->assign('templateLoginOrProfileIncludes', 'profile.tpl');
    $this->addCSS("profile.css");
    $this->addJS("profile.js");
}
        

    }