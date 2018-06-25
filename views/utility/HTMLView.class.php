<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

abstract class HTMLView implements View{
    protected $smarty;
    protected $layout = "default";

    public function __construct(){
        $this->smarty = Singleton::Smarty();
    }

    public function render(){
        $this->smarty->display($this->layout.".tpl");
    }

    public abstract function HTMLRender();
}
