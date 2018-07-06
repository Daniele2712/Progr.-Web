<?php
class FDatabase{

	private $connection;

    public function __construct() {

        global $config;
        $this->connect( $config['mysql']['host'],
                        $config['mysql']['user'],
                        $config['mysql']['password'],
                        $config['mysql']['database'] );
    }

    private function connect($host, $user, $password, $database){
        $this->connection = new mysqli($host,$user,$password,$database);
        if($this->connection->connect_errno)
            throw new \SQLException("Error Connecting", $this->connection->connect_errno, $this->connection->connect_error);
    }

    public function close(){
        $this->connection->close();
    }

    public function query($query){
        if(!$this->connection)
            throw new \SQLException("Error Not Connected", $query, "", 1);
        return $this->connection->query($query);
    }

    public function lastId(){
        if(!$this->connection)
            throw new \SQLException("Error Not Connected", $query, "", 1);
        return $this->connection->insert_id;
    }

    public function prepare($query){
        if(!$this->connection)
            throw new \SQLException("Error Not Connected", $query, "", 1);
        $r = $this->connection->prepare($query);
        if(!$r)
            throw new \SQLException("Error Prepared Statement", $query, $this->error(), 2);
        return $r;
    }

    public function error(){
        return $this->connection->error;
    }
}
?>
