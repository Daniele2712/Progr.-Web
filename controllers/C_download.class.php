<?php
namespace Controllers;
use \Views\Request as Request;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class C_download implements Controller{
    public static function image(Request $req){
        $id = $req->getInt(0);
        try{
            $image = \Foundations\F_Immagine::find($id);
        }catch(\SQLException $e){
            Error::error404($req);
        }
        $v = new \Views\Image();
        $v->setImage($image);
        $v->render();
    }

    public static function background(Request $req){
        $id = \Singleton::Settings()->getBackground();
        try{
            $image = \Foundations\F_Immagine::find($id);
        }catch(\SQLException $e){
            Error::error404($req);
        }
        $v = new \Views\Image();
        $v->setImage($image);
        $v->render();
    }

    public static function favicon(Request $req){
        $id = \Singleton::Settings()->getFavicon();
        try{
            $image = \Foundations\F_Immagine::find($id);
        }catch(\SQLException $e){
            Error::error404($req);
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
