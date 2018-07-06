<?php
namespace Views;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class Spesa extends HTMLView{
    protected $layout = "spesa";

    public function setSpesa($prodotti=array()){
        $this->smarty->assign('prodotti_for_tpl', $prodotti);
    }
}
