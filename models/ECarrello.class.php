
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
	public function addProdotto(EProdotto $pro, int $q){
		$pre=$pro.getPrezzo();
		$pre.setPrezzo($pre.getPrezzo*$q);
		$i=new EItem($pro, $pre, $q);
		$this->prodotti[]=$i;
		CalcolaTotale();
	}
	public function CalcolaTotale(){

	}
	public function CompletaOrdine(){

	}
	public function Aggiornaprezzi(){

	}
}
