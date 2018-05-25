<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

abstract class EOfferta{
	//Attributi
  private $tipo='';
  private $data_inizio;
  private $data_fine;
  //Costruttori
  private function __construct(string $tipo, DateTime $data_inizio, DateTime $data_fine){
    $this->tipo = $tipo;
    $this->data_inizio = $data_inizio;
    $this->data_fine = $data_fine;
  }
	//Metodi
	abstract public function VerificaOfferte(array &$items){
	}
}
