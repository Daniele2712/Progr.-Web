<?php
namespace Install\Views;
use \Views\HTMLView as HTMLView;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class V_Welcome extends HTMLView{
    public function __construct(){
        parent::__construct();
        $this->layout = "layout";
        $this->content = "../../install/template/contents/install/install";
        $this->addCSS("install/css/install.css");
        $this->addJS("install/js/install.js");
        $this->setCSRF(\Singleton::Session()->getCSRF());
    }
}
