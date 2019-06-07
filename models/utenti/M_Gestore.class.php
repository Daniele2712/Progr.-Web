<?php
namespace Models\Utenti;
use \Models\M_Utente as M_Utente;
use \Models\M_Money as M_Money;
use \Models\M_Turno as M_Turno;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class M_Dipendente extends M_Dipendente{
    private $magazzino;

/*  DA MODIFICARE IL COSTRUTTORE, questo che ho qui sotto e il costruttore di dipendente  */
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
    public function getMagazzino(){
      return $this->magazzino;

    }
    public function setMagazzion($id_magazzino){
      $this->magazzino=$id_magazzino;
    }


}
