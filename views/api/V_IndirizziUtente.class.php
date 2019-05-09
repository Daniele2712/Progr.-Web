<?php
namespace Views\Api;
use \Views\JSONView as JSONView;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class V_IndirizziUtente extends JSONView{
    public function setIndirizzi(array $indirizzi){
        foreach($indirizzi as $indirizzo){
            $this->data["indirizzi"][] = $this->addr($indirizzo);
        }
    }

    public function setIndirizzoPreferito(\Models\M_Indirizzo $preferito){
        $this->data["preferito"] = $this->addr($preferito);
    }

    private function addr(\Models\M_Indirizzo $addr):array{
        $c = $addr->getComune();
        return array(
            "id"=>$addr->getId(),
            "comune"=>$c->getNome(),
            "provincia"=>$c->getProvincia(),
            "CAP"=>$c->getCAP(),
            "via"=>$addr->getVia(),
            "civico"=>$addr->getCivico(),
            "note"=>$addr->getNote()
        );
    }
}
