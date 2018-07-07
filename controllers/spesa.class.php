<?php
namespace Controllers;
use \Views\Request as Request;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class spesa implements Controller{
    public function __construct(){}

    /**
     * metodo per selezionare o aggiungere l'indirizzo a cui spedire
     */
    public function inizia(Request $req){
        $session = \Singleton::Sessione();
        if($session->isLogged()){
            $addr = $session->getUser()->getIndirizzi();
            //mostra gli indirizzi
        }else{
            //form nuovo indirizzo
        }
    }

    /**
     * metodo per selezionare un indirizzo dell'utente
     */
    public function userAddress(Request $req){
        $session = \Singleton::Sessione();
        if(!$session->isLogged())
            die("errore");
        $id = $req->getInt("id", NULL);
        if($id === NULL)
            die("errore2");
        $session->setUserAddress($id);
        //ok
    }

    /**
     * metodo pre creare un indirizzo temporaneo per l'ospite
     */
    public function guestAddress(Request $req){
        $session = \Singleton::Sessione();
        if($session->isLogged())
            die("errore");
        $id = $req->getInt("id", NULL);
        if($id === NULL)
            die("errore2");
        ...
        $session->setGuestAddress(new \Models\Indirizzo(...));
        //ok
    }

    /**
     * mostra il catalogo contenente i prodotti del magazzino più vicino all'indirizzo desiderato
     */
    public function catalogo(Request $req){
        $session = \Singleton::Sessione();
        $cart = $session->getCart();
        $addr = $session->getIndirizzo();
        $magazzino = \Foundations\Magazzino::findClosestTo($addr);
        $items = $magazzino->getItems();
        //mostra gli items
    }

    /**
     * aggiunge un item al carello in base all' id del prodotto selezionato e la sua quantità
     */
    public function addCarrello(Request $req){
        $session = \Singleton::Sessione();
        $cart = $session->getCart();
        $id = $req->getInt("id");
        $qta = $req->getInt("qta");
        $cart->addItem(new \Models\Item(\Foundations\Prodotto::find($id), $qta));
        //aggiorna carrello
    }

    public function completaordine(){}
    public function selezionapagamento(){}
    public function conferma(){}

    /**
     * azione di default
     */
    public function default(Request $req){
        return $this->inizia($req);
    }
}
?>
