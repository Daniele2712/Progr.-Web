<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class FFiltro extends Foundation{
    protected static $table = "filtri";
    public static function insert(Entity $object): int{}
    public static function update(Entity $object){}
    public static function create(array $object): Entity{}

    
    public static function allFilters(){
        echo "F-filtri";
        $rows = array();
        $DB = Singleton::DB();
        $sql = "SELECT * from filtri";
        $result = $DB->query($sql);
        while($r = mysqli_fetch_assoc($result)) {
            $rows[] = $r;
        }
        return json_encode($rows);
        
        }
}
?>
