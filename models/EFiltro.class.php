<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class EFiltro extends Entity{
	//Attributi
	private $nome="";
	private $sottocategoria;
	private $valori=array();
	//Costruttori
	public function __construct(string $nome="", ECategoria $sottocategoria){
		$this->nome = $nome;
		$this->sottocategoria = $sottocategoria;
	}
	//Metodi
	public function getNome(){
		return $t=$this->nome;
	}
	public function setValori(array $v){

	}
}
