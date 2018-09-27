<?php
namespace Models;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class Magazzino extends Model{
    private $indirizzo;
    private $responsabile;
    private $items = array();
    private $dipendenti = array();


    public function __construct(int $id, Indirizzo $indirizzo, array $items=array(), Dipendente $responsabile, array $dipendenti = array()){
        $this->id = $id;
        $this->indirizzo = clone $indirizzo;
        foreach($items as $i){
            $this->items[] = clone $i;
        }
        $this->responsabile = clone $responsabile;
        foreach($dipendenti as $d){
            $this->dipendenti[] = clone $d;
        }
    }

	public function setQuantita(int $qnt){

	}

    public function getItems():array{
        $r = array();
        foreach ($this->items as $item)
            $r[] = $item;
        return $r;
    }

    public function getAvailableItems(int $page = 1):array{
        $r = array();
        $n = 50;
        $i = 0;
        foreach ($this->items as $item)
            if($item->getQuantita()>0){
                $i++;
                if($i => $page*$n && $i < ($page+1)*$n)     //divido l'elenco in pagine di 50 prodotti
                    $r[] = $item;
            }
        return $r;
    }

    public function getIndirizzo():\Models\Indirizzo{
        return clone $this->indirizzo;
    }

    public function getNumDipendenti():int{
        return $dipendenti->count();
    }

    public function getDipendenti():array{
        $r = array();
        foreach ($this->dipendenti as $dipendente)
            $r[] = $dipendente;
        return $r;
    }
}
