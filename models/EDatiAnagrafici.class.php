<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class EDatiAnagrafici{
    private $idDatiAnagrafici;
    private $nome;
    private $cognome;
    private $telefono;
    private $dataNascita;

    public function __construct(int $id=0, string $nome="", string $cognome="", string $telefono="", DateTime $nascita = null){
        $this->idDatiAnagrafici = $id;
        $this->nome = $nome;
        $this->cognome = $cognome;
        $this->telefono = $telefono;
        if($nascita === null)
            $this->dataNascita = new DateTime();
        else
            $this->dataNascita = clone $nascita;
    }
}