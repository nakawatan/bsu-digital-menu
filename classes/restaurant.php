<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    $root = dirname(__FILE__, 2);
    include_once $root.'/include/database.php';
    include_once $root.'/include/qrcode.php';

    class Restaurant {

        public $id;
        public $name;
        public $logo;
        public $active;
        public $get_active_only = false;
        public $qr_code_link;
        public $QRPREFIX="DIGITALMENU::";

        function get_records () {

            $db = new DB();
            $db->connect();

            $sql = "select * from restaurant where deleted_at is null";

            $types = "";
            $params = array();
            $data = [];
            if ($this->get_active_only){
                $types = $types."i";
                $sql = $sql . " and active = ?";
                $params[] = 1;
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

            $sql = "select * from restaurant where id = ?";

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
                        $this->logo = $row['logo'];
                        $this->active = $row['active'];
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
            insert into restaurant 
                (
                    name,
                    logo,
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
            $stmt->bind_param('ssi', $this->name,$this->logo,$this->active);

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
            update restaurant set
                name=?,
                logo=?,
                active=?,
                qr_code_link=?
            where id = ?
            ;";
            $stmt = $db->prepare($sql);
            $stmt->bind_param('ssisi', $this->name,$this->logo,$this->active,$this->qr_code_link,$this->id);

            $stmt->execute();

            $stmt->close();

            $db->close();
        }

        function delete(){
            $db = new DB();
            $db->connect();
            
            $sql = "
            update restaurant set
                deleted_at = now()
            where id = ?
            ;";
            $stmt = $db->prepare($sql);
            $stmt->bind_param('i', $this->id);

            $stmt->execute();

            $stmt->close();

            $db->close();
        }

        function UploadFile() {
            if(isset($_FILES['logo'])){
                $errors= array();
                $file_name = $_FILES['logo']['name'];
                $file_size =$_FILES['logo']['size'];
                $file_tmp =$_FILES['logo']['tmp_name'];
                $file_type=$_FILES['logo']['type'];
                $file_ext=strtolower(end(explode('.',$_FILES['logo']['name'])));
                
                $root = dirname(__FILE__, 2);
                $tempDir = $root."/upload/merchant/";
                $filename=$tempDir.$this->id.$file_name;
                $this->logo="/upload/merchant/".$this->id.$file_name;
    
                move_uploaded_file($file_tmp,$filename);
                return $filename;
            }
            return "";
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