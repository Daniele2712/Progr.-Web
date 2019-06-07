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
        $this->content = "catalogo/catalogo";
        $this->addCSS("catalogo/css/catalogo.css");
        $this->addJS("catalogo/js/catalogo.js");
        $this->setCSRF(\Singleton::Session()->getCSRF());
    }

    public function fillCategories(array $categories, int $current){
        $catNames = array();
        if($current !== 0)
            $current_cat = \Foundations\F_Categoria::find($current);
        foreach($categories as $cat){
            $catNames[] = array(
                "id" => $cat->getId(),
                "nome" => $cat->getNome(),
                "active" => (
                    $current === $cat->getId() ||
                    $current !== 0 && ($current_cat->isSubcategory() && $current_cat->getFather()->getId() == $cat->getId() ) ? 'active' : '')
                );
            }
        $this->smarty->assign('categories' , $catNames);
    }

    public function fillSubcategories(array $subcategories, int $current){
        $catNames = array();
        foreach($subcategories as $sub)
            $catNames[] = array("id" => $sub->getId(), "nome" => $sub->getNome(), "active" => ($current === $sub->getId()?'active':''));
        $this->smarty->assign('subcategories' , $catNames);
    }

    public function fillFilters(array $filters){
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

    public function setPages(int $pages, int $current, string $link, int $cat){
        $array_pages = array();
        if($current > 2)
            $array_pages[] = 1;
        if($current > 1)
            $array_pages[] = $current-1;
        $array_pages[] = $current;
        if($pages-$current > 0)
            $array_pages[] = $current+1;
        if($pages-$current > 1)
            $array_pages[] = $pages;
        $this->smarty->assign('pages' , $array_pages);
        $this->smarty->assign('current_page' , $current);
        $this->smarty->assign('link' , $link."/".$cat);
    }
}
