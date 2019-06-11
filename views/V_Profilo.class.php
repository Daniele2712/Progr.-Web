<?php
namespace Views;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class V_Profilo extends HTMLView{

    public function __construct(){
        parent::__construct();
        $this->layout = "layout";
        $this->content = "profilo/profilo";
        $this->addCSS("profilo/css/profilo.css");
        $this->addJS("profilo/js/profilo.js");
        $this->smarty->assign('datiAnagrafici', array("nome"=>"", "cognome"=>"", "telefono"=>""));
    }

    public function setMainAddress(\Models\M_Indirizzo $addr){
        $this->smarty->assign('mainAddress', array(
            "id"=>$addr->getId(),
            "via"=>$addr->getVia(),
            "civico"=>$addr->getCivico(),
            "comune"=>$addr->getComune()->getNome(),
            "id_comune"=>$addr->getComune()->getId(),
            "note"=>$addr->getNote())
        );
    }



    public function setLoggedUser(\Models\M_Utente $user){
        $dati = $user->getDatiAnagrafici();
        $this->smarty->assign('datiAnagrafici', array("nome"=>$dati->getNome(), "cognome"=>$dati->getCognome(), "telefono"=>$dati->getTelefono()));
    }




}
