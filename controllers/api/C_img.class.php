<?php
namespace Controllers\Api;
use \Controllers\Controller as Controller;
use \Views\Request as Request;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class C_img implements Controller{

    public static function get(Request $req){

        $params=$req->getOtherParams();
        if(sizeof($params)>1)
        {
           self::setError("too_many_params");
        }
        else{


        $path = getcwd()."/templates/img/".$params[0];
        readfile($path);
        return;
        //$path = realpath(dirname(__FILE__)).'/../../templates/img/.settimana15.png';

        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        echo $base64;

  /*      if (file_exists($file)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename($file).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        readfile($file);
    }
    else{
        self::setError('file_dont_exists');
    }*/

        }
    }





    public static function post(Request $req){
    }

    public static function default(Request $req){
        self::get($req);
    }

    private static function setError($error, $var=''){
    switch($error){
    case 'too_many_params':
        http_response_code(400);
        header('Content-type: application/json');
        echo '{
            "message":"You entered too many parameters, we expected only one"}';
        break;

    case 'file_dont_exists':
        http_response_code(400);
        header('Content-type: application/json');
        echo '{
            "message":"the file you are searching for does not exist"}';    /*  Non penso sia sicuro dire alle persone questa informazione*/
        break;

    }
    }



    //uniqid('php_', TRUE) - genera string di 23 catarreri random , se ci metto false come secondo parametro, mi sceglie 13 caratteri


}
