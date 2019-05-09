<?php
namespace Models;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class M_Filtro extends Model{
	//Attributi
	private $nome = "";
	private $sottocategoria = NULL;
    private $filtrabile = FALSE;
    private $tipo = "";
	private $opzioni = array();
    private $valore;
	//Costruttori
	public function __construct(int $id, string $nome = "", bool $filtrabile, string $tipo, M_Categoria $sottocategoria = NULL, array $opzioni = array()){
        $this->id = $id;
		$this->nome = $nome;
        $this->tipo = $tipo;
        $this->filtrabile = $filtrabile;
        if($sottocategoria !== NULL)
		      $this->sottocategoria = clone $sottocategoria;
        $this->opzioni = $opzioni;
	}
	//Metodi
	public function getParams(\Views\Request $req){
        if($this->tipo == "range"){
            $this->valore = array(
                $req->getFloat("filter_".$this->nome."_min",0,"POST"),
                $req->getFloat("filter_".$this->nome."_max",0,"POST")
            );
        }elseif($this->tipo == "multicheckbox"){
            $this->valore = $req->getArray("filter_".$this->nome,array(),"POST");
        }else{
            $this->valore = $req->getString("filter_".$this->nome,"","POST");
        }
    }

    public function filtra($valore): bool{
        switch($this->tipo){
            case "range":
                return ($valore >= $this->valore[0] && $valore <= $this->valore[1] || ($this->valore[0] == 0 && $this->valore[1] == 0));
            case "value":
            case "radio":
            case "checkbox":
                return ($valore === $this->valore || $this->valore === "");
            case "multicheckbox":
                return array_intersect($this->valore, $valore) === $this->valore;
        }
        return FALSE;
    }

	public function getNome(){
		return $this->nome;
	}

	public function getTipo(){
		return $this->tipo;
	}

	public function getOpzioni(){
		return $this->opzioni;
	}

    public function getValore(){
        return $this->valore;
    }
}
