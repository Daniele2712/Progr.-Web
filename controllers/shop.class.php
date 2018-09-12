<?php
namespace Controllers;
use \Views\Request as Request;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class shop{
    public function home(Request $req){
        $v = new \Views\Home();

        $session = \Singleton::Session();
        if($session->isLogged())
            $v->setUser($session->getUser());

        $v->render();
    }

    public function spesaSenzaLogin(Request $req){


        $v = new \Views\SpesaSenzaLogin();

        $cat=\Singleton::DB()->query("SELECT nome FROM `categorie`;");
        $catFetched=array();
        while($row = mysqli_fetch_array($cat)) $catFetched[]=$row["nome"];
        $v->fillCategories($catFetched);


        /*      DEVO TROVARE l-ID DEL MAGAZZINO DA CUI FACCIO LA SPESA      */
        $idMagazzino=1;
        $items= \Foundations\Magazzino::find($idMagazzino)->getItems();
        $itemsForHtml = $this->prepareForSale($items,$req->getServerName());
        $v->fillItems($itemsForHtml);


        /*      Trovare i prodotti del Basket       */
        /*  In qualche modo devo prendere l-id del utente loggato....oppure dalla sessione prendo qualcosa  */
        $ModelCarrello=\Singleton::Session()->getCart();        // restituisce un Models Carrello

        $cartItems=$this->makeItemsForCart($ModelCarrello);  //mette dentro al $cartItems gli item nella forma giusta per essere letti dal template
        $cartItemsWithSymbols=$this->valutaToHtml($cartItems);
        $v->fillBasket($cartItemsWithSymbols);
        $v->totalBasket($ModelCarrello->getTotale()->getPrezzo());    // il totale, nel template ci ho messo come valuta l-euro.

        $v->render();
    }



    public function spesaConLogin(Request $req){
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
        $itemsForHtml = $this->prepareForSale($items,$req->getServerName());
        $v->fillItems($itemsForHtml);


       /*      Trovare i prodotti del Basket       */
        /*  In qualche modo devo prendere l-id del utente loggato....oppure dalla sessione prendo qualcosa  */
        $ModelCarrello=\Singleton::Session()->getCart();        // restituisce un Models Carrello

        $cartItems=$this->makeItemsForCart($ModelCarrello);  //mette dentro al $cartItems gli item nella forma giusta per essere letti dal template
        $cartItemsWithSymbols=$this->valutaToHtml($cartItems);
        $v->fillBasket($cartItemsWithSymbols);
        $v->totalBasket($ModelCarrello->getTotale()->getPrezzo());    // il totale, nel template ci ho messo come valuta l-euro.
        $v->render();
    }

    public function logout(Request $req){


        \Singleton::Session()->logout();
        $this->home($req);
    }

    public function gestore(Request $req){
        $v = new \Views\Gestore();
        $v->render();

    }



    private function makeItemsForCart($carrello){

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

    public function valutaToHtml($var){
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

    public function prepareForSale($arrayItems,$serverName){

        $arrayPerTemplate=array();

        foreach($arrayItems as $x){ //$x e' un item
            $y['imgsrc']='http://' . $serverName . '/download/image/' . $x->getProdotto()->getId();
            $y['id']=$x->getProdotto()->getId();
            $y['nome']=$x->getProdotto()->getNome();
            $y['supply']=$x->getQuantita();
            $y['prezzo']=$x->getProdotto()->getPrezzo()->getPrezzo();
            $y['valuta']=$x->getProdotto()->getPrezzo()->getValuta();
            $y['info']=$x->getProdotto()->getInfo();
            $y['descrizione']=$x->getProdotto()->getDescrizione();

            $arrayPerTemplate[]=$y;
        }
        return $this->valutaToHtml($arrayPerTemplate);  // prima di ritornargli l-array, cambio tutti gli eur, gbp, btc, nei loro rispettivi simboli
    }

    public function ricercaFiltrata(){

    /*
     * Ti carica nei prodotti solo i prodotti del magazzino che rispetta le condizioni
     */
        }
    public function submit(Request $req){
        echo("non dovrei arrivare qui");
        // submitting a guestbook entry
        $this->mungeFormData($_POST);
        if($this->isValidForm($_POST)){
            $guestbook->addEntry($_POST);
            $guestbook->displayBook($guestbook->getEntries());
        } else {
             echo var_dump($_POST);
            $guestbook->displayForm($_POST);

        }
    }

    public function default(Request $req){
        return $this->home($req);
    }

    //ANDREI: queste sono funzioni che terrei nel controller, ma private. Poi vedi te

    /**
    * fix up form data if necessary
    *
    * @param array $formvars the form variables
    */
    private function mungeFormData(&$formvars) {  // attenzioneee questa trim ti elimina gli spazi solo alla fine e al inizio della stringa!


      // trim off excess whitespace
      $formvars['Name'] = trim($formvars['Name']);
      $formvars['Comment'] = trim($formvars['Comment']);

    }

    /**
    * test if form information is valid
    *
    * @param array $formvars the form variables
    */
    private function isValidForm($formvars) {

      // reset error message
      $this->error = null;

      // test if "Name" is empty
      if(strlen($formvars['Name']) == 0) {
        $this->error = 'name_empty';
        return false;
      }

      // test if "Comment" is empty
      if(strlen($formvars['Comment']) == 0) {
        $this->error = 'comment_empty';
        return false;
      }

      // form passed validation
      return true;
    }

}
