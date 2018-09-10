<?php
namespace Models;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class Money extends Model{
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
	public function setValuta(string $val){
		$this->valuta=$val;
	}
	public function getPrezzo(){
		return $this->prezzo;
	}
	public function getValuta(){
		return $this->valuta;
	}
}
