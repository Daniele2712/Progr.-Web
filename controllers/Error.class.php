<?php
namespace Controllers;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class Error{
    public function Error405($req){
        $v = new \Views\Error();
        $v->isRest($req->isRest());
        $v->error(405);
    }

    public function ErrorController($req){
        $v = new \Views\Error();
        $v->isRest($req->isRest());
        $v->error(404, "Controller Not Found");
    }

    public function ErrorAction($req){
        $v = new \Views\Error();
        $v->isRest($req->isRest());
        $v->error(404, "Action Not Found");
    }
}
