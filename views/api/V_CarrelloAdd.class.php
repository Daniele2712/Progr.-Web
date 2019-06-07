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
class V_CarrelloAdd extends JSONView{
    public function setCart(\Models\M_Carrello $carrello, \Models\M_Money $valuta){
        foreach($carrello->getItems() as $item){
            $this->data["carrello"]["items"][] = array(
                "nome"=>$item->getProdotto()->getNome(),
                "quantita"=>$item->getQuantita(),
                "prezzo"=>number_format($item->getTotale()->getPrezzo($valuta), 2));
        }
        $this->data["carrello"]["valuta"] = $valuta->getValutaSymbol();
        $this->data["carrello"]["totale"] = number_format($carrello->getTotale()->getPrezzo(), 2);
    }

    public function setCSRF(string $token){
        $this->data["CSRF"] = $token;
    }
}
