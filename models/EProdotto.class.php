<?php
if(!defined("EXEC"))
	return;
class EProdotto{
	//Attributi
	private $nome="";
	private $info="";
	private $descrizione="";
	private $categoria="";
	private $sottocategoria="";
	private $prezzo;
	private $tag=array();
	//Costruttori
	public function __construct(String $n, String $c, String $sc, Money $p)
	{
		$this->nome=$n;
		$this->categoria=$c;
		$this->sottocategoria=$sc;
		$this->prezzo=$p;
	}
	//Metodi
	public function setInfo($i){
		$this->info=$i;
	}
	public function setDescrizione($d){
		$this->descrizione=$d;
	}
	public function setTag(){
		
	}
}
?>