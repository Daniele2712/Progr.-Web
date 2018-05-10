<?php
if(!defined("EXEC"))
	return;

class EFiltro{
	//Attributi
	private $nome="";
	private $categoria="";
	private $sottocategoria="";
	private $valori=array();
	//Costruttori
	public function __construct(string $n="", string $c="", string $s=""){
		$this->nome=$n;
		$this->categoria=$c;
		$this->sottocategoria=$s;
	}
	//Metodi
}
