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


    public function __construct(int $id, Indirizzo $indirizzo, array $items=array(), Responsabile $responsabile, array $dipendenti = array()){
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

    public function getAvailableItems():array{
        $r = array();
        foreach ($this->items as $item)
            if($item->getQta()>0)
                $r[] = $item;
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
