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
        //$session = \Singleton::Session();
        //$v->setUser();      //si occupa il render di fare il setUser
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
        //$cartItemsWithSymbols=self::valutaToHtml($cartItems);
        $v->fillBasket($cartItems);
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
                $v->setUser();
                $v->render();
            }
            else header('Location: '."http://".$req->getServerName());
    }
    
    public static function amministratore(Request $req){

         $session = \Singleton::Session();
            if($session->isLogged())            //nel caso l-utente abbia digitato direttamente l-indirizzo senza essersi loggato, lo mando alla home
            {
                $v = new \Views\Amministratore();
                $v->setUser();
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
            $idValuta=$x->getPrezzo()->getValuta();
            $y['valuta']=\Foundations\Valuta::find($idValuta)[2];
            $y['totale']=$x->getPrezzo()->getPrezzo();    // perche il primo get prezzo ti rida un MONEY

            $toReturn[]=$y;

        }
        return $toReturn;
    }



    public static function prepareForSale($arrayItems,$serverName){

        $arrayPerTemplate=array();

        foreach($arrayItems as $x){ //$x e' un item
            $y['imgId'] = $x->getProdotto()->getImmaginePreferita()->getId();
            $y['id']=$x->getProdotto()->getId();
            $y['nome']=$x->getProdotto()->getNome();
            $y['supply']=$x->getQuantita();
            $y['prezzo']=$x->getProdotto()->getPrezzo()->getPrezzo();
            $idValuta=$x->getProdotto()->getPrezzo()->getValuta();
            $y['valuta']=\Foundations\Valuta::find($idValuta)[2];
            $y['info']=$x->getProdotto()->getInfo();
            $y['descrizione']=$x->getProdotto()->getDescrizione();

            $arrayPerTemplate[]=$y;
        }
        return $arrayPerTemplate;  // prima di ritornargli l-array, cambio tutti gli eur, gbp, btc, nei loro rispettivi simboli
    }

    public static function ricercaFiltrata(){

    /*
     * Ti carica nei prodotti solo i prodotti del magazzino che rispetta le condizioni
     */
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