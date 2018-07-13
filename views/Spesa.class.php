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
        $this->content = "spesa/spesa";
        $this->addCSS("spesa/css/spesa.css");
        $this->addJS("spesa/js/spesa.js");
        

        $this->smarty->assign('username', 'Marcello');     /* IL tpl profile ha bisogno di una variablile $username*/
        $this->smarty->assign('templateLoginOrProfileIncludes', 'profile/profile.tpl');
        $this->addCSS("profile/css/profile.css");
        $this->addJS("profile/js/profile.js");
    }
    
    public function fillCategories($categories){
         $this->smarty->assign('categorie_for_tpl' , $categories);
    }
    
    public function fillFilters($filters){
         $this->smarty->assign('categorie_for_tpl' , $categories);
    }
    
    public function fillItems($items){
         $this->smarty->assign('items_for_tpl' , $items);
    }
    public function fillBasket($itemsBasket){
         $this->smarty->assign('prodotti_for_carello' , $itemsBasket);
    }
    
    
}
