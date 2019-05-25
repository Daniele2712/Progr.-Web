<?php
namespace Foundations;
if(!defined("EXEC")){
    header("location: /index.php");
    return;
}

class F_Valuta{
    public static function update(int $id, string $sigla, string $nome, string $simbolo){

    }

    public static function insert(string $sigla, string $nome, string $simbolo):int{
        return 0;
    }

    public static function all(): array{
        $DB = \Singleton::DB();
        $sql = "SELECT * FROM valute";
        $res = $DB->query($sql);
        $r = array();
        while($row = $res->fetch_row())
            $r[] = $row;
        return $r;
    }

    public static function find(int $id): array{
        $DB = \Singleton::DB();
        $sql = "SELECT sigla, nome, simbolo FROM valute WHERE id = ?";
        $p = $DB->prepare($sql);
        $p->bind_param("i",$id);
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $p->bind_result($sigla, $nome, $simbolo);
        $r = $p->fetch();
        if($r === FALSE)
            throw new \SQLException("Error Fetching Statement", $sql, $p->error, 4);
        elseif($r === NULL)
            throw new \ModelException("Model Not Found", __CLASS__, array("id"=>$id_utente), 0);
        $p->close();
        return array('id'=>$id, 'sigla'=>$sigla, 'nome'=>$nome, 'simbolo'=>$simbolo);
    }
    public static function siglaToId(string $sigla): int{
        $DB = \Singleton::DB();
        $sql = "SELECT id FROM valute WHERE sigla = ?";
        $p = $DB->prepare($sql);
        $p->bind_param("s",$sigla);
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $p->bind_result($id);
        $r = $p->fetch();
        if($r === FALSE)
            throw new \SQLException("Error Fetching Statement", $sql, $p->error, 4);
        elseif($r === NULL)
            throw new \ModelException("Sigla Not Found", __CLASS__, array("sigla"=>$sigla), 0);
        $p->close();
        return $r;
    }
    public static function getDefaultId(): int{
      return self::siglaToId('EUR');
    }

    public static function exchangeRate(string $from, string $to){
        if($from === $to)
            return 1;
        else{
            $url = "https://www.alphavantage.co/query?function=CURRENCY_EXCHANGE_RATE&from_currency=".
                $from."&to_currency=".$to."&apikey=640XPH9OLI8AT5FI";
            $data = file_get_contents($url);
            $arr = json_decode($data, true);
            if(array_key_exists("Realtime Currency Exchange Rate",$arr) && array_key_exists("5. Exchange Rate",$arr["Realtime Currency Exchange Rate"]))
                    return $arr["Realtime Currency Exchange Rate"]["5. Exchange Rate"];
            throw new \ModelException("Currency not found", __CLASS__, array("url"=>$url), 2);
        }
    }
}
