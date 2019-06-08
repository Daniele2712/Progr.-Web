<?php
namespace Views;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class V_OrderGreetings extends HTMLView{
    public function __construct(){
        parent::__construct();
        $this->layout = "layout";
        $this->content = "greetings/greetings";
        $this->addCSS("greetings/css/greetings.css");
        $this->setCSRF(\Singleton::Session()->getCSRF());
    }

    public function setOrder(\Models\M_Ordine $ordine){
        $this->smarty->assign('link', $ordine->getLink());
    }
}
