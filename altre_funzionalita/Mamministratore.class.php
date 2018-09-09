<?php
namespace Models;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}
class Amministratore extends Utente{
    //Attributi
    private $idAmministratore;
    //Costruttori
    public function __construct($idUtente, $datiAnagrafici, $email, $username, int $idAmministratore=0){
        parent::__construct($idUtente, $datiAnagrafici, $email, $username);
        $this->$idAmministratore = $idAmministratore;
    }
    //Metodi
}
?>
