<?php
namespace Models\Pagamenti;
use \Models\M_Pagamento as M_Pagamento;
use \Views\Request as Request;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class M_Paypal implements M_Pagamento{

    private $pagato = false;
    private $email="";  // pero se usiamo le api di paypal, penso che non ci dobbiamo ricordare noi email e pass
    private $pass="";// pero se usiamo le api di paypal, penso che non ci dobbiamo ricordare noi email e pass
  public function __construct(){}

    public function paga(){

        //dovrebbe usare il sito della paypal e fare il pagamento la

    }
}
