<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

abstract class EUtente extends EDatiAnagrafici{
    private $idUtente;
    private $email;
    private $username;
    private $pasword;

    public function __construct(int $idDati=0, string $nome="", string $cognome="", string $telefono="", DateTime $nascita = null, int $idUtente=0, string $email="", string $username="", string $password=""){
        parent::__construct($idDati, $nome, $cognome, $telefono, $nascita);
        $this->idUtente = $idUtente;
        $this->email = $email;
        $this->username = $username;
        $this->password = $pasword;
    }

    public abstract function fa_cose();
}
