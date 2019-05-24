<?php
namespace Controllers;
use \Views\Request as Request;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class C_spesa implements Controller{

    /**
     * home page del sito
     */
    public static function home(Request $req){
        (new \Views\V_Home())->render();
    }

    /**
     * mostra il catalogo contenente i prodotti del magazzino più vicino all'indirizzo desiderato
     */
    public static function catalogo(Request $req){
        $session = \Singleton::Session();                                       //prende la sessione
        if($session->timedOut() || $session->isNew()){                          //controlli sulla sessione
            $session->setMessage("Sessione scaduta per inattivit&agrave;");     //messaggio di errore custom
            \Views\HTTPView::redirect("/spesa/home");                           //effettuo un redirect a /spesa/home
        }
        $valuta = $session->getUserValuta();
        $v = new \Views\V_Catalogo();                                           //istanzio la view
        $v->fillBasket($session->getCart(), $valuta);
        $data = \Models\M_Magazzino::getCatalogo($req);                         //metodo statico del model che fa il lavoro sporco
        $v->fillItems($data["items"], $valuta);                                     //passando la request
        $v->fillCategories($data["categories"]);                                //passo i models alla view
        $v->fillFilters($data["filters"]);
        $v->render();                                                           //mostro la view
    }

    public static function checkout(Request $req){
        $session = \Singleton::Session();
        if($session->timedOut() || $session->isNew()){
            $session->setMessage("Sessione scaduta per inattivit&agrave;");
            \Views\HTTPView::redirect("/spesa/home");
        }
        $v = new \Views\V_Checkout();
        $v->setAddress($session->getAddr());
        if($session->isLogged())
            $v->setLoggedUser($session->getUser());
        $v->fillBasket($session->getCart(), $session->getUserValuta());
        $v->render();
    }

    public static function ordine(Request $req){
        $session = \Singleton::Session();
        if($session->timedOut() || $session->isNew()){
            $session->setMessage("Sessione scaduta per inattivit&agrave;");
            \Views\HTTPView::redirect("/spesa/home");
        }
        $ordine = \Models\M_Ordine::nuovo($req);
    }

    public static function ordini(Request $req){
       $valuta=\Models\M_Money::EUR();
       $session=\Singleton::Session();
       $v = new \Views\V_Ordini();


       if($session->isLogged())
       {
        $valuta = $session->getUser()->getIdValuta();   //magari puo servire per displayare gli item con la valuta, da implementare in seguito
        $userId=$session->getUser()->getId();
        $v->utenteRegistrato();
        $arrayOrdini= \Foundations\F_Ordine::findByUserId($userId);
        $ordiniSemplici=array();    //un array che contiene oggetti TIPO ordini, solo che al posto degli indirizzi, datiana, pagamento, contiene solo il loro id

        foreach($arrayOrdini as $ordine){
        $ordineJson=\Foundations\F_Ordine::orderDetailsToJson($ordine->getId());
        $ordiniSemplici[]= json_decode($ordineJson);
        }
        $v->fillOrdini($ordiniSemplici);
       }

       else{
           $v->utenteNonRegistrato();
           $v->fillOrdini('');    //penso che devo cmq inizializzare la variabile, anche se non la uso altrimenti smarty si lamente
       }       //vedi cosa fare se l-utente non e registrato   forse e bene generare un numero random x ogni ordine creato. e usarlo come parametro nel url

       $v->render();
    }

    public static function pagamento(Request $req){
        $session = \Singleton::Session();
        if($session->timedOut()){
            $session->setMessage("Sessione scaduta per inattivit&agrave;");
            \Views\HTTPView::redirect("/spesa/home");
        }
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
        $pag = \Foundations\F_Pagamento::find($id);
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
            $dataScadenza = new \DateTime($req->getString("data_scadenza",NULL,"POST"));
            $r = new \Models\M_Carta(0, 0, $numcarta, $cvv, $nome, $cognome, $dataScadenza);}
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
