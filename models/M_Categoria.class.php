<?php
namespace Models;
if(!defined("EXEC")){
    header("location: /index.php");
    return;
}

class M_Categoria extends Model{
	//Attributi
    private $categoria;
    private $padre;  // se e' inizializzato vuol dire che abbiamo una sottocategoria
	//Costruttori
    public function __construct(int $id, string $nome , M_Categoria $padre=null){
        $this->id = $id;
        $this->categoria = $nome;
        $this->padre = $padre;
    }
    //Metodi
    public function hasCat(int $idCat){
        if($this->id === $idCat)
            return true;
        elseif(isset($this->padre))
            return $this->padre->hasCat($idCat);
        return false;
    }

    public function getAncestors(): array{
        $r = array();
        if($this->padre !== NULL)
            $r = $this->padre->getAncestors();
        $r[] = $this->id;
        return $r;
    }

	public function getNome():string{
        return $this->categoria;
	}
    public function getPadreid(){
        $this->padre->getid();
    }
}
