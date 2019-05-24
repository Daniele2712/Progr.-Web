<?php
namespace Controllers;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

/**
 * classe FrontController, smista le richieste al controller corretto
 */
class FrontController{

    /**
     * in base alla richiesta cerca il controller e il metodo desiderato dal client
     * se non vengono trovati la richiesta viene inviata al controller Error
     *
     * @param    \Views\Request    $request    oggetto che rappresenta la richiesta del client
     */
    public static function route(\Views\Request $request){
        $controller = $request->getController();
        $action = $request->getAction();
        if(class_exists($controller)){
            if(method_exists($controller, $action))
                try{
                    $controller::$action($request);
                }catch(\Exception $e){
                    Error::ErrorException($request, $e);
                }
            else
                if($request->isRest())
                    Error::Error405($request);
                else
                    Error::ErrorAction($request);
        }else
            Error::ErrorController($request);
    }
}
