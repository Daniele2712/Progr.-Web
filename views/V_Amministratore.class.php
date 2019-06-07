<?php
namespace Views;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class V_Amministratore extends HTMLView{

    public function __construct($sessione='non puo essere nullo,,,penso,,,dovro mettere una sessone'){ /* Sessione da cui io ricevo il nome del gestore, e poi li faccio la view che deve vedere*/
        //ANDREI: in realtà non ti passo la sessione ma un \Models\Utente
        parent::__construct();
        //$profile=$this.createProfile($sessione);
        //$content=createContent();
        $this->layout = "layout";
        $this->content = "amministratore/amministratore";

        $this->addCSS('gestore/css/gestore.css');   // Dato che la maggior parte della pagina e' in comune con il gestore, uso li stile e il javascript che ho usato per il gestore per stilizzare anche l-amministratore
        $this->addJS('gestore/js/gestore.js');      // In questo modo se devo fare una modifica la faccio solo al file del gestore
        $this->addCSS('amministratore/css/amministratore.css');     // in css e js del amministratore metto solo cose che appartengono al amministratore
        $this->addJS('amministratore/js/amministratore.js');

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
