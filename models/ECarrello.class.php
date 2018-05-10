<?php
if(!defined("EXEC"))
	return;
class ECarrello{
    //Attributi
	private $id="";
	private $prodotti=array();
	private $totale;
	//Costruttori
	public function __construct(String $i){
		$this->id=$i;
	}
	//Metodi
	public function addProdotto($i){
		$prodotti[]=clone $i;
	}
	public function CalcolaTotale(){
		
	}
	public function CompletaOrdine(){
		
	}
	public function Aggiornaprezzi(){
		
	}
}
?>