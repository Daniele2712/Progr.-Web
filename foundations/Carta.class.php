<?php
namespace Foundations;
use \Models\Model as Model;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class Carta{
    protected static $table = "carte";

    public static function create_payment(int $id_pagamento): \Models\Carta{
        $sql = "SELECT id, numero, cvv, nome, cognome, data_scadenza FROM ".self::$table." WHERE id_pagamento = ?";
        $p = \Singleton::DB()->prepare($sql);
        $p->bind_param("i",$id_pagamento);
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $p->bind_result($idCarta, $num, $cvv, $nome, $cognome, $data_scadenza);
        $r = $p->fetch();
        if($r === FALSE)
            throw new \SQLException("Error Fetching Statement", $sql, $p->error, 4);
        elseif($r === NULL)
            throw new \ModelException("Model Not Found", __CLASS__, array("id"=>$id_pagamento), 0);
        $p->close();

        return new \Models\Carta($id_pagamento, $idCarta, $num, $cvv, $nome, $cognome, $dataScadenza);
    }
}
