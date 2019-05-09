<?php
namespace Views;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class V_Checkout extends HTMLView{

    public function __construct(){
        parent::__construct();
        $this->layout = "layout";
        $this->content = "checkout/checkout";
        $this->addCSS("checkout/css/checkout.css");
        $this->addJS("checkout/js/checkout.js");
    }

    public function setAddress(\Models\M_Indirizzo $addr){
        $this->smarty->assign('indirizzo', array("via"=>$addr->getVia(), "civico"=>$addr->getCivico(), "comune"=>$addr->getComune()->getNome(), "id_comune"=>$addr->getComune()->getId(),"note"=>$addr->getNote()));
    }

    public function setLoggedUser(\Models\M_Utente $user){
        $dati = $user->getDatiAnagrafici();
        $this->smarty->assign('datiAnagrafici', array("nome"=>$dati->getNome(), "cognome"=>$dati->getCognome(), "telefono"=>$dati->getTelefono()));
    }

    public function fillBasket(\Models\M_Carrello $cart, \Models\M_Money $valuta){
        $items=$cart->getItems();
        $arrayItems=array();
        foreach($items as $item){
            $i= ['idProdotto'=>$item->getProdotto()->getId(), 'quantitaProdotto'=>$item->getQuantita(), 'nomeProdotto'=>$item->getProdotto()->getNome(), 'prezzoProdotto'=> $item->getTotale()->getPrezzo()];
            $arrayItems[]=$i;
        }
        $this->smarty->assign('productsArray', $arrayItems);
        $this->smarty->assign('totale', $cart->getTotale()->getPrezzo($valuta));
        $this->smarty->assign('valuta', $valuta->getValutaSymbol());
    }

    public function setHtmlValuta($idValuta){
        $htmlValuta=\Foundations\F_Valuta::find($idValuta)['simbolo'];
        $this->smarty->assign('htmlValuta', $htmlValuta);
    }

    /*public function setDatiSpedizione(\Models\M_DatiAnagrafici $datiAnagrafici, \Models\M_Indirizzo $ind){
        $datiAna['nome']=$datiAnagrafici->getNome();
        $datiAna['cognome']=$datiAnagrafici->getCognome();
        $datiAna['telefono']=$datiAnagrafici->getTelefono();
        $indirizzo['via']=$ind->getVia();
        $indirizzo['civico']=$ind->getCivico();
        $indirizzo['nomeComune']=$ind->getComune()->getNome();
        $this->smarty->assign('indirizzo', $indirizzo);
        $this->smarty->assign('datiAnagrafici', $datiAna);
    }*/

}