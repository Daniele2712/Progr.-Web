<?php
namespace Controllers\Api;
use \Controllers\Controller as Controller;
use \Views\Request as Request;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class comune implements Controller{
    public function get(Request $req){
        echo $req->getInt(0);
    }

    public function search(Request $req){
        $search = $req->getString(0);
        $comuni = \Foundations\Comune::searchByName($search);
        $v = new \Views\Api\Comuni();
        $v->setComuni($comuni);
        $v->render();
    }

    /**
     * azione di default
     */
    public function default(Request $req){
        return $this->get($req);
    }
}
