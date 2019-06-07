<?php
namespace Views\Api;
use \Views\JSONView as JSONView;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class V_CheckAddress extends JSONView{
    public function setItems(array $items){
        $this->data["items"] = array();
        foreach($items as $item){
            $this->data["items"][] = array("name"=>$item->getProdotto()->getNome(), "qta"=>$item->getQuantita());
        }
    }
}
