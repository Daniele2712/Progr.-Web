<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class EFiltro{
	//Attributi
	private $nome="";
	private $sottocategoria;
	private $valori=array();
	//Costruttori
	public function __construct(string $nome="", string $cat=""){
		$this->nome = $nome;
		$this->sottocategoria = $cat;
	}
	//Metodi
}
