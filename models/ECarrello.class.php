<?php
if(!defined("EXEC"))
	return;
    
class ECarrello{
    //Attributi
	private $id="";
	private $prodotti=array();
	private $totale=new EMoney(0,'Euro');
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
		AggiornaPrezzi();
		CalcolaTotale();
	}
	public function CalcolaTotale(){
		for ($i=0;i<$this->prodotti.size();i++){
			$t=prodotti[i];
			$c+=$t.getPrezzo().getPrezzo();
		}
        $this->totale.setPrezzo($c);
	}
	public function CompletaOrdine(){

	}
	public function AggiornaPrezzi(){

	}
}
