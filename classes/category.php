<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    $root = dirname(__FILE__, 2);
    include_once $root.'/include/database.php';

    class Category {

        public $id;
        public $name;
        public $active;
        public $restaurant_id;
        public $image;

        function get_records () {
            $db = new DB();
            $db->connect();

            $sql = "select a.*,b.name as restaurant_name from category as a
            inner join restaurant as b
            on b.id = a.restaurant_id
            where a.deleted_at is null";

            $types = "";
            $params = array();
            $data = [];
            if ($this->restaurant_id > 0){
                $types = $types."i";
                $sql = $sql . " and restaurant_id = ?";
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

            $sql = "select * from category where deleted_at is null and id = ?";

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
                        $this->active = $row['active'];
                        $this->restaurant_id = $row['restaurant_id'];
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
            insert into category 
                (
                    name,
                    active,
                    restaurant_id,
                    image
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
            $stmt->bind_param('siis', $this->name,$this->active,$this->restaurant_id,$this->image);

            $stmt->execute();

            $stmt->close();

            $db->close();

        }

        function Update(){
            $db = new DB();
            $db->connect();

            $sql = "
            update category set
                name=?,
                restaurant_id=?,
                active=?,
                image=?
            where id = ?
            ;";
            $stmt = $db->prepare($sql);
            $stmt->bind_param('siisi', $this->name,$this->restaurant_id,$this->active,$this->image,$this->id);

            $stmt->execute();

            $stmt->close();

            $db->close();
        }

        function delete(){
            $db = new DB();
            $db->connect();
            
            $sql = "
            update category set
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
            if(isset($_FILES['image'])){
                $errors= array();
                $file_name = $_FILES['image']['name'];
                $file_size =$_FILES['image']['size'];
                $file_tmp =$_FILES['image']['tmp_name'];
                $file_type=$_FILES['image']['type'];
                $file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));
                
                $root = dirname(__FILE__, 2);
                $tempDir = $root."/upload/menu_category/";
                $filename=$tempDir.$this->id.$file_name;
                $this->image="/upload/menu_category/".$this->id.$file_name;
    
                move_uploaded_file($file_tmp,$filename);
                return $filename;
            }
            return "";
        }
    }
?>