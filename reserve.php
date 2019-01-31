<?php

    class Reserve
    {
        private $connection;
        private $config;

        
        public function __construct($connect)
        {
            $this->connection = $connect;
            $this->config = include 'reserve_config.php';
        }


        public function reserveTable($data)
        {
            foreach($this->config['fillables'] as $keys)
            {
                $fillables[] = $keys;
                $param[] = '?';
            }
            $inputs = array_values($data);
            $sql = sprintf("INSERT INTO %s (%s) VALUES (%s)", $this->config['table'], implode(',', $fillables), implode(',', $param));
            $statement = $this->connection->prepare($sql);
            $statement->execute($inputs);
            header('location: user.php');
        }
    }

?>