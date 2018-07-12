<?php
namespace Models;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class Ordine extends Model{
	//Attributi
    private $prodotti= array();
    private $Pagamento;
    private $indirizzo;
	private $utente;
    //Costruttori
    public function __construct(array $prodotti, Indirizzo $indirizzo, Utente $utente){
    	$this->prodotti =  $prodotti;
        $this->indirizzo = $indirizzo;
		$this->utente = $utente;
    }
	//Metodi
	public function setProdotti(array $prodotti){
		$this->prodotti =  $prodotti;
	}
	public function setPagamento(Pagamento $pagamento){
		$this->pagamento =  $pagamento;
	}
	public function setIndirizzo(Indirizzo $indirizzo){
		$this->indirizzo =  $indirizzo;
	}
	public function setUtente(Utente $utente){
		$this->utente =  $utente;
	}
}
