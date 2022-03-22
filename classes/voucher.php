<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    $root = dirname(__FILE__, 2);
    include_once $root.'/include/database.php';

    class Voucher {

        public $id;
        public $series_id;
        public $amount;
        public $used;
        public $QRPREFIX="DIGITALMENU::";

        function get_records () {

            $db = new DB();
            $db->connect();

            $sql = "select * from vouchers as a
            inner join voucher_series as b
            on b.id = a.series_id 
            where a.deleted_at is null";

            $types = "";
            $params = array();
            $data = [];

            if ($this->series_id > 0){
                $types = $types."i";
                $sql = $sql . " and a.series_id = ?";
                $params[] = $this->series_id;
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

            $sql = "select * from vouchers where id = ?";

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
                        $this->series_id = $row['series_id'];
                        $this->amount = $row['amount'];
                        $this->used = $row['used'];
                        $this->qr_code_link = $row['qr_code_link'];
                    }
                // close the result.
                // mysqli_free_result($result);
            }
        }


        function Save(){
            $db = new DB();
            $db->connect();

            $sql = "
            insert into vouchers 
                (
                    series_id,
                    amount,
                    used
                )
            values
                (
                    ?,
                    ?,
                    ?
                )
            ;";
            $stmt = $db->db->prepare($sql);
            $stmt->bind_param('iii', $this->series_id,$this->amount,$this->used);

            $stmt->execute();

            $stmt->close();

            $this->id = $db->get_last_id();
            $this->generateQRCode();

            $db->close();

        }

        function Update(){
            $db = new DB();
            $db->connect();

            $sql = "
            update vouchers set
                used=?,
                qr_code_link=?
            where id = ?
            ;";
            $stmt = $db->prepare($sql);
            $stmt->bind_param('isi', $this->used,$this->qr_code_link,$this->id);

            $stmt->execute();

            $stmt->close();

            $db->close();
        }

        function delete(){
            $db = new DB();
            $db->connect();
            
            $sql = "
            update vouchers set
                deleted_at = now()
            where id = ?
            ;";
            $stmt = $db->prepare($sql);
            $stmt->bind_param('i', $this->id);

            $stmt->execute();

            $stmt->close();

            $db->close();
        }

        function generateQRCode() {
            $root = dirname(__FILE__, 2);
            $tempDir = $root."/upload/";
            $filename=$this->id.".qr.png";
            
            $qr = new QRCode();
            $qr->setErrorCorrectLevel(QR_ERROR_CORRECT_LEVEL_L);
            $qr->setTypeNumber(4);
            $qr->addData(base64_encode($this->QRPREFIX.$this->id));
            $qr->make();
            $image = $qr->createImage(4);
            imagepng($image,$tempDir.$filename,3);
            $this->qr_code_link = "/upload/".$filename;
            
            $this->Update();
        }
    }
?>