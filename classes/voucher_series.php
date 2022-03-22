<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    $root = dirname(__FILE__, 2);
    include_once $root.'/include/database.php';
    include_once $root.'/classes/voucher.php';

    class VoucherSeries {

        public $id;
        public $amount;
        public $active;
        public $series_count;
        public $name;

        function get_records () {

            $db = new DB();
            $db->connect();

            $sql = "select * from voucher_series where deleted_at is null";

            $types = "";
            $params = array();
            $data = [];

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

            $sql = "select * from voucher_series where id = ?";

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
                        $this->amount = $row['amount'];
                        $this->active = $row['active'];
                    }
                // close the result.
                // mysqli_free_result($result);
            }
        }


        function Save(){
            $db = new DB();
            $db->connect();

            $sql = "
            insert into voucher_series 
                (
                    name,
                    amount,
                    active
                )
            values
                (
                    ?,
                    ?,
                    ?
                )
            ;";
            $stmt = $db->db->prepare($sql);
            $stmt->bind_param('sii', $this->name,$this->amount,$this->active);

            $stmt->execute();

            $stmt->close();
            $this->id = $db->get_last_id();

            $db->close();

            $this->generateVouchers();

        }

        function Update(){
            $db = new DB();
            $db->connect();

            $sql = "
            update voucher_series set
                name=?,
                amount=?,
                active=?
            where id = ?
            ;";
            $stmt = $db->prepare($sql);
            $stmt->bind_param('siii', $this->name,$this->amount,$this->active,$this->id);

            $stmt->execute();

            $stmt->close();

            $db->close();
        }

        function delete(){
            $db = new DB();
            $db->connect();
            
            $sql = "
            update voucher_series set
                deleted_at = now()
            where id = ?
            ;";
            $stmt = $db->prepare($sql);
            $stmt->bind_param('i', $this->id);

            $stmt->execute();

            $stmt->close();

            $db->close();
        }

        function generateVouchers(){
            for ($x = 0; $x < $this->series_count; $x++){
                $voucher = new Voucher();
                $voucher->series_id = $this->id;
                $voucher->amount = $this->amount;
                $voucher->used = 0;
                $voucher->Save();
            }
        }
    }
?>