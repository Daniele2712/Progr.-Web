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
        $v->render();
    }

    public function spesaSenzaLogin(Request $req){
        $v = new \Views\Spesa();
        
        $cat=\Singleton::DB()->query("SELECT nome FROM `categorie`;");
        $catFetched=array();
        while($row = mysqli_fetch_array($cat)) $catFetched[]=$row["nome"];   
        $v->fillCategories($catFetched);
        
        /*      DEVO TROVARE l-ID DEL MAGAZZINO DA CUI FACCIO LA SPESA      */
        $idMagazzino=1;
        $item=\Singleton::DB()->query("SELECT prodotti.*, items_magazzino.quantita FROM `prodotti`, items_magazzino WHERE prodotti.id=items_magazzino.id_prodotto AND items_magazzino.id_magazzino=$idMagazzino;");
        $itemFetched=array();
        
        while($row = mysqli_fetch_array($item)) $itemFetched[]=$row;   
        $v->fillItems($this->valutaToHtml($itemFetched));   //l-array che  li passo ha gia trasformato la valuta nel html giusto per essere visualizzata
        
        /*      Trovare i prodotti del Basket       */
        /*  In qualche modo devo prendere l-id del utente loggato....oppure dalla sessione prendo qualcosa  */
        $idBakset=1;
        $itemBasket=\Singleton::DB()->query("SELECT prodotti.nome, totale, items_carrello.valuta, quantita FROM `items_carrello`,prodotti WHERE id_carrello=$idBakset AND prodotti.id=items_carrello.id_prodotto;");
        $itemBasketFetched=array();
        
        while($row = mysqli_fetch_array($itemBasket)) $itemBasketFetched[]=$row;
        $v->fillBasket($this->valutaToHtml($itemBasketFetched));
        $v->render();
    }

    public function spesaConLogin(Request $req){
        $v = new \Views\Spesa();
        $v->setSpesa();
        $v->render();
    }
    
    
    public function gestore(Request $req){
        $v = new \Views\Gestore();
        $v->render();
        
    }

    public function valutaToHtml($var){ /* ha bisogno di un array fatto di array, e in questo secondo array ci deve essere una chiave [valuta]*/
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
