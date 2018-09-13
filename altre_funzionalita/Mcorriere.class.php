<?php
namespace Models;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}
class Corriere extends Dipendente{
    //Attributi
    private $idCorriere;
    private $consegne = array();
    //Costruttori
    public function __construct($idUtente, $datiAnagrafici, $email, $username, $id, $ruolo, $tipoContratto, $dataAssunzioni, $oreSettimanali, $stipendioOrario, $turni, int $idCorriere=0, array $consegne = array()){
        parent::__construct($idUtente, $datiAnagrafici, $email, $username, $id, $ruolo, $tipoContratto, $dataAssunzioni, $oreSettimanali, $stipendioOrario, $turni)
        $this->idCorriere = $idCorriere;
        foreach($consegne as $c){
            $this->consegne[] = clone $c;
        }
    }
    //Metodi
}
?>
