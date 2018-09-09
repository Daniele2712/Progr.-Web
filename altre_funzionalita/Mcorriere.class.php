<?php
namespace Models;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}
class Corriere extends Utente{
    //Attributi
    private $idCorriere;
    private $consegne = array();
    private $magazzino;
    //Costruttori
    public function __construct($idUtente, $datiAnagrafici, $email, $username, int $idCorriere=0, array $consegne = array(), Magazzino $magazzino;){
        parent::__construct($idUtente, $datiAnagrafici, $email, $username);
        $this->idRegistrato = $idRegistrato;
        foreach($consegne as $c){
            $this->consegne[] = clone $c;
        }
        $this->magazzino = clone $magazzino;
    }
    //Metodi
}
?>
