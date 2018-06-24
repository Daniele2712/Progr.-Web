<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}
class CFrontController{
    public function __construct($request){
        $controller = $request->getController();
        $action = $request->getAction();
        if(class_exists($controller)){
            if(method_exists($controller, $action)){
                $real_controller = new $controller();
                $real_controller->$action($request);
            }else{
                $c = new CError();
                if($request->isRest())
                    $c->Error405($request);
                else
                    $c->ErrorAction($request);
            }
        }else{
            $c = new CError();
            $c->ErrorController($request);
        }
    }
}
?>
