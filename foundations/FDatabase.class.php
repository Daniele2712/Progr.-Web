<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

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
    private function connect( $host, $user, $password, $database ) {

        $this->connection = new mysqli($host,$user,$password,$database);
        if ($this->connection->connect_errno) {
            echo "Failed to connect to MySQL: (" . $this->connection->connect_errno . ") " . $this->connection->connect_error;
        }

        return true;

    }
    public function close() {
        $this->connection->close();
    }
    public function query($query){
        if($this->connection){
            $result=$this->connection->query($query);
            if (!$result)
                return false;
            return $result;
        }
        return false;
    }
}
?>