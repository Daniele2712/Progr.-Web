<?php
namespace Models;
use \Views\Request as Request;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class M_Magazzino extends Model{
    private $indirizzo;
    private $responsabile;
    private $items = array();
    private $dipendenti = array();


    public function __construct(int $id, M_Indirizzo $indirizzo, array $items=array(), Utenti\M_Dipendente $responsabile, array $dipendenti = array()){
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
        $n = 20;
        $i = 0;
        try{
            $magazzino = \Singleton::Session()->getClosestMagazzino();
        }catch(\ModelException $e){
            if($e->getCode() === 1){
                $magazzino = \Foundations\F_Magazzino::findClosestTo(\Singleton::Session()->getAddr());
                \Singleton::Session()->setClosestMagazzino($magazzino);
            }else
                throw $e;
        }
        foreach ($magazzino->items as $item)
            if($item->getQuantita()>0 && $item->getProdotto()->hasCat($idCategoria))
                if($filtered && $item->getProdotto()->filter($filters) || !$filtered){
                    if($i >= ($page-1)*$n && $i < $page*$n)                     //divido l'elenco in pagine di $n prodotti
                        $r[] = $item;
                    $i++;
                }
        $pages = ceil($i/$n);
        $cat = \Foundations\F_Categoria::findMainCategories();
        if($idCategoria === 0)
            $sub = array();
        else{
            try{
                $id_padre = \Foundations\F_Categoria::find($idCategoria)->getFather()->getId();
                $sub = \Foundations\F_Categoria::findSubcategories($id_padre);
            }catch(\ModelException $e){
                if($e->getCode() === 0)
                    $sub = \Foundations\F_Categoria::findSubcategories($idCategoria);
                else
                    throw $e;
            }
        }

        return array(                                                           //restituisco tutto quello che serve al controller
                    "items"=>$r,
                    "filters"=>$filters,
                    "categories"=>$cat,
                    "subcategories"=>$sub,
                    "pages"=>$pages
        );
    }

    public function getIndirizzo():\Models\M_Indirizzo{
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

    public static function checkUserAddress(int $id):array{
        $r = array("r"=>200, "items"=>array());

        try{
            $addr = \Foundations\F_Indirizzo::find($id);
        }catch(\SQLException $e){
            if($e->getCode() === 8)
                return array("r"=>404, "items"=>array());                       //Address not found;
            else
                throw $e;
        }

        $session = \Singleton::Session();
        if(!$session->getUser()->hasAddress($id))
            return array("r"=>403, "items"=>array());                           //L'id dell'indirizzo non è dell'utente attuale

        try{
            $new = \Foundations\F_Magazzino::findClosestTo($addr);
        }catch(\ModelException $e){
            if($e->getCode() === 0)
                return array("r"=>404, "items"=>array());                       //Can't find a new closest warehouse
            else
                throw $e;
        }

        $old = $session->getClosestMagazzino();
        if($old->getId() != $new->getId()){
            $r["items"] = $new->checkItemsANDQta($session->getCart()->getItems());
        }
        return $r;
    }

    public static function checkNewAddress(Request $req):array{
        $r = array("r"=>200, "items"=>array());
        $session = \Singleton::Session();

        $id_comune = $req->getInt("comuneId",0,"POST");
        $comune = \Foundations\F_Comune::find($id_comune);

        $via = $req->getString("via","","POST");
        $civico = $req->getString("civico","","POST");
        $note = $req->getString("note","","POST");
        $addr = new \Models\M_Indirizzo(0, $comune, $via, $civico, $note);

        try{
            $new = \Foundations\F_Magazzino::findClosestTo($addr);
        }catch(\ModelException $e){
            if($e->getCode() === 0)
                return array("r"=>404, "items"=>array());                       //Can't find a new closest warehouse
            else
                throw $e;
        }

        $old = $session->getClosestMagazzino();
        if($old->getId() != $new->getId()){
            $r["items"] = $new->checkItemsANDQta($session->getCart()->getItems());
        }
        return $r;
    }

    public function checkItemsANDQta(array $items): array{
        $r = array();
        foreach($items as $required){
            $f = 0;
            foreach($this->items as $available)
                if($required->getProdotto()->getId() === $available->getProdotto->getId()){
                    $f = $available;
                    break;
                }
            if(!$f || $f->getQuantita() < $required->getQuantita())
                $r[] = $f;
        }
        return $r;
    }

    public function removeItems(array $items){
        foreach ($items as $item){
            $f = NULL;
            $id = $item->getProdotto()->getId();
            foreach($this->items as $k=>$i)
                if($i->getProdotto()->getId() === $id){
                    $f = $k;
                    break;
                }
            if($f === NULL)
                throw new \ModelException("Product Not Found", __CLASS__, array("id_prodotto"=>$id),0);
            $real = $this->items[$f];
            if($real->getQuantita() < $item->getQuantita())
                throw new \ModelException("No enought products", __CLASS__, array("id_prodotto"=>$id, "req"=>$real->getQuantita(), "req"=>$item->getQuantita()),0);
            $real->setQuantita($real->getQuantita() - $item->getQuantita());
            \Foundations\F_Magazzino::sellItem($item, $this->id);
        }
    }
}
