<?php
class FCategoria{
	//Attributi
	 private $_connection;
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

        $this->_connection = new mysqli($host,$user,$password,$database);
        if ($this->_connection->connect_errno) {
            echo "Failed to connect to MySQL: (" . $this->_connection->connect_errno . ") " . $this->_connection->connect_error;
        }

        return true;

    }
    public function close() {
        $this->_connection->close();
    }
}
?>