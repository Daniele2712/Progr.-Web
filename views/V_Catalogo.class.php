<?php
namespace Views;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class V_Catalogo extends HTMLView{
    public function __construct(){
        parent::__construct();
        $this->layout = "layout";
        $this->content = "spesa/spesa";
        $this->addCSS("spesa/css/spesa.css");
        $this->addJS("spesa/js/spesa.js");
        $this->setCSRF(\Singleton::Session()->getCSRF());
    }

    public function fillCategories($categories){
        $catNames = array();
        foreach($categories as $cat)
            $catNames[] = array("id" => $cat->getId(), "nome" => $cat->getNome());
        $this->smarty->assign('categorie_for_tpl' , $catNames);
    }

    public function fillFilters($filters){
        $filtri = array();
        foreach($filters as $filtro){
            $filtri[] = array(
                "nome" => $filtro->getNome(),
                "tipo" => $filtro->getTipo(),
                "opzioni" => $filtro->getOpzioni(),
                "valore" => $filtro->getValore()
            );
        }
        $this->smarty->assign('filtri_for_tpl' , $filtri);
    }

    public function fillItems(array $arrayItems, \Models\M_Money $valuta){
        $items = array();
        foreach($arrayItems as $item){
            $prodotto = $item->getProdotto();
            $y['imgId'] = $prodotto->getImmaginePreferita()->getId();
            $y['id'] = $prodotto->getId();
            $y['nome'] = $prodotto->getNome();
            $y['supply'] = $item->getQuantita();
            $y['prezzo'] = number_format($prodotto->getPrezzo()->getPrezzo($valuta),2);
            $y['valuta'] = $valuta->getValutaSymbol();
            $y['info'] = $prodotto->getInfo();
            $y['descrizione'] = $prodotto->getDescrizione();
            $items[] = $y;
        }
        $this->smarty->assign('items_for_tpl' , $items);
    }

    public function fillBasket(\Models\M_Carrello $carrello, \Models\M_Money $valuta){
        $items = $carrello->getItems();
        $itemsBasket = array();
        foreach($items as $x){
            $y['id'] = $x->getProdotto()->getId();
            $y['nome'] = $x->getProdotto()->getNome();
            $y['quantita'] = $x->getQuantita();
            $y['totale'] = number_format($x->getTotale()->getPrezzo($valuta),2);// perche il primo get prezzo ti rida un MONEY
            $itemsBasket[] = $y;
        }
        $this->smarty->assign('prodotti_for_carello' , $itemsBasket);
        $this->smarty->assign('total_for_carrello' , $carrello->getTotale()->getPrezzo($valuta));
        $this->smarty->assign('valuta_for_carrello' , $valuta->getValutaSymbol());
    }
}
