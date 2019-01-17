<?php
namespace Models;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class Magazzino extends Model{
    private $indirizzo;
    private $responsabile;
    private $items = array();
    private $dipendenti = array();


    public function __construct(int $id, Indirizzo $indirizzo, array $items=array(), Dipendente $responsabile, array $dipendenti = array()){
        $this->id = $id;
        $this->indirizzo = clone $indirizzo;
        foreach($items as $i){
            $this->items[] = clone $i;
        }
        $this->responsabile = clone $responsabile;
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

    public function findItem(Prodotto $prod):Item{
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

    public function getAvailableItems(\Views\Request $req, &$filters):array{
        $idCategoria = $req->getInt(0);         //id Categoria
        $page = $req->getInt(1,1);              //numero pagina
        $filters = \Foundations\Filtro::findInCat($idCategoria);

        if($req->getBool("filtered",FALSE,"POST"))
            foreach($filters as $filtro)
                $filtro->getParams($req);

        $r = array();
        $n = 50;
        $i = 0;
        $filtered = $req->getBool("filtered",FALSE,"POST");
        foreach ($this->items as $item)
            if($item->getQuantita()>0 && $item->getProdotto()->hasCat($idCategoria))
                if($filtered && $item->getProdotto()->filter($filters) || !$filtered){
                    $i++;
                    if($i >= ($page-1)*$n && $i < $page*$n)     //divido l'elenco in pagine di 50 prodotti
                        $r[] = $item;
            }
        return $r;
    }

    public function getIndirizzo():\Models\Indirizzo{
        return clone $this->indirizzo;
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
