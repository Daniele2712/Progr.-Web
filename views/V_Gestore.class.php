<?php
namespace Views;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class V_Gestore extends HTMLView{

    public function __construct($sessione='non puo essere nullo,,,penso,,,dovro mettere una sessone'){ /* Sessione da cui io ricevo il nome del gestore, e poi li faccio la view che deve vedere*/
        //forse non c-e piu bisogno del parametro in ingresso, perche HTMLView gestisce la sessione e si prende da solo il nome del utente loggato :D
        parent::__construct();
        //$profile=$this.createProfile($sessione);
        //$content=createContent();
        $this->layout = "layout";
        $this->content = "gestore/gestore";

        $this->addCSS('gestore/css/gestore.css');
        $this->addJS('gestore/js/gestore.js');

        /*  aggiungo css e js per far funzionare la lightbox delle statistiche    */
        $this->addCSS('lightbox/css/lightbox.min.css');
        $this->addJS('lightbox/js/lightbox.min.js');

    }

    public function HTMLRender(){

    }

    public function createProfile($sessione){
        return "aaa";
    }

    public function createContent(){
       return "aaa";

    }




}
