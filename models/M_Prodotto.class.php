<?php
namespace Models;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class M_Prodotto extends Model{
	//Attributi
	private $nome="";
	private $info="";
	private $descrizione="";
	private $categoria;
	private $prezzo;            //Money
	private $tag=array();
    private $fotoPreferita;
    private $foto = array();
    private $valori = array();
	//Costruttori
	public function __construct(int $id, string $nome,string $info, string $descrizione, M_Categoria $cat, M_Money $price, array $valori=array(), \Models\M_Immagine $fotoPreferita, array $foto){
        $this->id = $id;
    	$this->nome = $nome;
        $this->info=$info;
        $this->descrizione=$descrizione;
		$this->categoria = $cat;
		$this->prezzo = $price;
        $this->valori = $valori;
        $this->fotoPreferita = clone $fotoPreferita;
        foreach ($foto as $f)
            $this->foto[] = clone $f;
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
            return $this->categoria->hasCat($idCategoria);
    }

	public function setInfo($i){  $this->info = $i;}
	public function setDescrizione($d){  $this->descrizione = $d;}
    public function setTag(array $t){  $this->tag = array($t);}
    public function getNome(){  return $this->nome; }
    public function getPrezzo() : \Models\M_Money{  return clone $this->prezzo;  }
    public function getInfo(){  return $this->info;}
    public function getDescrizione(){ return $this->descrizione;  }
    public function getCategoriaId(){ return $this->categoria->getId();  }

    public function getImmagini():array{
        $r = array();
        foreach($this->foto as $f){
            $r[] = clone $f;
        }
        return $r;
    }

    public function getFotoPreferita(){return clone $this->fotoPreferita;}
    public function setFotoPreferita(M_Immagine $img){
        $this->fotoPreferita = clone $img;
    }

    public function getOtherFoto(){return $this->foto;}
    public function addOtherFoto(M_Immagine $img){
        $this->foto[]=clone $img;
    }


}
