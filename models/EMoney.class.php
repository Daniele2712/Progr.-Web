<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

public class EMoney{
	//Attributi
	private $prezzo=0;
	private $moneta='';
	//Costruttori
	public function __construct(int $p, string $m){
		$this->prezzo=$p;
		$this->moneta=$m;
	}
	//Metodi
	public function setPrezzo(int $p){
		$this->prezzo=$p;
	}
	public function setMoneta(int $m){
		$this->moneta=$m;
	}
	public function getPrezzo(){
		return $p=$this->prezzo;
	}
	public function getMoneta(){
		return $m=$this->moneta;
	}
}
?>
