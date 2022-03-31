<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    $root = dirname(__FILE__, 2);
    include_once $root.'/include/database.php';

    class Wallet {

        public $id;
        public $user_id;
        public $transaction_type; // 1-in 2 -out
        public $status; // 1-pending 2-approved 3-cancelled
        public $amount;
        public $name;

        function get_records () {

            $db = new DB();
            $db->connect();

            $sql = "select a.*,b.username as name from wallet_transaction as a 
            inner join users as b
            on b.id = a.user_id
            where a.deleted_at is null";

            $types = "";
            $params = array();
            $data = [];

            if ($this->user_id > 0){
                $types = $types."i";
                $sql = $sql . " and a.user_id = ?";
                $params[] = $this->user_id;
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

            $sql = "select * from wallet_transaction where id = ?";

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
                        $this->user_id = $row['user_id'];
                        $this->transaction_type = $row['transaction_type'];
                        $this->status = $row['status'];
                        $this->amount = $row['amount'];
                    }
                // close the result.
                // mysqli_free_result($result);
            }
        }


        function Save(){
            $db = new DB();
            $db->connect();

            $sql = "
            insert into wallet_transaction 
                (
                    user_id,
                    transaction_type,
                    status,
                    amount
                )
            values
                (
                    ?,
                    ?,
                    ?,
                    ?
                )
            ;";
            $stmt = $db->db->prepare($sql);
            $stmt->bind_param('iiii', $this->user_id,$this->transaction_type,$this->status,$this->amount);

            $stmt->execute();

            $stmt->close();

            $this->id = $db->get_last_id();

            $db->close();

        }

        function Update(){
            $db = new DB();
            $db->connect();

            $sql = "
            update wallet_transaction set
                status=?
            where id = ?
            ;";
            $stmt = $db->prepare($sql);
            $stmt->bind_param('ii', $this->status,$this->id);

            $stmt->execute();

            $stmt->close();

            $db->close();
        }

        function delete(){
            $db = new DB();
            $db->connect();
            
            $sql = "
            update wallet_transaction set
                deleted_at = now()
            where id = ?
            ;";
            $stmt = $db->prepare($sql);
            $stmt->bind_param('i', $this->id);

            $stmt->execute();

            $stmt->close();

            $db->close();
        }

        function GetBalance(){
            $db = new DB();
            $db->connect();
            
            $sql = "
            select 
                sum(case when (transaction_type = 1 )then amount else 0 end) `in`,
                sum(case when (transaction_type = 2 )then amount else 0 end) `out`	

                from wallet_transaction 

                where deleted_at is null and user_id = ? and status <> 3;";
            $stmt = $db->prepare($sql);
            $stmt->bind_param('i', $this->user_id);

            $stmt->execute();

            $result = $stmt->get_result();
            $stmt->close();

            $db->close();
            
            if ($result)
            {
                $row = $result->fetch_assoc();
                return $row['in'] - $row['out'];
            }
        }
    }
?>