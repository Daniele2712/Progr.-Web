<?php
namespace Views;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class V_Home extends HTMLView{
    public function __construct(){
        parent::__construct();
        $this->layout = "layout";
        $this->content = "home/home";
        $this->addJS("home/js/home.js");
        $this->addCSS("home/css/home.css");
        $this->setCSRF(\Singleton::Session()->getCSRF());
        if(\Singleton::Session()->getMessage()){
            $this->smarty->assign('message', \Singleton::Session()->getMessage());
            \Singleton::Session()->setMessage("");
        }
    }
}
