<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

abstract class HTMLView implements View{
    private $smarty;
    protected $layout;

    public function __contruct(){
        $this->smarty = Singleton::Smarty();
    }

    public funtion Render(){
        $this->smarty->display($layout.".tpl");
    }

    public function HTMLRender();
}
