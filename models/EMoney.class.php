<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

public class EMoney{
	//Attributi
	private $prezzo=0;
	private $valuta='';
	//Costruttori
	public function __construct(int $pre, string $val){
		$this->prezzo=$pre;
		$this->valuta=$val;
	}
	//Metodi
	public function setPrezzo(int $pre){
		$this->prezzo=$pre;
	}
	public function setMoneta(int $val){
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
