<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

abstract class HTMLView implements View{
    protected $smarty;

    public function __construct(){
        $this->smarty = Singleton::Smarty();
    }

    public function render(){
        $this->smarty->display("layout.tpl");
    }
    

    public abstract function HTMLRender();
}
