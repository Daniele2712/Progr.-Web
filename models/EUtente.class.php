<?php
if(!defined("EXEC"))
	return;

class EUtente{
    private $nome;
    private $cognome;
    private $telefono;
    private $dataNascita;

    public function __construct(string $nome="", string $cognome="", string $telefono="", DateTime $nascita = null){
        $this->nome = $nome;
        $this->cognome = $cognome;
        $this->telefono = $telefono;
        if($nascita === null)
            $this->dataNascita = new DateTime();
        else
            $this->dataNascita = clone $nascita;
    }
}
