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
}
