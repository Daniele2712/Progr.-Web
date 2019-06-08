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
        $this->smarty->assign('datiAnagrafici', array("nome"=>"", "cognome"=>"", "telefono"=>""));
    }

    public function setMainAddress(\Models\M_Indirizzo $addr){
        $this->smarty->assign('mainAddress', array(
            "id"=>$addr->getId(),
            "via"=>$addr->getVia(),
            "civico"=>$addr->getCivico(),
            "comune"=>$addr->getComune()->getNome(),
            "id_comune"=>$addr->getComune()->getId(),
            "note"=>$addr->getNote())
        );
    }

    public function setUserAddresses(array $addresses){
        $arr = array();
        foreach($addresses as $addr){
            $arr[] = array(
                "id"=>$addr->getId(),
                "comune"=>$addr->getComune()->getNome(),
                "id_comune"=>$addr->getComune()->getId(),
                "provincia"=>$addr->getComune()->getProvincia(),
                "via"=>$addr->getVia(),
                "civico"=>$addr->getCivico(),
                "note"=>$addr->getCivico()
            );
        }
        $this->smarty->assign('addresses', $arr);
    }

    public function setLoggedUser(\Models\M_Utente $user){
        $dati = $user->getDatiAnagrafici();
        $this->smarty->assign('datiAnagrafici', array("nome"=>$dati->getNome(), "cognome"=>$dati->getCognome(), "telefono"=>$dati->getTelefono()));
    }

    public function fillBasket(\Models\M_Carrello $cart, \Models\M_Money $valuta){
        $items=$cart->getItems();
        $arrayItems=array();
        $tot = 0;
        foreach($items as $item){
            $tot += $item->getQuantita();
            $i= ['idProdotto'=>$item->getProdotto()->getId(), 'quantitaProdotto'=>$item->getQuantita(), 'nomeProdotto'=>$item->getProdotto()->getNome(), 'prezzoProdotto'=> $item->getTotale()->getPrezzo()];
            $arrayItems[]=$i;
        }
        $this->smarty->assign('numItems', $tot);
        $this->smarty->assign('productsArray', $arrayItems);
        $this->smarty->assign('totale', $cart->getTotale()->getPrezzo($valuta));
        $this->smarty->assign('valuta', $valuta->getValutaSymbol());
    }

    public function setPayPal(string $url, string $valuta, string $email, float $totale, bool $sandbox){
        $this->smarty->assign('PayPal_url', $url);
        $this->smarty->assign('PayPal_valuta', $valuta);
        $this->smarty->assign('PayPal_email', $email);
        $this->smarty->assign('PayPal_totale', $totale);
        $this->smarty->assign('PayPal_sandbox', $sandbox);
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
