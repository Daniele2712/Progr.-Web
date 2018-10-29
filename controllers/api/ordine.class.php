<?php
namespace Controllers\Api;
use \Controllers\Controller as Controller;
use \Views\Request as Request;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class ordine implements Controller{
    
    public static function get(Request $req){
        header('Content-type: application/json');
        $params=$req->getOtherParams();

        //switch (array_shift($params)){
       
        if(in_array("all", $params))
                {
                $session = \Singleton::Session();
                if(!$session->isLogged())       //se NON e' loggato
                    {
                    $v = new \Views\JSONView(array("r"=>403));
                    $v->render();
                    
                    }
                else{                           // se invece E' loggato
                    $userId=$session->getUserId();
                    $orders=\Foundations\Ordine::findByUserId($userId);
                    //
                    
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
                        $response['orderDetails']=\Foundations\Ordine::orderDetailsToJson($idOrder);
                        $response['orderProducts']=\Foundations\Ordine::itemsOfOrderJson($idOrder);
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
                            if(!\Foundations\Ordine::codeExists($orderCode))
                            {
                               $v = new \Views\JSONView();
                               $v->setError("inexistent_code"); 
                            } 
                            else{
                            $order=\Foundations\Ordine::findByCode($orderCode);
                            $idOrder=$order->getId();
                            $response['orderDetails']=\Foundations\Ordine::orderDetailsToJson($idOrder);
                            $response['orderProducts']=\Foundations\Ordine::itemsOfOrderJson($idOrder);
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
    
    

    
    //uniqid('php_', TRUE) - genera string di 23 catarreri random , se ci metto false come secondo parametro, mi sceglie 13 caratteri
    
}
