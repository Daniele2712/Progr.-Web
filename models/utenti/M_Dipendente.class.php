<?php
namespace Models\Utenti;
use \Models\M_Utente as M_Utente;
use \Models\M_Money as M_Money;
use \Models\M_Turno as M_Turno;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class M_Dipendente extends M_Utente{
    private $ruolo;
    private $tipoContratto;
    private $dataAssunzione;
    private $oreSettimanali;
    private $stipendioOrario;
    private $turni;

    public function __construct($idUtente, $datiAnagrafici, $email, $username, int $id = 0, string $ruolo = '', string $tipoContratto = '', \DateTime $dataAssunzione = NULL, int $oreSettimanali = 0, M_Money $stipendioOrario = NULL, array $turni = array()){
        if($dataAssunzione === NULL)
            $dataAssunzione = new \DateTime();
        if($stipendioOrario === NULL)
            $stipendioOrario = new M_Money(0,1);
        parent::__construct($idUtente, $datiAnagrafici, $email, $username);
        $this->id = $id;
        $this->ruolo = $ruolo;
        $this->tipoContratto = $tipoContratto;
        $this->dataAssunzione = $dataAssunzione;
        $this->oreSettimanali = $oreSettimanali;
        $this->stipendioOrario = $stipendioOrario;
        foreach($turni as $t){
            $this->turni[] = clone $t;
        }
    }

    //TODO: completare la classe

    public function getRuolo(){
        return $this->ruolo;
    }

    public function setRuolo($ruolo){
        $this->ruolo=$ruolo;
    }
    public function removeFromMagazzino(){}

    public function removeTurni(){}

    public function addToMagazzino(int $idMagazzino){}

    public function addTurno(M_Turno $turno){}

    public function editTurno(int $idTurno, M_Turno $turno):int{
        $bool=true;
        foreach($this->turni as $t){
            if($t->getId() == $idTurno){
                $t = clone $turno;
                $bool=false;
            }
        }
        if(TRUE){
            return 1;
        }
        else {
            return 0;
        }
    }

    public function removeTurno(int $idTurno){}

    public function getHisMagazzini(){ // Ritorna un array associativo con id_magazzino => via_magazzino


    }

}
