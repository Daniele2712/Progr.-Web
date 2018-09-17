<?php
namespace Controllers;
use \Views\Request as Request;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class shop{
    public static function home(Request $req){
        $v = new \Views\Home();
        //throw new \Exception("Error Processing Request", 1);
        $session = \Singleton::Session();
        if($session->isLogged())
            $v->setUser($session->getUser());

        $v->render();
    }

    public static function spesaSenzaLogin(Request $req){


        $v = new \Views\SpesaSenzaLogin();

        $cat=\Singleton::DB()->query("SELECT nome FROM `categorie`;");
        $catFetched=array();
        while($row = mysqli_fetch_array($cat)) $catFetched[]=$row["nome"];
        $v->fillCategories($catFetched);


        /*      DEVO TROVARE l-ID DEL MAGAZZINO DA CUI FACCIO LA SPESA      */
        $idMagazzino=1;
        $items= \Foundations\Magazzino::find($idMagazzino)->getItems();
        $itemsForHtml = self::prepareForSale($items,$req->getServerName());
        $v->fillItems($itemsForHtml);


        /*      Trovare i prodotti del Basket       */
        /*  In qualche modo devo prendere l-id del utente loggato....oppure dalla sessione prendo qualcosa  */
        $ModelCarrello=\Singleton::Session()->getCart();        // restituisce un Models Carrello

        $cartItems=self::makeItemsForCart($ModelCarrello);  //mette dentro al $cartItems gli item nella forma giusta per essere letti dal template
        $cartItemsWithSymbols=self::valutaToHtml($cartItems);
        $v->fillBasket($cartItemsWithSymbols);
        $v->totalBasket($ModelCarrello->getTotale()->getPrezzo());    // il totale, nel template ci ho messo come valuta l-euro.

        $v->render();
    }



    public static function spesaConLogin(Request $req){
        $v = new \Views\SpesaConLogin();
        // Prima di fare il render devi riempire tutte le variabili di smarty

        $v->setUser(\Singleton::Session()->getUser());
        $cat=\Singleton::DB()->query("SELECT nome FROM `categorie`;");
        $catFetched=array();
        while($row = mysqli_fetch_array($cat)) $catFetched[]=$row["nome"];
        $v->fillCategories($catFetched);

        /*      DEVO TROVARE l-ID DEL MAGAZZINO DA CUI FACCIO LA SPESA      */
        $idMagazzino=1;
        $items= \Foundations\Magazzino::find($idMagazzino)->getItems();
        $itemsForHtml = self::prepareForSale($items,$req->getServerName());
        $v->fillItems($itemsForHtml);


       /*      Trovare i prodotti del Basket       */
        /*  In qualche modo devo prendere l-id del utente loggato....oppure dalla sessione prendo qualcosa  */
        $ModelCarrello=\Singleton::Session()->getCart();        // restituisce un Models Carrello

        $cartItems=self::makeItemsForCart($ModelCarrello);  //mette dentro al $cartItems gli item nella forma giusta per essere letti dal template
        $cartItemsWithSymbols=self::valutaToHtml($cartItems);
        $v->fillBasket($cartItemsWithSymbols);
        $v->totalBasket($ModelCarrello->getTotale()->getPrezzo());    // il totale, nel template ci ho messo come valuta l-euro.
        $v->render();
    }

    public static function logout(Request $req){


        \Singleton::Session()->logout();
        self::home($req);
    }

    public static function gestore(Request $req){

         $session = \Singleton::Session();
            if($session->isLogged())            //nel caso l-utente abbia digitato direttamente l-indirizzo senza essersi loggato, lo mando alla home
            {
                $v = new \Views\Gestore();
                $v->setUser($session->getUser());
                $v->render();
            }
            else header('Location: '."http://".$req->getServerName());
    }



    private static function makeItemsForCart($carrello){

        $items=$carrello->getProdotti();    //in realta restituisce items, non prodotti come suggerisce il nome

        $toReturn=array();

        foreach($items as $x){
            $y['nome']=$x->getProdotto()->getNome();
            $y['quantita']=$x->getQuantita();
            $y['valuta']=$x->getPrezzo()->getValuta();
            $y['totale']=$x->getPrezzo()->getPrezzo();    // perche il primo get prezzo ti rida un MONEY

            $toReturn[]=$y;

        }
        return $toReturn;
    }

    public static function valutaToHtml($var){
        /* ha bisogno di un array fatto di array, e in questo secondo array ci deve essere una chiave [valuta]*/
        $itemBasketFetchedHtml=array(); /* ATTENZIONE il solo valore cambiato sara quello con chiave valuta!  */
        foreach($var as $x){
            switch($x['valuta']){
                case 'EUR':
                    $x['valuta']='&#8364;';
                    break;
                case 'USD':
                    $x['valuta']='&#36;';
                    break;
                case 'GBP':
                    $x['valuta']='&#163;';
                    break;
                case'BTC':
                    $x['valuta']='Ƀ';
                    break;
                case'JPY':
                    $x['valuta']='&#65509;';
                    break;
                default:
                    $x['valuta']='???';
                    break;
            }
        $itemBasketFetchedHtml[]=$x;
        }
        return $itemBasketFetchedHtml;
    }

    public static function prepareForSale($arrayItems,$serverName){

        $arrayPerTemplate=array();

        foreach($arrayItems as $x){ //$x e' un item
            $y['imgId'] = $x->getProdotto()->getImmaginePreferita()->getId();
            $y['id']=$x->getProdotto()->getId();
            $y['nome']=$x->getProdotto()->getNome();
            $y['supply']=$x->getQuantita();
            $y['prezzo']=$x->getProdotto()->getPrezzo()->getPrezzo();
            $y['valuta']=$x->getProdotto()->getPrezzo()->getValuta();
            $y['info']=$x->getProdotto()->getInfo();
            $y['descrizione']=$x->getProdotto()->getDescrizione();

            $arrayPerTemplate[]=$y;
        }
        return self::valutaToHtml($arrayPerTemplate);  // prima di ritornargli l-array, cambio tutti gli eur, gbp, btc, nei loro rispettivi simboli
    }

    public static function ricercaFiltrata(){

    /*
     * Ti carica nei prodotti solo i prodotti del magazzino che rispetta le condizioni
     */
        }
    public static function submit(Request $req){
        echo("non dovrei arrivare qui");
        // submitting a guestbook entry
        self::mungeFormData($_POST);
        if(self::isValidForm($_POST)){
            $guestbook->addEntry($_POST);
            $guestbook->displayBook($guestbook->getEntries());
        } else {
             echo var_dump($_POST);
            $guestbook->displayForm($_POST);

        }
    }

    public static function default(Request $req){
        return self::home($req);
    }

    //ANDREI: queste sono funzioni che terrei nel controller, ma private. Poi vedi te

    /**
    * fix up form data if necessary
    *
    * @param array $formvars the form variables
    */
    private static function mungeFormData(&$formvars) {  // attenzioneee questa trim ti elimina gli spazi solo alla fine e al inizio della stringa!


      // trim off excess whitespace
      $formvars['Name'] = trim($formvars['Name']);
      $formvars['Comment'] = trim($formvars['Comment']);

    }

    /**
    * test if form information is valid
    *
    * @param array $formvars the form variables
    */
    private static function isValidForm($formvars) {

      // reset error message
      $error = null;

      // test if "Name" is empty
      if(strlen($formvars['Name']) == 0) {
        $error = 'name_empty';
        return false;
      }

      // test if "Comment" is empty
      if(strlen($formvars['Comment']) == 0) {
        $error = 'comment_empty';
        return false;
      }

      // form passed validation
      return true;
    }

}
