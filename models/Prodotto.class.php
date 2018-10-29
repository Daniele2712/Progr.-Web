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
	private $prezzo;            //Money
	private $tag=array();
    private $foto = array();
    private $fotoPreferita = array();
    private $valori = array();
	//Costruttori
	public function __construct(int $id, string $nome, Categoria $cat, Money $price, array $valori){
        $this->id = $id;
		$this->nome = $nome;
		$this->sottocategoria = $cat;
		$this->prezzo = $price;
        $this->foto = \Foundations\Immagine::findByProduct($this->id);
        $this->fotoPreferita = \Foundations\Immagine::findFavouriteByProduct($this->id);
        $this->valori = $valori;
    }
	//Metodi
	public function filter(array $filters):bool{
        foreach($filters as $filtro){
            if($filtro->getNome() === "prezzo")         //questo è un filtro particolare, è hardcodato
                $valore = $this->prezzo->getPrezzo();
            else                                        //qui vanno i filtri normali, quelli modificabili per intenderci
                $valore = $this->valori[$filtro->getNome()];
            if(!$filtro->filtra($valore))
                return FALSE;
        }
        return TRUE;
    }
	public function hasCat(int $idCategoria = 0){
        if($idCategoria === 0)
            return true;
        else
            return $this->sottocategoria->hasCat($idCategoria);
    }

	public function setInfo($i){
        $this->info = $i;
    }

	public function setDescrizione($d){
        $this->descrizione = $d;
    }

	public function setTag(array $t){
        $this->tag = array($t);
    }

    public function getNome(){
        return $this->nome;
    }

	public function getPrezzo() : \Models\Money{
        return clone $this->prezzo;
    }

    public function getInfo(){
        return $this->info;
    }

    public function getDescrizione(){
        return $this->descrizione;
    }

    public function getCategoriaId(){
        return $this->categoria->getid();
    }

    public function getImmaginePreferita():Immagine{
        return clone $this->fotoPreferita;
    }

    public function getImmagini():array{
        $r = array();
        foreach($this->foto as $f){
            $r[] = clone $f;
        }
        return $r;
    }

}
