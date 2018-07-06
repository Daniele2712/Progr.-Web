<?php
namespace Controllers;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class shop{
    public function home($req){
        $v = new Views\Home();
        $v->render();
    }

    public function spesaSenzaLogin($req){
        $v = new Views\Spesa();
        $arrayDiProdotti = array();//$ecommerce->getArrayDiProdotti();   //ANDREI: questo lo devi prendere dai modelli

        //l-Array di prodotti che mi ritorna, e' fatto da tanti item quanti gli item del negozio
        // e ogni item del array a sua volta e un oggetto con tante coppie attributo valre
        // quante sono le colonne della tabella (le attributi sono i nomi delle colonne)
        $v->setSpesa($arrayDiProdotti);
        $v->render();
    }

    public function spesaConLogin($req){
        $v = new Views\Spesa();
        $v->setSpesa();
        $v->render();
    }

    public function submit($req){
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
