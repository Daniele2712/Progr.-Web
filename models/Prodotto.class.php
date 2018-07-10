<?php
namespace Models;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class Prodotto extends Model{
	//Attributi
	private $nome="";
	private $info="";
	private $descrizione="";
	private $sottocategoria;
	private $prezzo;
	private $tag=array();
	//Costruttori
	public function __construct(int $id, string $nome, Categoria $cat, Money $price){
        $this->id = $id;
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
		return $this->prezzo;
	}
    public function getInfo(){return $this->info;}
    public function getDescrizione(){return $this->Descrizione;}
    public function getCategoriaId(){return $this->categoria->getid();}

}
