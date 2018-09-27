<?php
namespace Models;
if(!defined("EXEC")){
    header("location: /index.php");
    return;
}

class Categoria extends Model{
	//Attributi
    private $categoria;
    private $padre;  // se e' inizializzato vuol dire che abbiamo una sottocategoria
	//Costruttori
    public function __construct(int $id, string $nome , Categoria $padre=null){
        $this->id = $id;
        $this->categoria = $nome;
        $this->padre = $padre;
    }
    //Metodi
	public function getNome():string{
        return $this->categoria;
	}
    public function getPadreid(){
        $this->padre->getid();
    }
}
