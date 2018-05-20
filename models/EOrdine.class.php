<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class EOrdine{
	//Attributi
    private $prodotti= array();
    private $metodoPagamento;
    private $indirizzo;
	private $utente;
    //Costruttori
    public function __construct(array $prodotti, EIndirizzo $indirizzo, EUtente $utente){
    	$this->prodotti =  $prodotti;
        $this->indirizzo = $indirizzo;
		$this->utente = $utente;
    }
	//Metodi
	public function setProdotti(array $prodotti){
		$this->prodotti =  $prodotti;
	}
	public function setMetodoPagamento(EMetodoPagamento $metodopagamento){
		$this->metodopagamento =  $metodopagamento;
	}
	public function setIndirizzo(EIndirizzo $indirizzo){
		$this->indirizzo =  $indirizzo;
	}
	public function setUtente(EUtente $utente){
		$this->utente =  $utente;
	}
}
