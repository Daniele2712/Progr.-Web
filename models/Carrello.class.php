<?php
namespace Models;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class Carrello extends Model{
    //Attributi
	private $prodotti=array();
	private $totale;
	//Costruttori
	public function __construct(int $i){
		$this->id = $i;
		$this->totale = new Money(0,'Euro');
	}

	//Metodi
	public function addProdotto(Prodotto $pro, int $q){
        $f = FALSE;
        $id = $pro->getId();
        foreach($this->prodotti as $k=>$item)
            if($item->getProdotto()->getId() === $id){
                $f = TRUE;
                $this->prodotti[$k]->add($q);
                break;
            }
        if(!$f){
    		$pre = $pro->getPrezzo();
    		$pre->setPrezzo($pre->getPrezzo() * $q);
    		$i=new Item($pro, $pre, $q);
    		$this->prodotti[]=$i;
        }
		$this->AggiornaPrezzi();
		$this->CalcolaTotale();
	}

	public function CalcolaTotale(){
        $c = 0;
		for ($i = 0; $i < count($this->prodotti); $i++){
			$t = $this->prodotti[$i];
			$c += $t->getPrezzo()->getPrezzo();
		}
        $this->totale->setPrezzo($c);
	}

	public function CompletaOrdine(Indirizzo $ind, Utente $ut){
        $ord=new Ordine($this->prodotti, $ind, $utente);
		return $ord;
	}

	public function AggiornaPrezzi(){
        //Offerta::VerificaOfferte($prodotti);                         //TODO: verificare offerte
	}

	public function addItem(Item $item){
        $f = FALSE;
        $id = $item->getProdotto()->getId();
        foreach($this->prodotti as $k=>$i)
            if($i->getProdotto()->getId() === $id){
                $f = TRUE;
                $this->prodotti[$k]->add($item->getQuantita());
                break;
            }
        if(!$f)
		      $this->prodotti[] = clone $item;
        $this->AggiornaPrezzi();
        $this->CalcolaTotale();
	}

    public function getTotale(){
        return $mon=$this->totale;
    }

    public function getProdotti(){
        $t = array();
        foreach($this->prodotti as $item)
            $t[]=clone $item;
        return $t;
    }

    public function deleteItem(){

    }

  //public function ricaricaCarrello(){};
}