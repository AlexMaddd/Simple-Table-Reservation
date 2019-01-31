<?php

    class Connection
    {

        private $conn;

        
        public function __construct($config)
        {
            try
            {
                $this->conn = new PDO($config['connection'] . ';dbname=' . $config['dbname'], $config['username'], $config['password']);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            catch(PDOEXCEPTION $e)
            {
                die("COUDL NOT CONNECT" . $e->getMessage());
            }
        }


        public function connect()
        {
            return $this->conn;
        }

    }

?>