<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class VSpesa extends HTMLView{
    protected $layout = "spesa";

    public function HTMLRender(){
    }

    public function setSpesa($prodotti=array()){
        $this->smarty->assign('prodotti_for_tpl', $prodotti);
    }
}
