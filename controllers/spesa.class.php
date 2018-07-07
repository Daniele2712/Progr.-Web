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
        $session = \Singleton::Session();
        if($session->isLogged()){
            $addr = $session->getUser()->getIndirizzi();
            //mostra gli indirizzi
            echo "<pre>";
            print_r($addr);
            echo "</pre>";
            echo "<a href='/spesa/userAddress/2'>userAddress 2</a><br>";
            echo "<a href='/user/logout'>logout</a>";
        }else{
            //form nuovo indirizzo
            echo "<form action='/spesa/guestAddress' method='POST'>";
            echo "<input name='comune' placeholder='comune' value='Roma'/><br>";
            echo "<input name='CAP' placeholder='via' value='00100'/><br>";
            echo "<input name='provincia' placeholder='provincia' value='RM'/><br>";
            echo "<input name='via' placeholder='via' value='XX Settembre'/><br>";
            echo "<input name='civico' placeholder='civico' value='3'/><br>";
            echo "<input name='note' placeholder='note' value=''/><br>";
            echo "<input type='submit'/></form>";
            echo "<a href='/user/login?username=rossi&password=rossi'>Login</a>";
        }
    }

    /**
     * metodo per selezionare un indirizzo dell'utente
     */
    public function userAddress(Request $req){
        $session = \Singleton::Session();
        if(!$session->isLogged())
            die("errore");
        $id = $req->getInt(0);
        if($id === NULL)
            die("errore2");
        $session->setUserAddress($id);
        //ok
        echo "ok<br>";
        echo "<a href='/spesa/catalogo'>catalogo</a>";
    }

    /**
     * metodo pre creare un indirizzo temporaneo per l'ospite
     */
    public function guestAddress(Request $req){
        $session = \Singleton::Session();
        if($session->isLogged())
            die("errore");
        $id = $req->getInt("id", NULL);
        if($id === NULL)
            die("errore2");
        $comune     = $req->getString("comune",NULL,"POST");
        $CAP        = $req->getInt("CAP",NULL,"POST");
        $provincia  = $req->getString("provincia",NULL,"POST");
        $via        = $req->getString("via",NULL,"POST");
        $civico     = $req->getInt("civico",NULL,"POST");
        $note       = $req->getString("note",NULL,"POST");

        $ris = \Foundations\Comune::search($comune, $CAP, $provincia);

        $session->setGuestAddress(new \Models\Indirizzo(0, $ris, $via, $civico, $note));
        //ok
        echo "ok<br>";
        echo "<a href='/spesa/catalogo'>catalogo</a>";
    }

    /**
     * mostra il catalogo contenente i prodotti del magazzino più vicino all'indirizzo desiderato
     */
    public function catalogo(Request $req){
        $session = \Singleton::Session();
            print_r($_SESSION);
        $cart = $session->getCart();
        $addr = $session->getAddr();
        $magazzino = \Foundations\Magazzino::findClosestTo($addr);
        $items = $magazzino->getAvailableItems();
        //mostra gli items
        echo "<pre>";
        print_r($items);
        echo "</pre>";
    }

    /**
     * aggiunge un item al carello in base all' id del prodotto selezionato e la sua quantità
     */
    public function addCarrello(Request $req){
        $session = \Singleton::Session();
        $cart = $session->getCart();
        $id = $req->getInt("id");
        $qta = $req->getInt("qta");
        $cart->addItem(new \Models\Item(\Foundations\Prodotto::find($id), $qta));
        //aggiorna carrello
    }

    public function completaordine(Request $req){
        $session = \Singleton::Session();
        $cart = $session->getCart();
        $cart->CompletaOrdine();
        //.......
    }

    public function userpayment(Request $req){
        $session = \Singleton::Session();
        if(!$session->isLogged())
            die("errore");
        $id = $req->getInt("id", NULL);
        if($id === NULL)
            die("errore2");
        $session->setUserPayment($id);
    //ok

    }

    public function guestpayment(Request $req){
        $session = \Singleton::Session();
        if($session->isLogged())
            die("errore");
        $id = $req->getInt("id", NULL);
        if($id === NULL)
            die("errore2");
        //$session->setGuestPayment(new \Models\Pagamento(...));
        //ok
    }

    public function conferma(Request $req){}

    /**
     * azione di default
     */
    public function default(Request $req){
        return $this->inizia($req);
    }
}
?>
