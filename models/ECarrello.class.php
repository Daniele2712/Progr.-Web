<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class ECarrello{
    //Attributi
	private $id="";
	private $prodotti=array();
	private $totale;
	//Costruttori
	public function __construct(String $i){
		$this->id=$i;
		$this->totale=new EMoney(0,'Euro');
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
		for ($i=0;$i<$this->prodotti.size();$i++){
			$t=prodotti[i];
			$c+=$t.getPrezzo().getPrezzo();
		}
        $this->totale.setPrezzo($c);
	}
	public function CompletaOrdine(EIndirizzo $ind, EUtente $ut){
        $ord=new EOrdine($this->prodotti, $ind, $utente);
		return $ord;
	}
	public function AggiornaPrezzi(){
        EOfferta::VerificaOfferte($prodotti);
	}
	public function addItem(EItem $item){
		
	}
}
