<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    $root = dirname(__FILE__, 2);
    include_once $root.'/include/database.php';

    class Department {

        public $id;
        public $name;

        function get_departments () {
            $db = new DB();
            $db->connect();

            $sql = "select * from departments where deleted_at is null;";

            $result=$db->fetch($sql);
            $db->close();
            $data = [];

            while($row = $result->fetch_assoc()) {
                $data[]=$row;
            }
            
            return $data;
        }

        function get_department() {
            $db = new DB();
            $db->connect();

            $sql = "select * from departments where deleted_at is null and id = ?;";

            $stmt = $db->prepare($sql);
            $id = $this->id;

            // reset id
            $this->id=0;

            $stmt->bind_param('i', $id);

            $stmt->execute();

            $result = $stmt->get_result();
            $db->close();
            // return $result;
            if ($result)
            {
                // it return number of rows in the table.
                if ($result->num_rows > 0)
                    {
                        $row = $result->fetch_assoc();
                        $this->id = $row['id'];
                        $this->name = $row['name'];
                    }
                // close the result.
                // mysqli_free_result($result);
            }
        }


        function Save(){
            $db = new DB();
            $db->connect();

            $sql = "
            insert into departments 
                (
                    name,
                    created_at
                )
            values
                (
                    ?,
                    now()
                )
            ;";
            $stmt = $db->db->prepare($sql);
            $stmt->bind_param('s', $this->name);

            $stmt->execute();

            $stmt->close();

            $db->close();

        }

        function Update(){
            $db = new DB();
            $db->connect();

            $sql = "
            update departments set
                name=?
            where id = ?
            ;";
            $stmt = $db->prepare($sql);
            $stmt->bind_param('si', $this->name,$this->id);

            $stmt->execute();

            $stmt->close();

            $db->close();
        }

        function delete(){
            $db = new DB();
            $db->connect();
            
            $sql = "
            update departments set
                deleted_at = now()
            where id = ?
            ;";
            $stmt = $db->prepare($sql);
            $stmt->bind_param('i', $this->id);

            $stmt->execute();

            $stmt->close();

            $db->close();
        }
    }
?>