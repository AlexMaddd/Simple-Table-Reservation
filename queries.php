<?php

    class Queries
    {

        private $connection;
        private $config;


        public function __construct($connect)
        {
            $this->connection = $connect;
            $this->config = include 'table_config.php';
            $this->config2 = include 'reserve_config.php';
        }


        public function showAllTables()
        {
            $sql = "SELECT * FROM {$this->config['table']}";
            $statement = $this->connection->prepare($sql);
            $statement->execute();

            while($row = $statement->fetch(PDO::FETCH_ASSOC))
            {
                $data[] = $row;
            }

            $this->generateDataUser($data);
        }


        public function showAllReserved()
        {
            $sql = "SELECT * FROM {$this->config2['table']}";
            $statement = $this->connection->prepare($sql);
            $statement->execute();

            while($row = $statement->fetch(PDO::FETCH_ASSOC))
            {
                $data[] = $row;
            }

            $this->generateDataAdmin($data);
        }


        public function filterTables($search, $filter)
        {
            $sql = "SELECT * FROM {$this->config['table']} WHERE {$filter} LIKE '%{$search}%'";
            $statement = $this->connection->prepare($sql);
            $statement->execute();
            $rows = $statement->rowCount();

            if($rows < 1)
            {
                $data = FALSE;
            }
            else
            {
                while($row = $statement->fetch(PDO::FETCH_ASSOC))
                {
                    $data[] = $row;
                }
            }
           
            $this->generateDataUser($data);
        }


        public function filterReserved($search, $filter)
        {
            $sql = "SELECT * FROM {$this->config2['table']} WHERE {$filter} LIKE '%{$search}%'";
            $statement = $this->connection->prepare($sql);
            $statement->execute();
            $rows = $statement->rowCount();

            if($rows < 1)
            {
                $data = FALSE;
            }
            else
            {
                while($row = $statement->fetch(PDO::FETCH_ASSOC))
                {
                    $data[] = $row;
                }
            }

            $this->generateDataAdmin($data);
        }


        public function generateDataUser($data)
        {
            if($data != FALSE)
            {
                if(is_array(reset($data)))
                {
                    $keys = array_keys(reset($data));
                    $multi = TRUE;
                }
                else
                {
                    $keys = array_keys($data);
                    $multi = FALSE;
                }
                echo "<table border = '7' cellpadding = '10'>";
                echo "<thead>";
                echo "<tr>";
                foreach($keys as $key)
                {
                    echo "<th>" . $key . "</th>";
                }
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                foreach($data as $key => $value)
                {
                    echo "<tr>";
                    foreach($keys as $x)
                    {
                        if($x == 'table_id')
                        {
                            echo "<td><a href = 'reserve_table.php?table_id=". $value[$x] . "'>TABLE # " . $value[$x] . "</a></td>";
                        }
                        else
                        {
                            echo "<td>" . $value[$x] . "</td>";
                        }
                    }
                    echo "</tr>";
                }
                echo "</tbody>"; 
                echo "</table>";
            }
            else
            {
                echo 'NO RESULTS FOUND';
            }
           
        }


        public function generateDataAdmin($data)
        {
            if($data != FALSE)
            {
                if(is_array(reset($data)))
                {
                    $keys = array_keys(reset($data));
                    $multi = TRUE;
                }
                else
                {
                    $keys = array_keys($data);
                    $multi = FALSE;
                }
                echo "<table border = '7' cellpadding = '10'>";
                echo "<thead>";
                echo "<tr>";
                foreach($keys as $key)
                {
                    if($key != 'reserve_id')
                    {
                        echo "<th>" . $key . "</th>";
                    }
                }
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                foreach($data as $key => $value)
                {
                    echo "<tr>";
                    foreach($keys as $x)
                    {
                        if($x != 'reserve_id')
                        {
                            echo "<td>" . $value[$x] . "</td>";
                        }
                    }
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
            }
            else
            {
                echo "NO RESULTS FOUND";
            }
        }


        public function getTableData($id)
        {
            $sql = "SELECT * FROM {$this->config['table']} WHERE {$this->config['primaryKey']} = {$id}";
            $statement = $this->connection->prepare($sql);
            $statement->execute();
            return $statement->fetch(PDO::FETCH_ASSOC);
        }


    }



?>