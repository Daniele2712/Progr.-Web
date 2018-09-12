<?php
namespace Models;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class Dipendente extends Utente{
    private $id;
    private $ruolo;
    private $tipoContratto;
    private $dataAssunzioni;
    private $oreSettimanali;
    private $stipendioOrario;
    private $turni;

    public function __construct($idUtente, $datiAnagrafici, $email, $username, int $id = 0, string $ruolo = '', string $tipoContratto = '', DateTime $dataAssunzioni = new DateTime(), int $oreSettimanali = 0, Money $stipendioOrario = new Money(0,'EUR'), Turno $turni = new Turno()){
        parent::__construct($idUtente, $datiAnagrafici, $email, $username);
        $this->id = $id;
        $this->ruolo = $ruolo;
        $this->tipoContratto = $tipoContratto;
        $this->dataAssunzioni = $dataAssunzioni;
        $this->oreSettimanali = $oreSettimanali;
        $this->stipendioOrario = $stipendioOrario;
        $this->turni = $turni;
    }
}
