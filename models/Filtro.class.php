<?php
namespace Models;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class Filtro extends Model{
	//Attributi
	private $nome="";
	private $sottocategoria;
	private $valori=array();
	//Costruttori
	public function __construct(string $nome="", Categoria $sottocategoria){
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
