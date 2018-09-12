<?php
namespace Controllers;
use \Views\Request as Request;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class download implements Controller{
    public function image(Request $req){
        $id = $req->getInt(0);
        try{
            $image = \Foundations\Immagine::find($id);
        }catch(\SQLException $e){
            $c = new Error();
            $c->error404($req);
        }
        $v = new \Views\Image();
        $v->setImage($image);
        $v->render();
    }

    public function default(Request $req){
        return image($req);
    }
}
?>
