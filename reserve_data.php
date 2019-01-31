<?php

    class ReserveData
    {
        private $reservee;
        private $table_id;
        private $reservation_made;
        private $number_of_guests;
        private $date_of_reservation;
        private $time_of_reservation;
        private $reservee_error;
        private $guests_error;
        private $date_error;
        private $time_error;
        // private $reserve_Data;
        private $error_Data;
        private $config;
        private $connection;
        private $date_conflict;
        private $reservee_conflict;


        public function __construct($data, $connect)
        {
            foreach($data as $key => $value)
            {
                $this->$key = $data[$key];
                // $this->reserveData[$key] = $this->$key;               
            }
            $this->config = include 'reserve_config.php';
            $this->connection = $connect;
        }

        public function checkErrors()
        {
            $this->checkInput();
      
            return (empty($this->error_Data)) ? FALSE : array_filter($this->error_Data);
        }


        private function errorData()
        {
            $this->error_Data = array('reservee_error' => $this->reservee_error, 'guests_error' => $this->guests_error, 'date_error' => $this->date_error, 'time_error' => $this->time_error);
        }


        private function checkSeats()
        {
            $sql = "SELECT seats FROM reserve_list INNER JOIN table_list ON reserve_list.table_id = table_list.table_id WHERE table_list.table_id = {$this->table_id}";
            $statement = $this->connection->query($sql);
            // $statement->execute();
            $statement->bindColumn('seats', $seats);
            $statement->fetch(PDO::FETCH_BOUND);
            return $seats;
        }


        private function checkDate()
        {
            $sql = "SELECT table_id FROM {$this->config['table']} WHERE reserve_date = '{$this->date_of_reservation}'";
            $statement = $this->connection->prepare($sql);
            $statement->execute();
            $row = $statement->rowCount();
            return $row;
        }


        private function checkReservee()
        {
            $sql = "SELECT table_id FROM {$this->config['table']} WHERE reservee = '{$this->reservee}'";
            $statement = $this->connection->prepare($sql);
            $statement->execute();
            $row = $statement->rowCount();
            return $row;
        }


        // private function checkTime()
        // {
        //     $sql = "SELECT table_id FROM {$this->config['table']} WHERE reserve_time = '{$this->time_of_reservation}'";
        //     $statement = $this->connection->prepare($sql);
        //     $statement->execute();
        //     $row = $statment = 
        // }


        private function checkInput()
        {
            $this->reservee_conflict = $this->checkReservee();

            if(empty($this->reservee))
            {
                $this->reservee_error = "ENTER RESERVEE";
            }
            elseif($this->reservee_conflict == 1)
            {
                $this->reservee_error = "SIMILAR RESERVEE NAME FOUND";
            }

            $seats = $this->checkSeats();

            if(empty($this->number_of_guests))
            {
                $this->guests_error = "ENTER NUMBER OF GUESTS";
            }
            elseif($this->number_of_guests > 20)
            {
                $this->guests_error = "CANNOT EXCEED 20 PERSONS";
            }
            elseif($this->number_of_guests > $seats)
            {
                $this->guests_error = "GUESTS EXCEED SEATING CAPACITY";
            }

            $this->date_conflict = $this->checkDate();

            if(empty($this->date_of_reservation))
            {
                $this->date_error = "ENTER RESERVE DATE (up to 1 year advance from today)";
            }
            elseif($this->date_conflict >= 1)
            {
                $this->date_error = "TABLE RESERVED FOR THIS DAY";
            }

            if(empty($this->time_of_reservation))
            {
                $this->time_error = "ENTER RESERVATION TIME";
            }
            elseif(date("H:i", strtotime($this->time_of_reservation)) < $this->config['openingTime'] || date("H:i", strtotime($this->time_of_reservation)) >= $this->config['lastReserve'])
            // elseif(filter_var($this->time_of_reservation, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/10|[0-9]:59AM|12[7-9]:30PM/"))))
            {
                $this->time_error = "ENTER VALID TIME (between 9:00 AM - 8:00 PM *inclusively)";
            }
        
            $this->errorData();
        }


       
    }
?>