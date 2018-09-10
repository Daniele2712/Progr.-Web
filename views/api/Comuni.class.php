<?php
namespace Views\Api;
use \Views\View as View;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

/**
 * View che mostra un elenco di comuni
 */
class Comuni implements View{

    private $data = array();

    public function setComuni(array $comuni){
        foreach($comuni as $comune){
            $this->data[] = array("label"=>$comune->getNome()."(".$comune->getProvincia().")","value"=>$comune->getId());
        }
    }

    public function render(){
        echo json_encode($this->data);
    }
}
