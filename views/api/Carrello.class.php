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
class Carrello extends JSONView{
    public function setCart(\Models\Carrello $carrello, \Models\Utente $user){
        $idValuta = $user->getIdValuta();
        foreach($carrello->getItems() as $item){
            $this->data["items"][] = array(
                "nome"=>$item->getProdotto()->getNome(),
                "quantita"=>$item->getQuantita(),
                "prezzo"=>$item->getTotale()->getPrezzo($idValuta));
        }
        $this->data["valuta"] = \Models\Money::findValutaSymbol($idValuta);
        $this->data["totale"] = $carrello->getTotale()->getPrezzo();
    }
}
