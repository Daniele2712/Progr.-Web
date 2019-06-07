<?php
namespace Controllers\Api;
use \Controllers\Controller as Controller;
use \Views\Request as Request;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

/*  L'URL di richiesta puo contenere i seguenti parametri
/api/ordine/...
                magazzino/all  magazzino/2
                all
                id/2
                code/2
*/

class C_ordine implements Controller{

public static function get(Request $req){
  //if (!\Singleton::Session()::isAdminOrGestore()) {\Foundations\Log::logMessage("Tentato accesso al Controller di ordini da parte di utenti che non sono gestori ne amministratori", $req); echo "accesso Negato</br>"; return;}

    header('Content-type: application/json');
    $params=$req->getOtherParams();
    /*  Sarebbe meglio far lavorare questo controllore meglio con la F_Ordine::getOrdiniFiltrati, passandogli tutti i parametri in una volta, e sara la F_Ordine a fare un unica ricerca con tutti i filtri. per ora posso usare un unico filtro allavolta*/

    //switch (array_shift($params)){
  if(in_array("magazzino",$params)){        //ATTENZIONE CHE questa parte e' vulnerabile, un utente normale puo vedere tutti gli ordini, devo modificare il codice e aggiungere il controllo per l-utente(gestore e amministratore possono usare magazzino, utenti normali no)

            // In questo caso faccio le chiamate al DB direttamente da qui, poi se ho tempo modifico e le faccio fare alla Foundation

        /*      Questa e la parte che dovrebbe verificare se l-utente e loggato.... devo verificare che vada bene e che gestisce bene l-eventuale utente non loggato
            {
            $session = \Singleton::Session();
            if(!$session->isLogged())       //se NON e' loggato
                {
                $v = new \Views\JSONView(array("r"=>403));
                $v->render();
                }
            else{                           // se invece E' loggato
                $indexId=array_search('id', $params);
                if(!isset($params[$indexId+1]))
                    {
                    $v = new \Views\JSONView();
                    $v->setError("expected_index");
                    }
                else {
                    $idOrder=$params[$indexId+1];
                    $response['orderDetails']=\Foundations\Ordine::orderDetailsToJson($idOrder);
                    $response['orderProducts']=\Foundations\Ordine::itemsOfOrderJson($idOrder);
                    $v = new \Views\JSONView($response);
                    $v->render();
                    }

                }
            }
         *    */
        $indexId=array_search('magazzino', $params);
        $idMag=$params[$indexId+1];
        if($idMag=='all')
        {//verifica che sia un amministratore
            //TODO codice per prendere tutti gli ordini di tutti i magazzini. Deve lavorare con la funzione di F_Ordine getOrdiniFiltrati tipo passandogli il parametro null
        }
        else{

            $idMag=$params[$indexId+1];
            if(\Foundations\F_Magazzino::seek($idMag)) $ordini=\Foundations\F_Ordine::getOrdiniByIdMagazzino($idMag);
            else{/* stampa il fatto ceh non esiste i-id del magazzino che hai inserito*/}

            if(!empty($ordini))echo json_encode($ordini);
            else self::setSuccess("empty");
        }

      }

  elseif(in_array("all", $params)){
            $session = \Singleton::Session();
            if(!$session->isLogged())       //se NON e' loggato
                {
                $v = new \Views\JSONView(array("r"=>403));
                $v->render();

                }
            else{                           // se invece E' loggato
                $userId=$session->getUserId();
                $orders=\Foundations\F_Ordine::findByUserId($userId);
                }
            }

  elseif(in_array("id", $params)){
            $session = \Singleton::Session();
            if(!$session->isLogged())       //se NON e' loggato
                {
                $v = new \Views\JSONView(array("r"=>403));
                $v->render();
                }
            else{                           // se invece E' loggato
                $indexId=array_search('id', $params);
                if(!isset($params[$indexId+1]))
                    {
                    $v = new \Views\JSONView();
                    $v->setError("expected_index");
                    }
                else {
                    $idOrder=$params[$indexId+1];
                    $response['orderDetails']=\Foundations\F_Ordine::orderDetailsToJson($idOrder);
                    $response['orderProducts']=\Foundations\F_Ordine::itemsOfOrderJson($idOrder);
                    $v = new \Views\JSONView($response);
                    $v->render();
                    }

                }
  }

  elseif(in_array("code", $params)){
            $indexId=array_search('code', $params);
                if(!isset($params[$indexId+1]))
                    {
                    $v = new \Views\JSONView();
                    $v->setError("expected_index");
                    }   //da aggiungere l-error expected_code
                else {
                        $orderCode=$params[$indexId+1];
                        if(!\Foundations\F_Ordine::codeExists($orderCode))
                        {
                           $v = new \Views\JSONView();
                           $v->setError("inexistent_code");
                        }
                        else{
                        $order=\Foundations\F_Ordine::findByCode($orderCode);
                        $idOrder=$order->getId();
                        $response['orderDetails']=\Foundations\F_Ordine::orderDetailsToJson($idOrder);
                        $response['orderProducts']=\Foundations\F_Ordine::itemsOfOrderJson($idOrder);
                        $v = new \Views\JSONView($response);
                        $v->render();
                        }
                    }
            }

  else{
        $v = new \Views\JSONView();
        $v->setError("expected_parameter_in_url");
        }
}

public static function post(Request $req){
}

public static function default(Request $req){
    self::get($req);
}



private static function setSuccess($info){
  switch($info){
    case 'empty':
        http_response_code(200);
        echo '{"message":"Everything went right but the result is empty"}';
    break;
  }
}





    //uniqid('php_', TRUE) - genera string di 23 catarreri random , se ci metto false come secondo parametro, mi sceglie 13 caratteri

}
