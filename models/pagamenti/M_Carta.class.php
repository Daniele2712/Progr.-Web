<?php
namespace Models\Pagamenti;
use \Models\M_Pagamento as M_Pagamento;
use \Views\Request as Request;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class M_Carta extends M_Pagamento{
    private $idCarta;
    private $numeroCarta;
    private $cvv;
    private $nome;
    private $cognome;
    private $dataScadenza;

    public function __construct(int $idPagamento, int $idCarta, string $numCarta, int $cvv, string $nome, string $cognome, \DateTime $dataScadenza){
        parent::__construct($idPagamento);
        $this->idCarta = $idCarta;
        $this->numeroCarta = $numCarta;
        $this->cvv = $cvv;
        $this->nome = $nome;
        $this->cognome = $cognome;
        $this->dataScadenza = $dataScadenza;
    }


    private function verificaScadenza(){

    }

    private function verificaCredenziali(){

        // vede se i dati inviati sono nei range ammisibili, e toglie i caratteri illegali....
    }

    public function paga(){

        //non ho ancora la minima idea di come si faccia

    }

    public static function newPayment(Request $req): M_Pagamento{
        $numero = $req->getString("carta_num","","POST");
        $nome = $req->getString("carta_nome","","POST");
        $cognome = $req->getString("carta_cognome","","POST");
        $scadenza = new \DateTime();//$req->getString("carta_scadenza","","POST");
        $cvv = $req->getInt("carta_cvv",0,"POST");
        return new M_Carta(0, 0, $numero, $cvv, $nome, $cognome, $scadenza);
    }

    public function getIdCarta(): int{
        return $this->idCarta;
    }

    public function getNumero(): string{
        return $this->numeroCarta;
    }

    public function getNome(): string{
        return $this->nome;
    }

    public function getCognome(): string{
        return $this->cognome;
    }

    public function getCvv(): int{
        return $this->cvv;
    }

    public function getScadenza(): \DateTime{
        return clone $this->dataScadenza;
    }
}
