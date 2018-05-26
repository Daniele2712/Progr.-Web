<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class EUtenteRegistrato extends EUtente{
    private $idRegistrato;
    private $pagamenti = array();
    private $indirizzi = array();
    private $carrelli = array();

    public function __construct(int $idDati=0, $nome, $cognome, $telefono, $nascita, $idUtente, $email, $username, $password, int $idRegistrato=0, array $pagamenti=array(), array $indirizzi=array(), array $carrelli=array(), string $email=""){
        parent::__construct($idDati, $nome, $cognome, $telefono, $nascita, $idUtente, $email, $username, $password);
        $this->idRegistrato = $idRegistrato;
        foreach($pagamenti as $p){
            $this->pagamenti[] = clone $p;
        }
        foreach($indirizzi as $i){
            $this->indirizzi[] = clone $i;
        }
        foreach($carrelli as $c){
            $this->carrelli[] = clone $c;
        }
        $this->email = $email;
    }
}
