<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class EProdotto{
	//Attributi
  private $id=0;
	private $nome="";
	private $info="";
	private $descrizione="";
	private $sottocategoria;
	private $prezzo;
	private $tag=array();
	//Costruttori
	public function __construct(string $nome, ECategoria $cat, EMoney $price){
		$this->nome = $nome;
		$this->sottocategoria = $cat;
		$this->prezzo = $price;
	}
	//Metodi
	public function setInfo($i){
		$this->info = $i;
	}
	public function setDescrizione($d){
		$this->descrizione = $d;
	}
	public function setTag(array $t){
        $this->tag = array($t);
	}
	public function getPrezzo(){
		return $m = $this->prezzo;
	}
}
