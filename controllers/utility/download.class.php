<?php
namespace Controllers;
use \Views\Request as Request;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class download implements Controller{
    public static function image(Request $req){
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

    public static function background(Request $req){
        $id = \Models\Settings::getBackground();
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

    public static function default(Request $req){
        return self::image($req);
    }
}
?>
