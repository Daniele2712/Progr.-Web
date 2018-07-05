<?php
class FDatabase{
	//Attributi
	 private $connection;
    //Costruttori
    public function __construct() {

        global $config;
        $this->connect( $config['mysql']['host'],
                        $config['mysql']['user'],
                        $config['mysql']['password'],
                        $config['mysql']['database'] );
    }
    //Metodi
    private function connect($host, $user, $password, $database ){
        $this->connection = new mysqli($host,$user,$password,$database);
        if ($this->connection->connect_errno)
            echo "Failed to connect to MySQL: (" . $this->connection->connect_errno . ") " . $this->connection->connect_error;
        return true;
    }

    public function close(){
        $this->connection->close();
    }

    public function query($query){
        if($this->connection)
            return $this->connection->query($query);
        return false;
    }

    public function lastId(){
        if($this->connection)
            return $this->connection->insert_id;
        return 0;
    }

    public function prepare($query){
        if(!$this->connection)
            throw new \SQLException("Error Not Connected", $query, "", 1);
        $r = $this->connection->prepare($query);
        if(!$r)
            throw new \SQLException("Error Prepared Statement", $query, $this->error(), 1);
        return $r;
    }

    public function error(){
        return $this->connection->error;
    }
}
?>
