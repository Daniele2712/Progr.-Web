<?php
class EItem{
    //Attributi
	private $prodotto;
	private $quantità;
	private $prezzo;
	//Costruttori
	public function __construct(Money $m, $q,EProdotto $p)
	{
		$this->prodotto=$p;
		$this->quantità=$q;
		$this->prezzo=$p;
	}
}
?>