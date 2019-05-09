<?php
namespace Models;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class M_Item extends Model{
    //Attributi
	private $prodotto;      // e' un Model prodotto
	private $quantità=0;    // e' un intero
	private $prezzo;        // e' un MONEY
	//Costruttori
	public function __construct(M_Prodotto $p, M_Money $m=NULL, int $q) // se inizializzi un item senza mettere il money, te lo calcola in automatico in base alla quantia
	{
		$this->prodotto=clone $p;
		$this->quantità=$q;
                if($m===NULL)
                {
                    $prezzo=$p->getPrezzo()->getPrezzo()*$q;
                    $valuta=$p->getPrezzo()->getValuta();
                    $n=new \Models\M_Money($prezzo, $valuta);
                    $this->prezzo=$n;
                }
                else{
                    $this->prezzo=$m;
                }
	}


        public function getProdotto(): M_Prodotto{
            return clone $this->prodotto;
        }
	public function getTotale(): M_Money{
		return $this->prezzo;
	}
	public function getQuantita(){
		return $this->quantità;
	}
    public function add(int $qta){
        $this->quantità += $qta;        //da qui in poi la mia $this->quantita sara = alla vecchia quantita piu i nuovi aggiunti
        $this->prezzo->setPrezzo($this->prodotto->getPrezzo()->getPrezzo()*$this->quantità);   //tre ore mi ci e voluto per trovare questa piccola modifica da fare!! ($quantita+$qta) invece di qta, xke nel caso aggiungi 10 prodotti a un item che ne avea gia 100, la moltiplicazione x trovare il prezzo totlate e prezzo del prodotto */ (numero totatle di prodotti, non solo quelli apppena aggiunti!)
    }
    public function __clone(){
        $this->prodotto = clone $this->prodotto;
        $this->prezzo = clone $this->prezzo;
    }
}
