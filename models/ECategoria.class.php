<?php
if(!defined("EXEC")){
    header("location: /index.php");
    return;
}

class ECategoria{
	//Attributi
    private $id;
    private $categoria;
    private $padre;  // se e' inizializzato vuol dire che abbiamo una sottocategoria
	//Costruttori
    public function __construct(int $id, string $nome , ECategoria $padre=null){
        $this->id = $id;
        $this->categoria = $nome;
        $this->padre = $padre;
    }
    //Metodi
	public function getCategoria():string{
        return $categoria;
	}
    public function getPadreid(){
        $this->padre->getid();
    }
    public function getid(){
        return $this->id;
    }
}
