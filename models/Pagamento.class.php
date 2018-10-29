<?php
namespace Models;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

//  chi e' che crea l-ordine, e chi se se lo ricorda??? il cestino?? il cliente??


abstract class Pagamento extends Model{
    private $idPagamento;
    private $valuta = "EUR";    //da cambiare o eventualmente eliminare xke ogni utente ha la propira preferenza ocn la valuta

    public function __construct(int $idPagamento){
        $this->idPagamento = $idPagamento;
    }

    public abstract function createPayment();

    public function getId(): int{
        return $this->idPagamento;
    }
    public abstract function paga();
    public abstract function sceglivaluta();

}
