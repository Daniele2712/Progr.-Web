<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

abstract class EOfferta{
	//Attributi
    protected $idOfferta;
    protected $tipo;
    protected $data_inizio;
    protected $data_fine;

    //Costruttori
    protected function __construct(int $idOfferta, string $tipo, DateTime $data_inizio, DateTime $data_fine){
        $this->idOfferta = $idOfferta;
        $this->tipo = $tipo;
        $this->data_inizio = $data_inizio;
        $this->data_fine = $data_fine;
    }
	//Metodi
	abstract public function VerificaOfferte(array &$items);
}
