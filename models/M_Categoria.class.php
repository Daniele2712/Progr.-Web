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

    public function getFather(): M_Categoria{
        if($this->padre !== NULL)
            return clone $this->padre;
        throw new \ModelException("Father not found", __CLASS__, array("id"=>$this->getId()), 0);
    }

    public function isSubcategory(): bool{
        return $this->padre !== NULL;
    }
}
