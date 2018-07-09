<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class VGestore extends HTMLView{
    
    public function __construct($sessione='non puo essere nullo,,,penso,,,dovro mettere una sessone'){ /* Sessione da cui io ricevo il nome del gestore, e poi li faccio la view che deve vedere*/
        parent::__construct();
        //$profile=$this.createProfile($sessione);
        //$content=createContent();
        $this->smarty->assign('username', 'Gestor Mario');
        $this->smarty->assign('templateHeadIncludes', '<link rel="stylesheet" type="text/css" href="/templates/css/profile.css"/> <link rel="stylesheet" type="text/css" href="/templates/css/gestore.css"/>');                   /* Deve essere formato <link rel="stylesheet" type="text/css" href="...>*/
        $this->smarty->assign('templateLoginOrUserIncludes', 'profile.tpl');     /* Deve essere un template   */
        $this->smarty->assign('templateContentIncludes', 'gestore.tpl');             /* Deve essere un template*/
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