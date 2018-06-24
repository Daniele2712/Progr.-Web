<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class CError{
    public function Error405($req){
        $v = new VError();
        $v->isRest($req->isRest());
        $v->error(405);
    }

    public function ErrorController($req){
        $v = new VError();
        $v->isRest($req->isRest());
        $v->error(404, "Controller Not Found");
    }

    public function ErrorAction($req){
        $v = new VError();
        $v->isRest($req->isRest());
        $v->error(404, "Action Not Found");
    }
}
