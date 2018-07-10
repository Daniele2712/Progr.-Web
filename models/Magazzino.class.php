<?php
namespace Models;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class Magazzino extends Model{
    private $indirizzo;
    private $gestore;
    private $items = array();

    public function __construct(int $id, Indirizzo $indirizzo, array $items=array(), Gestore $gestore){
        $this->id = $id;
        $this->indirizzo = clone $indirizzo;
        foreach($items as $i){
            $this->items[] = clone $i;
        }
        $this->gestore = clone $gestore;
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
}
