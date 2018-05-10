<?php
class ECarrello{
    //Attributi
	private $id="";
	private $prodotti=array();
	private $totale=new Money();
	//Costruttori
	public function __construct(){}
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