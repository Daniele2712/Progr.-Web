<?php
namespace Controllers;
use \Views\Request as Request;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class spesa implements Controller{

    /**
     * home page del sito
     */
    public static function home(Request $req){
        (new \Views\Home())->render();
    }

    /**
     * mostra il catalogo contenente i prodotti del magazzino più vicino all'indirizzo desiderato
     */
    public static function catalogo(Request $req){
        $session = \Singleton::Session();
        $v = new \Views\Catalogo();
        $valuta = \Models\Money::EUR();
        if($session->isLogged())
            $valuta = $session->getUser()->getIdValuta();
        $v->fillBasket($session->getCart(), $valuta);
        try{
            $items = \Foundations\Magazzino::findClosestTo($session->getAddr())->getAvailableItems($req, $filters);
        }catch(\Exception $e){
            if($e->getMessage() === "Error Address not set")    //quando la sessione scade perdo l'indirizzo,
                \Views\HTTPView::redirect("/spesa/home");       //quindi lo rimando alla home
            else
                throw $e;
        }
        $v->fillItems($items, $valuta);
        $v->fillCategories(\Foundations\Categoria::findMainCategories());
        $v->fillFilters($filters);
        $v->render();
    }

    /**
     * aggiunge un item al carello in base all' id del prodotto selezionato e la sua quantità
     */
    public static function addCarrello(Request $req){
        $session = \Singleton::Session();
        $cart = $session->getCart();
        $id = $req->getInt("id");
        $qta = $req->getInt("qta");
        echo "<pre>";
        print_r($cart);
        echo "</pre><br>";
        $prodotto = \Foundations\Prodotto::find($id);
        $cart->addProdotto($prodotto, $qta);
        //aggiorna carrello
        echo "<pre>";
        print_r($cart);
        echo "</pre>";
    }

    public static function completaordine(Request $req){
        $session = \Singleton::Session();
        $cart = $session->getCart();
        $ord = $cart->CompletaOrdine();
        $session->setOrder($ord->getId());
        /*deve chiamare la vista che crea la pagina di riepilogo,
        visualizza l'ordine e fa inserire il metodo di pagamento*/
    }

    public static function userpayment(Request $req){
        $session = \Singleton::Session();
        if(!$session->isLogged())
            die("errore");
        $id = $req->getInt("id", NULL);
        if($id === NULL)
            die("errore2");
        $session->setUserPayment($id);
        $pag = \Foundations\Pagamento::find($id);
        $ord = $session->getOrder();
        $ord->setPagamento($pag);
        //bisogna finire i metodi di pagamento cosi possono essere aggiunti all'ordine

    }

    public static function guestpayment(Request $req){
        $session = \Singleton::Session();

        if($session->isLogged())
            die("errore");
        $id = $req->getInt("id", NULL);
        if($id === NULL)
            die("errore2");
        $pay = self::create_payment($req);
        $session->setGuestPayment($pay);
        //
    }

    public static function create_payment(Request $req){
        $tipo = $req->getString("tipo",NULL,"POST");
        if ($tipo == "carta"){
            $numCarta     = $req->getString("numero",NULL,"POST");
            $cvv          = $req->getInt("cvv",NULL,"POST");
            $nome         = $req->getString("nome",NULL,"POST");
            $cognome      = $req->getString("cognome",NULL,"POST");
            $dataScadenza = new DateTime($req->getString("data_scadenza",NULL,"POST"));
            $r = new \Models\Carta(0, 0, $numcarta, $cvv, $nome, $cognome, $dataScadenza);}
        elseif ($tipo == "paypal"){}
        elseif ($tipo == "bitcoin"){}
        return $r;
    }

    public static function conferma(Request $req){
        $session = \Singleton::Session();
        $ord = $session->getOrder();
        //chiama la vista che crea il riepilogo finale dell'ordine
    }

    /**
     * azione di default
     */
    public static function default(Request $req){
        return self::home($req);
    }
}
?>
