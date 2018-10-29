<?php
namespace Views;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class Ordini extends HTMLView{
    public function __construct(){
        parent::__construct();
        $this->layout = "layout";
        $this->content = "ordini/ordini";
        $this->addJS("ordini/js/ordini.js");
        $this->addCSS("ordini/css/ordini.css");
        $this->setCSRF(\Singleton::Session()->getCSRF());   //A: non so ancora se serve
    }
    public function fillOrdini($arrayOrdini){
         $this->smarty->assign('arrayOrdini' , $arrayOrdini);
    }
    
    public function utenteNonRegistrato(){
         $this->smarty->assign('registrato' , 'false');
    }
    public function utenteRegistrato(){
         $this->smarty->assign('registrato' , 'true');
    }
    
    
}