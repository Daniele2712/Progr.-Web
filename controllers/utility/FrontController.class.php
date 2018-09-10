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
    public function __construct(\Views\Request $request){
        $controller = $request->getController();
        $action = $request->getAction();
        if(class_exists($controller)){
            if(method_exists($controller, $action)){
                $real_controller = new $controller();
                $real_controller->$action($request);
            }else{
                $c = new Error();
                if($request->isRest())
                    $c->Error405($request);
                else
                    $c->ErrorAction($request);
            }
        }else{
            
            $c = new Error();
            $c->ErrorController($request);
        }
    }
}
