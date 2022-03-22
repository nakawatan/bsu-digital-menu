<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    $root = dirname(__FILE__, 2);
    include_once $root.'/include/database.php';

    class OrderItem {

        public $id;
        public $order_id;
        public $menu_item_id;
        public $price;
        public $restaurant_id;
        public $quantity = 1;

        function get_records () {
            $db = new DB();
            $db->connect();

            $sql = "select a.*,c.name as menu_item_name from order_items as a
            inner join orders as b
            on b.id = a.order_id
            inner join menu_item as c
            on c.id = a.menu_item_id
            where a.deleted_at is null ";

            $types = "";
            $params = array();
            $data = [];
            if ($this->restaurant_id > 0){
                $types = $types."i";
                $sql = $sql . " and b.restaurant_id = ?";
                $params[] = $this->restaurant_id;
            }

            if ($this->order_id > 0) {
                $types = $types."i";
                $sql = $sql . " and a.order_id = ?";
                $params[] = $this->order_id;
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

            $sql = "select * from order_items where deleted_at is null and id = ?";

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
                        $this->order_id = $row['order_id'];
                        $this->menu_item_id = $row['menu_item_id'];
                        $this->voucher_id = $row['voucher_id'];
                        $this->price = $row['price'];
                        
                    }
                // close the result.
                // mysqli_free_result($result);
            }
        }


        function Save(){
            $db = new DB();
            $db->connect();

            $sql = "
            insert into order_items 
                (
                    order_id,
                    menu_item_id,
                    price,
                    quantity
                )
            values
                (
                    ?,?,?,?
                )
            ;";
            $stmt = $db->db->prepare($sql);
            $stmt->bind_param('iiii', $this->order_id,$this->menu_item_id,$this->price,$this->quantity);

            $stmt->execute();

            $stmt->close();

            $db->close();

        }

        function Update(){
            $db = new DB();
            $db->connect();

            $sql = "
            update order_items set
                order_id=?,
                menu_item_id=?,
                price=?
            where id = ?
            ;";
            $stmt = $db->prepare($sql);
            $stmt->bind_param('iiii', $this->order_id,$this->menu_item_id,$this->price,$this->id);

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

        function get_monitoring_items() {
            $db = new DB();
            $db->connect();

            $sql = "select a.*,c.name,b.restaurant_id,d.firstname,d.lastname from order_items as a 
            inner join orders as b
            on b.id = a.order_id
            inner join menu_item as c
            on c.id = a.menu_item_id
            inner join users as d on d.id= b.user_id
            where b.status not in (4,5)";

            $types = "";
            $params = array();
            $data = [];
            if ($this->restaurant_id > 0){
                $types = $types."i";
                $sql = $sql . " and b.restaurant_id = ?";
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

        function calculateTotal() {
            
        }
    }
?>