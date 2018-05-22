<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class EMagazzino{
    private $indirizzo;
    private $gestore;
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

	public function setQuantita(int $qnt){

	}
  public function setGestore(EGestore $ges){
    $this->gestore = clone $ges;
  }
}
