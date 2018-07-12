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
        $item=\Singleton::DB()->query("SELECT prodotti.*, items_magazzino.quantita FROM `prodotti`, items_magazzino WHERE prodotti.id=items_magazzino.id_prodotto AND items_magazzino.id_prodotto=$idMagazzino;");
        $itemFetched=array();
        
        while($row = mysqli_fetch_array($cat)) $catFetched[]=$row;   
        /*echo "<pre>";
        echo var_dump($itemFetched);
        echo "</pre>";*/
        $v->fillItems($itemFetched);
        
        
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
