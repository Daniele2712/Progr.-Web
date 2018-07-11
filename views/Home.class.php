<?php
namespace Views;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class Home extends HTMLView{

    public function __construct(){
    parent::__construct();
    $this->layout = "layout";
    $this->content = "home";
    $this->addCSS("home.css");
    
    $this->smarty->assign('templateLoginOrProfileIncludes', 'login.tpl');
    $this->addCSS("login.css");
    $this->addJS("login.js");
    
    }
}
