<?php
namespace Views\Api;
use \Views\JSONView as JSONView;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

/**
 * View che mostra un elenco di comuni
 */
class Comuni extends JSONView{
    public function setComuni(array $comuni){
        foreach($comuni as $comune){
            $this->data[] = array("label"=>$comune->getNome()."(".$comune->getProvincia().")","value"=>$comune->getId());
        }
    }
}
