<?php
if(!defined("EXEC")){
    header("location: /index.php");
    return;
}

class ECategoria{
	//Attributi
    private $categoria;
    private $padre;  // se e' inizializzato vuol dire che abbiamo una sottocategoria
	//Costruttori
    public function __construct(string $nome , ECategoria $padre=null){
        $this->categoria = $nome;
        $this->padre = $padre;
    }
    //Metodi
	public function getCategoria():string{
        return $categoria;
	}
}
