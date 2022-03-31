<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    $root = dirname(__FILE__, 2);
    include_once $root.'/include/database.php';

    class User {

        public $id;
        public $firstname;
        public $lastname;
        public $username;
        public $password;
        public $email;
        public $user_level_id = 0;
        public $access_level_name;
        public $google_id;
        public $created_at;
        public $image;
        public $restaurant_name;
        public $restaurant_id;

        function get_users () {
            $db = new DB();
            $db->connect();

            $sql = "select a.*,b.name as user_level_name,c.name as restaurant_name from users as a
                inner join user_level as b
                on a.user_level_id = b.id
                left join restaurant as c
                on a.restaurant_id = c.id
            where a.deleted_at is null;";

            $result=$db->fetch($sql);
            $db->close();
            $userArr = [];

            while($row = $result->fetch_assoc()) {
                $userArr[]=$row;
            }
            
            return $userArr;
        }

        function login(){
            $db = new DB();
            $db->connect();

            $sql = "select * from users where deleted_at is null and username = ? and password = md5(?);";

            $stmt = $db->prepare($sql);
            $stmt->bind_param('ss', $this->username,$this->password);

            $stmt->execute();

            $result = $stmt->get_result();
            $db->close();
            // return $result;
            $newArr = array();
            if ($result)
            {
                // it return number of rows in the table.
                if ($result->num_rows > 0)
                    {
                        $row = $result->fetch_assoc();
                        $newArr["id"] = $row['id'];
                        $newArr["username"] = $row['username'];
                        $newArr["firstname"] = $row['firstname'];
                        $newArr["lastname"] = $row['lastname'];
                        $newArr["password"] = $row['password'];
                        $newArr["email"] = $row['email'];
                        $newArr["user_level_id"] = $row['user_level_id'];
                        $newArr["created_at"] = $row['created_at'];
                        $newArr["google_id"] = $row['google_id'];
                        $newArr["image"] = $row['image'];
                        $newArr["restaurant_id"] = $row['restaurant_id'];
                        print($row['restaurant_id']);
                    }
                // close the result.
                // mysqli_free_result($result);
            }
            return $newArr;
        }

        function checkUsername(){
            $db = new DB();
            $db->connect();

            $sql = "select * from users where deleted_at is null and username = ?;";

            $stmt = $db->prepare($sql);
            $stmt->bind_param('s', $this->username);

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
                        $this->firstname = $row['firstname'];
                        $this->lastname = $row['lastname'];
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

        function get_user_by_restaurant_id () {
            $db = new DB();
            $db->connect();

            $sql = "select * from users where deleted_at is null and restaurant_id = ?;";

            $stmt = $db->prepare($sql);
            $id = $this->restaurant_id;

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
                        $this->firstname = $row['firstname'];
                        $this->lastname = $row['lastname'];
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

        function get_user() {
            $db = new DB();
            $db->connect();

            $sql = "select * from users where deleted_at is null and id = ?;";

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
                        $this->firstname = $row['firstname'];
                        $this->lastname = $row['lastname'];
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
            insert into users 
                (
                    firstname,
                    lastname,
                    username,
                    password,
                    email,
                    user_level_id,
                    created_at,
                    google_id,
                    image,
                    restaurant_id
                )
            values
                (
                    ?,
                    ?,
                    ?,
                    md5(?),
                    ?,
                    ?,
                    now(),
                    ?,
                    ?,
                    ?
                )
            ;";
            $stmt = $db->db->prepare($sql);
            $stmt->bind_param('sssssissi', $this->firstname,$this->lastname,$this->username,$this->password,$this->email,$this->user_level_id,$this->google_id,$this->image,$this->restaurant_id);

            $stmt->execute();

            $stmt->close();

            $db->close();

        }

        function Update(){
            // remember fields
            $firstname = $this->firstname;
            $lastname= $this->lastname;
            $password = $this->password;
            $email = $this->email;
            $user_level_id = $this->user_level_id;
            $google_id = $this->google_id;
            $image = $this->image;
            $restaurant_id = $this->restaurant_id;

            $this->get_user();

            if ($password != $this->password) {
                $password = md5($password);
            }

            $db = new DB();
            $db->connect();

            $sql = "
            update users set
                firstname=?,
                lastname=?,
                password=?,
                email=?,
                user_level_id=?,
                google_id=?,
                image=?,
                restaurant_id=?
            where id = ?
            ;";
            $stmt = $db->prepare($sql);
            $stmt->bind_param('ssssissii', $firstname,$lastname,$password,$email,$user_level_id,$google_id,$image,$restaurant_id,$this->id);

            $stmt->execute();

            $stmt->close();

            $db->close();
        }

        function delete(){
            $db = new DB();
            $db->connect();
            
            $sql = "
            update users set
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