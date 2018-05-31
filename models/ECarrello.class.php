<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class ECarrello{
    //Attributi
	private $id=0;
	private $prodotti=array();
	private $totale;
	//Costruttori
	public function __construct(int $i){
		$this->id=$i;
		$this->totale=new EMoney(0,'Euro');
	}
	//Metodi
	public function addProdotto(EProdotto $pro, int $q){
		$pre=$pro.getPrezzo();
		$pre.setPrezzo($pre.getPrezzo()*$q);
		$i=new EItem($pro, $pre, $q);
		$this->prodotti[]=$i;
		$this->AggiornaPrezzi();
		$this->CalcolaTotale();
	}
	public function CalcolaTotale(){
		for ($i=0;$i<count($this->prodotti);$i++){
			$t=$this->prodotti[$i];
      $c=0;
			$c+=$t->getPrezzo()->getPrezzo();
		}
        $this->totale->setPrezzo($c);
	}
	public function CompletaOrdine(EIndirizzo $ind, EUtente $ut){
        $ord=new EOrdine($this->prodotti, $ind, $utente);
		return $ord;
	}
	public function AggiornaPrezzi(){
        EOfferta::VerificaOfferte($prodotti);
	}
	public function addItem(EItem $item){
		$this->prodotti[] = clone $item;
    $this->AggiornaPrezzi();
    $this->CalcolaTotale();
	}
    public function getTotale(){
        return $mon=$this->totale;
    }
    public function getId(){
        return $id=$this->id;
    }
    public function getProdotti(){
        $t = array();
        foreach($this->prodotti as $item)
            $t[]=clone $item;
        return $t;
    }
    public function deleteItem();
  //public function ricaricaCarrello(){};
}
