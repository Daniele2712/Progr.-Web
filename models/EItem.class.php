<?php
if(!defined("EXEC"))
	return;
    
class EItem{
    //Attributi
	private $prodotto;
	private $quantità=0;
	private $prezzo;
	//Costruttori
	public function __construct(Money $m, int $q, EProdotto $p)
	{
		$this->prodotto=$p;
		$this->quantità=$q;
		$this->prezzo=$p;
	}
}
