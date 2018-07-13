<?php
namespace Views;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class Gestore extends HTMLView{

    public function __construct($sessione='non puo essere nullo,,,penso,,,dovro mettere una sessone'){ /* Sessione da cui io ricevo il nome del gestore, e poi li faccio la view che deve vedere*/
        //ANDREI: in realtà non ti passo la sessione ma un \Models\Utente
        parent::__construct();
        //$profile=$this.createProfile($sessione);
        //$content=createContent();
        $this->layout = "layout";       
        $this->content = "gestore/gestore";
        $this->smarty->assign('templateHeadIncludes', '<link rel="stylesheet" type="text/css" href="/templates/css/profile.css"/> <link rel="stylesheet" type="text/css" href="/templates/css/gestore.css"/>');                   /* Deve essere formato <link rel="stylesheet" type="text/css" href="...>*/
        
        $this->smarty->assign('username', 'Gestor Mario');
        $this->smarty->assign('templateLoginOrProfileIncludes', '/profile/profile.tpl');     /* Deve essere un template   */
        $this->addJS("profile/js/profile.js");
        $this->addCSS("profile/css/profile.css");
        
        $this->smarty->assign('templateContentIncludes', 'contents/gestore/gestore.tpl');             /* Deve essere un template*/
        $this->addCSS('gestore/css/gestore.css');
        $this->addJS('gestore/js/gestore.js');
        
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
