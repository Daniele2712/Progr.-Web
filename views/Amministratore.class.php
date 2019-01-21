<?php
namespace Views;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class Amministratore extends HTMLView{

    public function __construct($sessione='non puo essere nullo,,,penso,,,dovro mettere una sessone'){ /* Sessione da cui io ricevo il nome del gestore, e poi li faccio la view che deve vedere*/
        //ANDREI: in realtà non ti passo la sessione ma un \Models\Utente
        parent::__construct();
        //$profile=$this.createProfile($sessione);
        //$content=createContent();
        $this->layout = "layout";       
        $this->content = "amministratore/amministratore";
        $this->smarty->assign('templateHeadIncludes', '<link rel="stylesheet" type="text/css" href="/templates/css/profile.css"/> <link rel="stylesheet" type="text/css" href="/templates/css/amministratore.css"/>');                   /* Deve essere formato <link rel="stylesheet" type="text/css" href="...>*/
        
        $this->smarty->assign('username', 'Gestor Mario');
        $this->smarty->assign('templateLoginOrProfileIncludes', '/profile/profile.tpl');     /* Deve essere un template   */
        $this->addJS("profile/js/profile.js");
        $this->addCSS("profile/css/profile.css");
        
        $this->smarty->assign('templateContentIncludes', 'contents/amministratore/amministratore.tpl');             /* Deve essere un template*/
        $this->addCSS('amministratore/css/amministratore.css');
        $this->addJS('amministratore/js/amministratore.js');
        
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
