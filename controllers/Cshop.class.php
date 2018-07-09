<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}


class Cshop{    
    public function home($req){
        
        $headIncludes='<link rel="stylesheet" type="text/css" href="/templates/css/login.css"/> <link rel="stylesheet" type="text/css" href="/templates/css/home.css"/>';
        $loginOrUserIncludes='login.tpl';
        $contentIncludes='home.tpl';
        $v = new VHome($headIncludes, $loginOrUserIncludes, $contentIncludes);
        $v->render();
    }
    
     public function spesaSenzaLogin($req){
        $IDmagazzino=1;
        $nome='Mario Rossi';
        $categorie=FCategoria::allCategories();
        $filtri=FFiltro::allFilters(); 
        $items=FMagazzino::allItems($IDmagazzino);
        $carrello=FCarrello::getCarrelloItems(); 
        
        
        $v = new VSpesa();
        $divs=$v->createDivs($categorie, $filtri, $items, $carrello);
        
        $v->render();
         
    }
    
    
    public function spesaConLogin($req){
        
        $nome='Mario Rossi';
        $categorie=array('Cat1','Cat2','Cat3','Cat4','Cat5');
        $filtri='login.tpl';            /* Devo trovare un modo per mostrare gli array*/
        $carrello='home.tpl';           /* Ma seondo me json e la cosa piu giusta???*/   
        
        $v = new VSpesa();
        $v->setSpesa();   
        $v->render();
    }
    
    public function gestore($req){
      
        $v = new VGestore('nadaaaa');
        $v->render();
    }

}