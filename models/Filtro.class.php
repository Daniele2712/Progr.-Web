<?php
namespace Models;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class Filtro extends Model{
	//Attributi
	private $nome = "";
	private $sottocategoria = NULL;
    private $filtrabile = FALSE;
    private $tipo = "";
	private $opzioni = array();
	//Costruttori
	public function __construct(int $id, string $nome = "", bool $filtrabile, string $tipo, Categoria $sottocategoria = NULL, array $opzioni = array()){
        $this->id = $id;
		$this->nome = $nome;
        $this->tipo = $tipo;
        $this->filtrabile = $filtrabile;
        if($sottocategoria !== NULL)
		      $this->sottocategoria = clone $sottocategoria;
        $this->opzioni = $opzioni;
	}
	//Metodi
	public function getNome(){
		return $this->nome;
	}

	public function getTipo(){
		return $this->tipo;
	}

	public function getOpzioni(){
		return $this->opzioni;
	}

	public function setValori(array $v){

	}
}
