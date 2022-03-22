<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    $root = dirname(__FILE__, 2);
    include_once $root.'/include/database.php';
    // include $root."/classes/qr.php";
    include_once $root.'/include/qrcode.php';

    class Research {

        public $id;
        public $abstract;
        public $title;
        public $authors;
        public $method;
        public $qr_code_link;
        public $course;
        public $course_id;
        public $publish_date;
        public $QRPREFIX="DFS::";

        function get_researches () {
            $db = new DB();
            $db->connect();

            $sql = "select researches.*,courses.name as course from researches inner join courses on courses.id = researches.course_id where researches.deleted_at is null";

            $types = "";
            $params = array();
            $data = [];
            if ($this->course_id > 0){
                $types = $types."i";
                $sql = $sql . " and course_id = ?";
                $params[] = $this->course_id;
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

        function get_research() {
            $db = new DB();
            $db->connect();

            $sql = "select researches.*,courses.name as course from researches inner join courses on courses.id = researches.course_id where researches.deleted_at is null and researches.id = ?;";

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
                        $this->abstract = $row['abstract'];
                        $this->title = $row['title'];
                        $this->authors = $row['authors'];
                        $this->method = $row['method'];
                        $this->course_id = $row['course_id'];
                        $this->course = $row['course'];
                        $this->qr_code_link = $row['qr_code_link'];
                        $this->file = $row['file'];
                        $this->publish_date = $row['publish_date'];
                    }
                // close the result.
                // mysqli_free_result($result);
            }
        }


        function Save(){
            $db = new DB();
            $db->connect();

            $sql = "
            insert into researches 
                (
                    abstract,
                    title,
                    authors,
                    method,
                    qr_code_link,
                    file,
                    course_id,
                    publish_date,
                    created_at
                )
            values
                (
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    now()
                )
            ;";
            $stmt = $db->db->prepare($sql);
            $stmt->bind_param('ssssssis', $this->abstract,$this->title,$this->authors,$this->method,$this->qr_code_link,$this->file,$this->course_id,$this->publish_date);

            $stmt->execute();

            $stmt->close();
            $this->id = $db->get_last_id();
            $this->generateQRCode();

            $db->close();

        }

        function Update(){
            // remember fields
            $db = new DB();
            $db->connect();

            $sql = "
            update researches set
                abstract=?,
                title=?,
                authors=?,
                method=?,
                qr_code_link=?,
                file=?,
                course_id=?,
                publish_date=?
            where id = ?
            ;";
            $stmt = $db->prepare($sql);
            $stmt->bind_param('ssssssisi', $this->abstract,$this->title,$this->authors,$this->method,$this->qr_code_link,$this->file,$this->course_id,$this->publish_date,$this->id);

            $stmt->execute();

            $stmt->close();

            $db->close();
        }

        function delete(){
            $db = new DB();
            $db->connect();
            
            $sql = "
            update researches set
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
            $filename=$this->id.".png";
            
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

        function UploadFile() {
            if(isset($_FILES['file'])){
                $errors= array();
                $file_name = $_FILES['file']['name'];
                $file_size =$_FILES['file']['size'];
                $file_tmp =$_FILES['file']['tmp_name'];
                $file_type=$_FILES['file']['type'];
                $file_ext=strtolower(end(explode('.',$_FILES['file']['name'])));
                
                $root = dirname(__FILE__, 2);
                $tempDir = $root."/upload/research/";
                $filename=$tempDir.$this->id.$file_name;
                $this->file="/upload/research/".$this->id.$file_name;
    
                move_uploaded_file($file_tmp,$filename);
                return $filename;
            }
            return "";
        }
    }
?>