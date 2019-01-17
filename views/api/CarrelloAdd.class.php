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
class CarrelloAdd extends JSONView{
    public function setCart(\Models\Carrello $carrello, \Models\Money $valuta){
        foreach($carrello->getItems() as $item){
            $this->data["carrello"]["items"][] = array(
                "nome"=>$item->getProdotto()->getNome(),
                "quantita"=>$item->getQuantita(),
                "prezzo"=>$item->getTotale()->getPrezzo($valuta));
        }
        $this->data["carrello"]["valuta"] = $valuta->getValutaSymbol();
        $this->data["carrello"]["totale"] = $carrello->getTotale()->getPrezzo();
    }

    public function setCSRF(string $token){
        $this->data["CSRF"] = $token;
    }
}
