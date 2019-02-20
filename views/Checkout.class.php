<?php
namespace Views;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class Checkout extends HTMLView{
    public function __construct(){
        parent::__construct();
        $this->layout = "layout";
        $this->content = "checkout/checkout";
        $this->addCSS("checkout/css/checkout.css");
        $this->addJS("checkout/js/checkout.js");
    }

    public function setAddress(\Models\Indirizzo $addr){
        $this->smarty->assign('indirizzo', $addr->getVia()." ".$addr->getCivico().", ".$addr->getComune()->getNome());
    }

    public function setLoggedUser(\Models\Utente $user){
        $dati = $user->getDatiAnagrafici();
        $this->smarty->assign('nome', $dati->getNome()." ".$dati->getCognome());
        $this->smarty->assign('telefono', $dati->getTelefono());
    }

    public function setCart(\Models\Carrello $cart, \Models\Money $valuta){
        $this->smarty->assign('totale', $cart->getTotale()->getPrezzo($valuta));
        $this->smarty->assign('valuta', $valuta->getValutaSymbol());
    }
    
    public function addCart(\Models\Carrello $cart){
        $items=$cart->getItems();
        $arrayItems=array();
        foreach($items as $item){   // qui devo implementare il fatto che viene fatta la conversione della modeta, dalla moneta con cui e salvato il prodotto, alla moneta con cui l-utente preferisce vedere tutto
            $i= ['idProdotto'=>$item->getProdotto()->getId(),'quantitaProdotto'=>$item->getQuantita(),'nomeProdotto'=>$item->getProdotto()->getNome(),'prezzoProdotto'=> $item->getTotale()->getPrezzo()];
            $arrayItems[]=$i;
        }
        $this->smarty->assign('productsArray', $arrayItems);
        
        $totale=$cart->getTotale()->getPrezzo();
        $this->smarty->assign('prezzoTotale', $totale);
        
        $this->smarty->assign('numItems', sizeof($items));
    }
    
    public function setHtmlValuta($idValuta){
        $htmlValuta=\Foundations\Valuta::find($idValuta)['simbolo'];
        $this->smarty->assign('htmlValuta', $htmlValuta);
    }
    
    public function setDatiSpedizione(\Models\DatiAnagrafici $datiAnagrafici, \Models\Indirizzo $ind){
        $datiAna['nome']=$datiAnagrafici->getNome();
        $datiAna['cognome']=$datiAnagrafici->getCognome();
        $datiAna['telefono']=$datiAnagrafici->getTelefono();
        $indirizzo['via']=$ind->getVia();
        $indirizzo['civico']=$ind->getCivico();
        $indirizzo['nomeComune']=$ind->getComune()->getNome();
        $this->smarty->assign('indirizzo', $indirizzo);
        $this->smarty->assign('datiAnagrafici', $datiAna);
        
        
        
        
        
    }
    
    
}
