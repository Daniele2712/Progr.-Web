<?php
namespace Controllers\Api;
use \Controllers\Controller as Controller;
use \Views\Request as Request;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class C_ordine implements Controller{

    public static function get(Request $req){
        header('Content-type: application/json');
        $params=$req->getOtherParams();

        //switch (array_shift($params)){
        if(in_array("magazzino",$params))        //ATTENZIONE CHE questa parte e' vulnerabile, un utente normale puo vedere tutti gli ordini, devo modificare il codice e aggiungere il controllo per l-utente(gestore e amministratore possono usare magazzino, utenti normali no)
        {
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
                //codice per l-amministratore (da fare)
            }
            else{//vuol dire che e' un gestore
                /*
                La cosa che ritorna sara' un Json  del tipo:
                 *
                 * id_ordine
                 * tipo_ordine
                 * cap_indirizzo_ordine
                 * nome_indirizzo_ordine
                 * provincia_indirizzo_ordine
                 * via_indirizzo_ordine
                 * civico_indirizzo_ordine
                 * nome_utente_ordine
                 * cognome_utente_ordine
                 * subtotale_ordine
                 * spedizione_ordine
                 * totale_ordine
                 * simbolo_valuta_ordine
                 * data_ordine
                 * consegna_ordine
                 *
                 */

                $ordini=\Singleton::DB()->query("SELECT ordini.id as id_ordine, ordini.tipo_pagamento as tipo_ordine, comuni.CAP as cap_indirizzo_ordine, comuni.nome as nome_indirizzo_ordine, comuni.provincia as provincia_indirizzo_ordine, indirizzi.via as via_indirizzo_ordine, indirizzi.civico as civico_indirizzo_ordine, dati_anagrafici.nome as nome_utente_ordine, dati_anagrafici.cognome as cognome_utente_ordine, ordini.subtotale as subtotale_ordine, ordini.spese_spedizione as spedizione_ordine, ordini.totale as totale_ordine, valute.simbolo as simbolo_valuta_ordine, ordini.data_ordine as data_ordine, ordini.ora_consegna as consegna_ordine FROM ordini,indirizzi,comuni,valute,dati_anagrafici WHERE ordini.id_dati_anagrafici=dati_anagrafici.id AND ordini.id_indirizzo=indirizzi.id AND comuni.id=indirizzi.id_comune AND ordini.id_valuta=valute.id AND ordini.id_magazzino=$idMag");

                while($r = $ordini->fetch_assoc()) {$rows[] = $r;}
                    if(isset($rows)) echo json_encode($rows);
                    else self::setSuccess("empty");

            }

        }
        elseif(in_array("all", $params))
                {
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
       elseif(in_array("id", $params))
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
                        $response['orderDetails']=\Foundations\F_Ordine::orderDetailsToJson($idOrder);
                        $response['orderProducts']=\Foundations\F_Ordine::itemsOfOrderJson($idOrder);
                        $v = new \Views\JSONView($response);
                        $v->render();
                        }

                    }
                }
        elseif(in_array("code", $params))
                {
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
        $cmd = $req->getString("type","","POST");
        switch($cmd){
            case 'PayPal':
                $session = \Singleton::Session();
                if($session->timedOut() || $session->isNew()){
                    $session->setMessage("Sessione scaduta per inattivit&agrave;");
                    $v = new \Views\JSONView(array("r"=>303, "url"=>"/"));
                    return $v->render();
                }
                $ordine = \Models\M_Ordine::nuovo($req);
                $v = new \Views\Api\V_OrdinePaypal(array("r"=>200));
                $v->setOrder($ordine);
                return $v->render();
                break;
        }
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
