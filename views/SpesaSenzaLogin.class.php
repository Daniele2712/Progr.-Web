<?php
namespace Views;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class SpesaSenzaLogin extends HTMLView{
    public function __construct(){
        parent::__construct();
        $this->layout = "layout";
        $this->content = "spesa/spesa";
        $this->addCSS("spesa/css/spesa.css");
        $this->addJS("spesa/js/spesa.js");
        $this->setCSRF(\Singleton::Session()->getCSRF());
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

    public function totalBasket($totalPrice){
         $this->smarty->assign('total_for_carrello' , $totalPrice);
    }


}
