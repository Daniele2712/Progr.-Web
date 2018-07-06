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

    public function __construct(Indirizzo $indirizzo=null, array $items=array()){
        if($indirizzo === null)
            $this->indirizzo = new Indirizzo();
        else
            $this->indirizzo = clone $indirizzo;
        foreach($items as $i){
            $this->items[] = clone $i;
        }
    }

	public function setQuantita(int $qnt){

	}
  public function setGestore(Gestore $ges){
    $this->gestore = clone $ges;
  }
}
