<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class VSpesa extends HTMLView{
    protected $header='';       /* Andora da riempire con il css ed eventual js che fara funzionare la pagina Vspesa*/
    protected $categorie='<div class="vuoto"></div>';
    protected $filtri='<div class="vuoto"></div>';
    protected $carrelllo='<div class="vuoto"></div>';
    protected $items='<div class="vuoto"></div>';
/*   DEVO mettere anche qui in qualche modo i template header*/
    public function HTMLRender(){
    }

        
    
    public function createDivs($categorie_json , $filtri_json , $items_json , $carrello_json){ /*il json alla fine l-ho aggiunto solo x far capire che si tratta di dati codificati json*/
        
        /* Questa funzione prende in ingresso i json di categorie, filtri, item e item del carrello e crea le rispettive DIV da inserire nel template */
       $categorie=createCategorie($categorie_json); 
       $filtri=createFiltri($filtri_json);
       $items=createItems($items_json);
       $carrello=createCarrello($carrello_json);
       
       return array($categorie, $filtri, $items, $carrello);
               
    }
    
    public function createCategorie($json){
        
    }
    
    
     public function createFiltri($json){
        
    }
    
     public function createCarrello($json){  /* qui entra in gioco la sessione, xke tu fai vedere al tizio il SUO carello, quindi devi sapere chi sia*/
        
    }
    
    public function createItems($json){
        
    }
    
    public function createContent($json){
        
    }
    
    }
