<?php
if(!defined("EXEC"))
	return;

class EMagazzino{
    private $indirizzo;
    private $items = array();

    public function __construct(EIndirizzo $indirizzo=null, array $items=array()){
        if($indirizzo === null)
            $this->indirizzo = new EIndirizzo();
        else
            $this->indirizzo = clone $indirizzo;
        foreach($items as $i){
            $this->items[] = clone $i;
        }
    }
}
