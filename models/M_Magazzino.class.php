<?php
namespace Models;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class M_Magazzino extends Model{
    private $indirizzo;
    private $responsabile;
    private $items = array();
    private $dipendenti = array();


    public function __construct(int $id, M_Indirizzo $indirizzo, array $items=array(), Utenti\M_Dipendente $responsabile=NULL, array $dipendenti = array()){
        $this->id = $id;
        $this->indirizzo = clone $indirizzo;
        foreach($items as $i){
            $this->items[] = clone $i;
        }
        if($responsabile) $this->responsabile = clone $responsabile; else $this->responsabile=NULL;
        foreach($dipendenti as $d){
            $this->dipendenti[] = clone $d;
        }
    }

	public function setQuantita(int $qnt){

	}

    public function getItems():array{
        $r = array();
        foreach ($this->items as $item)
            $r[] = $item;
        return $r;
    }

    public function findItem(M_Prodotto $prod):M_Item{
        foreach ($this->items as $item)
            if($item->getProdotto()->getId() == $prod->getId())
                return clone $item;
        new \ModelException("Item not found", __CLASS__, array("id_prod"=>$prod->getId()),1);
    }

    public function sellItem(Prodotto $prod, int $qta){
        foreach ($this->items as $item)
            if($item->getProdotto()->getId() == $prod->getId()){
                if($item->getQuantita() < $qta)
                    new \ModelException("Stock underflow", __CLASS__, array("stock"=>$item->getQuantita(), "qta"=>$qta), 2);
                $item->add(-$qta);
            }
        new \ModelException("Item not found", __CLASS__, array("id_prod"=>$prod->getId()),1);
    }

    public static function getCatalogo(\Views\Request $req):array{
        $idCategoria = $req->getInt(0);         //id Categoria                  //prendo l'input dalla richiesta
        $page = $req->getInt(1,1);              //numero pagina
        $filters = \Foundations\F_Filtro::findInCat($idCategoria);              //tramite i foundations prendo gli altri modelli
        $filtered = $req->getBool("filtered",FALSE,"POST");

        if($filtered)
            foreach($filters as $filtro)
                $filtro->getParams($req);

        $r = array();
        $n = 50;
        $i = 0;
        $magazzino = \Foundations\F_Magazzino::findClosestTo(\Singleton::Session()->getAddr());
        foreach ($magazzino->items as $item)
            if($item->getQuantita()>0 && $item->getProdotto()->hasCat($idCategoria))
                if($filtered && $item->getProdotto()->filter($filters) || !$filtered){
                    $i++;
                    if($i >= ($page-1)*$n && $i < $page*$n)     //divido l'elenco in pagine di 50 prodotti
                        $r[] = $item;
            }

        $cat = \Foundations\F_Categoria::findMainCategories();
        return array("items"=>$r, "filters"=>$filters, "categories"=>$cat);     //restituisco tutto quello che serve al controller
    }

    public function getIndirizzo():\Models\M_Indirizzo{
        return clone $this->indirizzo;
    }
    public function getResponsabile(){
        if($this->responsabile) return clone $this->responsabile;
        else return NULL;
    }


    public function getNumDipendenti():int{
        return $dipendenti->count();
    }

    public function getDipendenti():array{
        $r = array();
        foreach ($this->dipendenti as $dipendente)
            $r[] = $dipendente;
        return $r;
    }
}
