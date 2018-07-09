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

    public function __construct(Indirizzo $indirizzo=null, Gestore $gestore=NULL, array $items=array()){
        if($indirizzo === null)
            $this->indirizzo = new Indirizzo();
        else
            $this->indirizzo = clone $indirizzo;
        if($gestore === null)
            $this->gestore = new Gestore();
        else
            $this->gestore = clone $gestore;
        foreach($items as $i){
            $this->items[] = clone $i;
        }
    }

	public function setQuantita(int $qnt){

	}

    public function setGestore(Gestore $ges){
        $this->gestore = clone $ges;
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
}
