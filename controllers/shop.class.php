<?php
namespace Controllers;
use \Views\Request as Request;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}


class Shop{
    
    public function home($req){
        $headIncludes='<link rel="stylesheet" type="text/css" href="/templates/css/login.css"/> <link rel="stylesheet" type="text/css" href="/templates/css/home.css"/>';
        $loginOrUserIncludes='login.tpl';
        $contentIncludes='home.tpl';
        $v = new \Views\Home($headIncludes, $loginOrUserIncludes, $contentIncludes);
        $v->render();
        
    }
    
     public function spesaSenzaLogin($req){
        $IDmagazzino=1;
        $nome='Mario Rossi';
        $categorie=FCategoria::allCategories();
        $filtri=FFiltro::allFilters(); 
        $items=FMagazzino::allItems($IDmagazzino);
        $carrello=FCarrello::getCarrelloItems(); 
        
        
        $v = new \Views\Spesa();
        $divs=$v->createDivs($categorie, $filtri, $items, $carrello);
     }


    public function spesaConLogin(Request $req){
    
    /*

      La mia spesa con login era cosi:
     
        $nome='Mario Rossi';
        $categorie=array('Cat1','Cat2','Cat3','Cat4','Cat5');
        $filtri='login.tpl';             Devo trovare un modo per mostrare gli array
        $carrello='home.tpl';            Ma seondo me json e la cosa piu giusta???   
        
        $v = new VSpesa();
        $v->setSpesa();   
        $v->render();
        */
        $v = new \Views\Spesa();
        $v->setSpesa();
        $v->render();
    }
    
     public function gestore($req){
        $v = new VGestore('nadaaaa');
        $v->render();
     }


    public function default(Request $req){
        return $this->home($req);
    }

    
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