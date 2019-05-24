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
class V_Carrello extends JSONView{
    public function setCart(\Models\M_Carrello $carrello, \Models\M_Money $valuta){
        foreach($carrello->getItems() as $item){
            $this->data["items"][] = array(
                "id"=>$item->getProdotto()->getId(),
                "nome"=>$item->getProdotto()->getNome(),
                "quantita"=>$item->getQuantita(),
                "prezzo"=>$item->getTotale()->getPrezzo($valuta));
        }
        $this->data["valuta"] = $valuta->getValutaSymbol();
        $this->data["totale"] = $carrello->getTotale()->getPrezzo();
    }
}
