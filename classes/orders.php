<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    $root = dirname(__FILE__, 2);
    include_once $root.'/include/database.php';

    class Order {

        public $id;
        public $restaurant_id;
        public $status = 1; // 1-pending 2-preparing 3-done 4-served 5-cancelled
        public $voucher_id;
        public $user_id;
        public $total = 0;
        public $dine_in = 1;

        function get_records () {
            $db = new DB();
            $db->connect();

            $sql = "select a.*,b.firstname as firstname,b.lastname as lastname,c.name as restaurant_name from orders as a
            inner join users as b
            on b.id = a.user_id
            inner join restaurant as c
            on c.id = a.restaurant_id
            where a.deleted_at is null";

            $types = "";
            $params = array();
            $data = [];
            if ($this->restaurant_id > 0){
                $types = $types."i";
                $sql = $sql . " and a.restaurant_id = ?";
                $params[] = $this->restaurant_id;
            }

            if (count($params) > 0){
                $stmt = $db->prepare($sql);
                $id = $this->id;
    
                // reset id
                $this->id=0;
    
                $stmt->bind_param($types, ...$params);
    
                $stmt->execute();
    
                $result = $stmt->get_result();
                $db->close();
                // return $result;
                if ($result)
                {
                    while($row = $result->fetch_assoc()) {
                        $data[]=$row;
                    }
                }
            }else {
                $result=$db->fetch($sql);
                $db->close();

                while($row = $result->fetch_assoc()) {
                    $data[]=$row;
                }
            }
            
            return $data;
        }

        function get_record() {
            $db = new DB();
            $db->connect();

            $sql = "select * from orders where deleted_at is null and id = ?";

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
                        $this->restaurant_id = $row['restaurant_id'];
                        $this->status = $row['status'];
                        $this->voucher_id = $row['voucher_id'];
                        $this->total = $row['total'];
                        $this->user_id = $row['user_id'];
                        $this->dine_in = $row['dine_in'];
                        
                    }
                // close the result.
                // mysqli_free_result($result);
            }
        }


        function Save(){
            $db = new DB();
            $db->connect();

            $sql = "
            insert into orders 
                (
                    restaurant_id,
                    status,
                    voucher_id,
                    created_at,
                    user_id,
                    total,
                    dine_in
                )
            values
                (
                    ?,?,?,now(),?,?,?
                )
            ;";
            $stmt = $db->db->prepare($sql);
            $stmt->bind_param('iiiiii', $this->restaurant_id,$this->status,$this->voucher_id,$this->user_id,$this->total,$this->dine_in);

            $stmt->execute();

            $stmt->close();

            $this->id = $db->get_last_id();

            $db->close();

        }

        function Update(){
            $db = new DB();
            $db->connect();

            $sql = "
            update orders set
                status=?,
                total=?
            where id = ?
            ;";
            $stmt = $db->prepare($sql);
            $stmt->bind_param('iii', $this->status,$this->total,$this->id);

            $stmt->execute();

            $stmt->close();

            $db->close();
        }

        function delete(){
            $db = new DB();
            $db->connect();
            
            $sql = "
            update orders set
                deleted_at = now()
            where id = ?
            ;";
            $stmt = $db->prepare($sql);
            $stmt->bind_param('i', $this->id);

            $stmt->execute();

            $stmt->close();

            $db->close();
        }

        function calculateTotal() {

        }
    }
?>