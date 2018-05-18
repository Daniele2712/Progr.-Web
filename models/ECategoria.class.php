<?php
if(!defined("EXEC")){
    header("location: /index.php");
return;
}

    
public class ECategoria{
	
    private $categoira;
    private $padre;  // se e' inizializzato vuol dire ceh abbiamo una sottocategoria
	
    public function __constructor(string $nome , ECategoria $padre=null){
        
        $this->categoria= $nome;
        $this->padre = $padre;
    }
    
	public function getCategoria():string{
        return $categoira;
	}
}
