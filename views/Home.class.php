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
        $this->content = "home/home";
        $this->addJS("home/js/home.js");
        $this->addCSS("home/css/home.css");
    }
}
