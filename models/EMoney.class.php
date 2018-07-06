<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class EMoney extends Entity{
	//Attributi
	private $prezzo=0.0;
	private $valuta='';
	//Costruttori
	public function __construct(float $pre, string $val){
		$this->prezzo=$pre;
		$this->valuta=$val;
	}
	//Metodi
	public function setPrezzo(float $pre){
		$this->prezzo=$pre;
	}
	public function setMoneta(string $val){
		$this->valuta=$val;
	}
	public function getPrezzo(){
		return $pre=$this->prezzo;
	}
	public function getValuta(){
		return $val=$this->valuta;
	}
}
?>
