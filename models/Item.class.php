<?php
namespace Models;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class Item extends Model{
    //Attributi
	private $prodotto;
	private $quantità=0;
	private $prezzo;
	//Costruttori
	public function __construct(Prodotto $p, Money $m, int $q)
	{
		$this->prodotto=clone $p;
		$this->quantità=$q;
		$this->prezzo=$m;
	}
    public function getProdotto(){
        return clone $this->prodotto;
    }
	public function getPrezzo(){
		return $m=$this->prezzo;
	}
	public function getQuantita(){
		return $q=$this->quantità;
	}
    public function add(int $qta){
        $this->quantità += $qta;
        $this->prezzo->setPrezzo($this->prodotto->getPrezzo()->getPrezzo()*$qta);
    }
    public function __clone(){
        $this->prodotto = clone $this->prodotto;
        $this->prezzo = clone $this->prezzo;
    }
}
