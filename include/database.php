<?php 
    class DB {
        public $db;
        private $servername = "sql113.epizy.com";
        private $username = "qIosIaayb5S";
        private $password = "HbOI6FP9QdcN36B";
        private $dbname = "epiz_31342682_digital_menu";

        // private $servername = "localhost";
        // private $username = "u488180748_UBSU0gc";
        // private $password = "BatStateU0gc";
        // private $dbname = "digital_menu";

        function connect() {
            $this->db = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
            // Check connection
            if ($this->db->connect_error) {
                die("Connection failed: " . $this->db->connect_error);
            }
        }

        function query($sql) {
            if ($this->db->query($sql) === TRUE) {
                // echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $this->db->error;
            }
        }

        function prepare($sql){
            return $this->db->prepare($sql);
        }

        function get_last_id() {
            return $this->db->insert_id;
        }

        function fetch($sql) {
            $result = $this->db->query($sql);
            return $result;
        }

        function close() {
            $this->db->close();
        }
    }
?>