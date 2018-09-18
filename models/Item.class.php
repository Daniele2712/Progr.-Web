<?php
namespace Models;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class Item extends Model{
    //Attributi
	private $prodotto;      // e' un prodotto
	private $quantità=0;    // e' un intero
	private $prezzo;        // e' un MONEY
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
		return $this->prezzo;
	}
	public function getQuantita(){
		return $this->quantità;
	}
    public function add(int $qta){
        $this->quantità += $qta;        //da qui in poi la mia $this->quantita sara = alla vecchia quantita piu i nuovi aggiunti
        $this->prezzo->setPrezzo($this->prodotto->getPrezzo()->getPrezzo()*$this->quantità);   //tre ore mi ci e voluto per trovare questa piccola modifica da fare!! ($quantita+$qta) invece di qta, xke nel caso aggiungi 10 prodotti a un item che ne avea gia 100, la moltiplicazione x trovare il prezzo totlate e prezzo del prodotto */ (numero totatle di prodotti, non solo quelli apppena aggiunti!)
    }
    public function __clone(){
        $this->prodotto = clone $this->prodotto;
        $this->prezzo = clone $this->prezzo;
    }
}
