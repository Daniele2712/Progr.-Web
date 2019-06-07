<?php
namespace Foundations\Pagamenti;
use \Foundations\Foundation as Foundation;
use \Models\Model as Model;
use \Models\Pagamenti\M_PayPal as M_PayPal;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class F_PayPal extends Foundation{
    protected static $table = "paypal";

    public static function create(array $data): Model{
        $sql = "SELECT id, number FROM ".self::$table." WHERE id_pagamento = ?";
        $p = \Singleton::DB()->prepare($sql);
        $p->bind_param("i", $data["id_pagamento"]);
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $p->bind_result($idPayPal, $num);
        $r = $p->fetch();
        if($r === FALSE)
            throw new \SQLException("Error Fetching Statement", $sql, $p->error, 4);
        elseif($r === NULL)
            throw new \ModelException("Model Not Found", __CLASS__, array("id"=>$data["id_pagamento"]), 0);
        $p->close();
        return new M_PayPal($data["id_pagamento"], $idPayPal, $num);
    }

    public static function insert(Model $paypal, array $params = array()): int{
        $DB = \Singleton::DB();
        $idPagamento = $paypal->getId();
        $numero = $paypal->getNumero();

        $sql = "INSERT INTO ".self::$table." VALUES(NULL, ?, ?);";
        $p = $DB->prepare($sql);
        $p->bind_param("is", $idPagamento, $numero);
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $p->close();
        return $DB->lastId();
    }

    public static function update(Model $paypal, array $params = array()): int{
        $DB = \Singleton::DB();
        $idPayPal = $paypal->getIdPaypal();
        $idPagamento = $paypal->getId();
        $numero = $paypal->getNumero();
        $sql = "UPDATE ".self::$table." SET id_pagamento = ?, numero = ? WHERE id = ?;";
        $p = $DB->prepare($sql);
        $p->bind_param("isi", $idPagamento, $numero, $idPayPal);
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $p->close();
        return $idPayPal;
    }
}
