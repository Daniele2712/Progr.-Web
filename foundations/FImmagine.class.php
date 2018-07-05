<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class FImmagini extends Foundation{
    protected static $table = "immagini";

    public static function getImmaginiProdotto($id){
        $DB = Singleton::DB();
        $p = $DB->prepare("
        SELECT id_immagine
        FROM immagini_prodotti
        WHERE immagini_prodotti.id_prodotto = ?");
        if(!$p){
            var_dump($p);
            echo $DB->error();
            die();
        }
        $p->bind_param("i",$id);
        $p->execute();
        $p->bind_result($id_immagine);
        $r = array();
        if($p->fetch()){
            $p->close();
            foreach($id_immagine as $id)
            $r[] = FImmagine::getImmagineByid($id);
        }else
        $p->close();
        return $r;
    }

    public static function getImmagineByid($id){
        $DB = Singleton::DB();
        $p = $DB->prepare("
        SELECT nome, size, type, immagine
        FROM immagini
        WHERE immagini.id = ?");
        if(!$p){
            var_dump($p);
            echo $DB->error();
            die();
        }
        $p->bind_param("i",$id);
        $p->execute();
        $p->bind_result($nome, $size, $type, $img);
        $r = array();
        if($p->fetch()){
            $p->close();
            $r[
                'nome' => $nome,
                'size' => $size,
                'type' => $type,
                'img' => $img
            ];
        }else
        $p->close();
        return $r;
    }
}
?>
