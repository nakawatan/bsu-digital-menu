<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    $root = dirname(__FILE__, 2);
    include_once $root.'/include/database.php';

    class Course {

        public $id;
        public $name;
        public $department_id;
        public $department_name;

        function get_courses () {
            $db = new DB();
            $db->connect();

            $sql = "select a.*,b.name as department_name
                from courses as a 

                inner join departments as b
                on b.id = a.department_id
            
                where a.deleted_at is null;";

            $result=$db->fetch($sql);
            $db->close();
            $data = [];

            while($row = $result->fetch_assoc()) {
                $data[]=$row;
            }
            
            return $data;
        }

        function get_course() {
            $db = new DB();
            $db->connect();

            $sql = "select * from courses where deleted_at is null and id = ?;";

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
                        $this->username = $row['username'];
                        $this->password = $row['password'];
                        $this->email = $row['email'];
                        $this->user_level_id = $row['user_level_id'];
                        $this->created_at = $row['created_at'];
                        $this->google_id = $row['google_id'];
                        $this->image = $row['image'];
                    }
                // close the result.
                // mysqli_free_result($result);
            }
        }


        function Save(){
            $db = new DB();
            $db->connect();

            $sql = "
            insert into courses 
                (
                    name,
                    department_id,
                    created_at
                )
            values
                (
                    ?,
                    ?,
                    now()
                )
            ;";
            $stmt = $db->db->prepare($sql);
            $stmt->bind_param('si', $this->name,$this->department_id);

            $stmt->execute();

            $stmt->close();

            $db->close();

        }

        function Update(){
            $db = new DB();
            $db->connect();

            $sql = "
            update courses set
                name=?,
                department_id=?
            where id = ?
            ;";
            $stmt = $db->prepare($sql);
            $stmt->bind_param('ssi', $this->name,$this->department_id,$this->id);

            $stmt->execute();

            $stmt->close();

            $db->close();
        }

        function delete(){
            $db = new DB();
            $db->connect();
            
            $sql = "
            update courses set
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