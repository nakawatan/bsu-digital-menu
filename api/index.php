<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    $root = dirname(__FILE__, 2);
    include $root.'/classes/user.php';
    include $root.'/classes/department.php';
    include_once $root.'/classes/course.php';
    include_once $root.'/classes/research.php';
    include_once $root.'/classes/restaurant.php';
    include_once $root.'/classes/category.php';
    include_once $root.'/classes/menuitem.php';
    include_once $root.'/classes/orders.php';
    include_once $root.'/classes/order_items.php';
    include_once $root.'/classes/voucher_series.php';
    include_once $root.'/classes/wallet.php';
    $result["status"] = "ok";

    if (isset($_REQUEST['method'])){
        $method = $_REQUEST['method'];
        switch ($method) {
            case "get_users":
                $user = new User();
                $users = $user->get_users();
                $result=array();
        
                $result["status"] = "ok";
                $result["users"]=$users;
                break;
            case "update_user":
                $user = new User();
                if (isset($_REQUEST["id"])) {
                    $user->id = $_REQUEST["id"];
        
                    // check if user exist
                    $user->get_user();
        
                    if ($user->id > 0){
                        if (isset($_REQUEST["password"])) {
                            $user->password = $_REQUEST["password"];
                        }
                        if (isset($_REQUEST["email"])) {
                            $user->email = $_REQUEST["email"];
                        }
                        if (isset($_REQUEST["firstname"])) {
                            $user->firstname = $_REQUEST["firstname"];
                        }
                        if (isset($_REQUEST["lastname"])) {
                            $user->lastname = $_REQUEST["lastname"];
                        }
                        if (isset($_REQUEST["user_level_id"])) {
                            $user->user_level_id = $_REQUEST["user_level_id"];
                        }
            
                        if (isset($_REQUEST["google_id"])) {
                            $user->google_id = $_REQUEST["google_id"];
                        }
            
                        if (isset($_REQUEST["image"])) {
                            $user->image = $_REQUEST["image"];
                        }

                        if (isset($_REQUEST["restaurant_id"])) {
                            $user->restaurant_id = $_REQUEST["restaurant_id"];
                        }
                
                        $user->Update();
                
                        $result["status"] = "ok";
                        $result["obj"]=$user;
                    }else {
                        $result["status"]="error";
                        $result["msg"]="Record Does not exist";
                    }
        
                    
                }else {
                    $result["status"]="error";
                    $result["msg"]="No valid id";
                }
                break;
            case "new_user":
                $user = new User();
    
                if (isset($_REQUEST["username"])) {
                    $user->username = $_REQUEST["username"];
                    $user->checkUsername();
        
                    if ($user->id == 0){
                        if (isset($_REQUEST["firstname"])) {
                            $user->firstname = $_REQUEST["firstname"];
                        }
                        if (isset($_REQUEST["lastname"])) {
                            $user->lastname = $_REQUEST["lastname"];
                        }
                        if (isset($_REQUEST["username"])) {
                            $user->username = $_REQUEST["username"];
                        }
                        if (isset($_REQUEST["password"])) {
                            $user->password = $_REQUEST["password"];
                        }
                        if (isset($_REQUEST["email"])) {
                            $user->email = $_REQUEST["email"];
                        }
                        if (isset($_REQUEST["user_level_id"])) {
                            $user->user_level_id = $_REQUEST["user_level_id"];
                        }
                
                        if (isset($_REQUEST["google_id"])) {
                            $user->google_id = $_REQUEST["google_id"];
                        }
                
                        if (isset($_REQUEST["image"])) {
                            $user->image = $_REQUEST["image"];
                        }
                        if (isset($_REQUEST["restaurant_id"])) {
                            $user->restaurant_id = $_REQUEST["restaurant_id"];
                        }
                
                        $user->Save();
                
                        $result["status"] = "ok";
                        $result["obj"]=$user;
                    }else {
                        $result["status"]="error";
                        $result["msg"] ="Username already exist";
                    }
                    
                }else {
                    $result["status"]="error";
                    $result["msg"] ="Username is required";
                }
                break;
            case "register_merchant":
                $user = new User();
    
                if (isset($_REQUEST["username"])) {
                    $user->username = $_REQUEST["username"];
                    $user->checkUsername();
        
                    if ($user->id == 0){
                        // create a restaurant first
                        $restaurant = new Restaurant();
                
                        $restaurant->UploadFile();
            
                        if (isset($_REQUEST["store_name"])) {
                            $restaurant->name = $_REQUEST["store_name"];
                        }

                        if (isset($_REQUEST["active"])) {
                            $restaurant->active = 1;
                        }
                        
                        $restaurant->Save();
                        


                        if (isset($_REQUEST["firstname"])) {
                            $user->firstname = $_REQUEST["firstname"];
                        }
                        if (isset($_REQUEST["lastname"])) {
                            $user->lastname = $_REQUEST["lastname"];
                        }
                        if (isset($_REQUEST["email"])) {
                            $user->username = $_REQUEST["email"];
                        }
                        if (isset($_REQUEST["password"])) {
                            $user->password = $_REQUEST["password"];
                        }
                        if (isset($_REQUEST["email"])) {
                            $user->email = $_REQUEST["email"];
                        }
                        if (isset($_REQUEST["user_level_id"])) {
                            $user->user_level_id = 2;
                        }
                        if (isset($_REQUEST["restaurant_id"])) {
                            $user->restaurant_id = $restaurant->id;
                        }
                
                        $user->Save();
                
                        $result["status"] = "ok";
                        $result["obj"]=$user;
                    }else {
                        $result["status"]="error";
                        $result["msg"] ="Username already exist";
                    }
                    
                }else {
                    $result["status"]="error";
                    $result["msg"] ="Username is required";
                }
                break;
            case "student_login":
                $user = new User();
                $arr = array();
    
                if (isset($_REQUEST["username"])) {
                    $user->username = $_REQUEST["username"];
                    $user->checkUsername();
        
                    if ($user->id == 0){
                        if (isset($_REQUEST["username"])) {
                            $user->username = $_REQUEST["username"];
                        }
                        if (isset($_REQUEST["firstname"])) {
                            $user->firstname = $_REQUEST["firstname"];
                        }
                        if (isset($_REQUEST["lastname"])) {
                            $user->lastname = $_REQUEST["lastname"];
                        }
                        if (isset($_REQUEST["password"])) {
                            $user->password = $_REQUEST["password"];
                        }
                        if (isset($_REQUEST["email"])) {
                            $user->email = $_REQUEST["email"];
                        }
                        
                        // hard code user level for student
                        $user->user_level_id = 3;
                
                        if (isset($_REQUEST["google_id"])) {
                            $user->google_id = $_REQUEST["google_id"];
                        }
                
                        if (isset($_REQUEST["image"])) {
                            $user->image = $_REQUEST["image"];
                        }
                
                        $user->Save();
                    }
                    $user->checkUsername();
                
                    $result["status"] = "ok";
                    $result["obj"]=$user;
                    $arr["id"] = $user->id;
                    $arr["username"] = $user->username;
                    $arr["firstname"] = $user->firstname;
                    $arr["lastname"] = $user->lastname;
                    $arr["email"] = $user->email;
                    $arr["user_level_id"] = $user->user_level_id;
                    $arr["google_id"] = $user->google_id;
                    $arr["image"] = $user->image;
                    
                }else {
                    $result["status"]="error";
                    $result["msg"] ="Username is required";
                }
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION["user"] = $arr;
                break;
            case "delete_user":
                if (isset($_REQUEST["id"])){
                    $user = new User();
                    $user->id = $_REQUEST["id"];
                    // check if user exist
                    $user->get_user();
                    
                    if ($user->id >0){
                        $user->delete();
                    }else {
                        $result["status"]="error";
                        $result["msg"]="Record Does not exist";
                    }
                    
                
                }else {
                    $result["status"]="err";
                    $result["msg"]="User ID must be set";
                }
                break;
            // merchant API
            case "get_restaurant_by_qr":
                if (isset($_REQUEST['id'])){
                    $tmp = base64_decode($_REQUEST['id']);
                    $tmpParts = explode("DIGITALMENU::",$tmp);
                    $id = 0;
                    if (count($tmpParts) > 1) {
                        
                        $obj = new Restaurant();
                        $obj->id = $tmpParts[1];
                        $obj->get_record();
                        
                        if ($obj->id > 0) {
                            $result['data'] = $obj;
                        }else {
                            $result["status"]="err";
                            $result["msg"]="Invalid QR code";
                        }
                    }else {
                        $result["status"]="err";
                        $result["msg"]="Invalid QR code";
                    }
                    
                }else {
                    $result["status"]="err";
                    $result["msg"]="ID must be set";
                }
                
                break;
            case "update_merchant":
                $obj = new Restaurant();
                if (isset($_REQUEST["id"])) {
                    $obj->id = $_REQUEST["id"];
        
                    // check if department exist
                    $obj->get_record();
        
                    if ($obj->id > 0){
                        $obj->UploadFile();
                        if (isset($_REQUEST["name"])) {
                            $obj->name = $_REQUEST["name"];
                        }

                        if (isset($_REQUEST["active"])) {
                            $obj->active = $_REQUEST["active"];
                        }
                
                        $obj->Update();
                
                        $result["status"] = "ok";
                        $result["obj"]=$obj;
                    }else {
                        $result["status"]="error";
                        $result["msg"]="Record Does not exist";
                    }
        
                    
                }else {
                    $result["status"]="error";
                    $result["msg"]="No valid id";
                }
                break;
            case "new_merchant":
                $obj = new Restaurant();
                
                $obj->UploadFile();
    
                if (isset($_REQUEST["name"])) {
                    $obj->name = $_REQUEST["name"];
                }

                if (isset($_REQUEST["active"])) {
                    $obj->active = $_REQUEST["active"];
                }
                
                $obj->Save();
                break;
            case "delete_merchant":
                if (isset($_REQUEST["id"])){
                    $obj = new Restaurant();
                    $obj->id = $_REQUEST["id"];
                    // check if user exist
                    $obj->get_record();
                    
                    if ($obj->id >0){
                        $obj->delete();
                    }else {
                        $result["status"]="error";
                        $result["msg"]="Record Does not exist";
                    }
                    
                
                }else {
                    $result["status"]="err";
                    $result["msg"]="ID must be set";
                }
                break;

            case "get_merchant_qr":
                if (isset($_REQUEST["id"])){
                    $obj = new Restaurant();
                    $obj->id = $_REQUEST["id"];
                    // check if user exist
                    $obj->get_record();
                    $result['qr'] = $obj->qr_code_link;
                
                }else {
                    $result["status"]="err";
                    $result["msg"]="ID must be set";
                }
                break;

            // categories API
            case "update_category":
                $obj = new Category();
                if (isset($_REQUEST["id"])) {
                    $obj->id = $_REQUEST["id"];
        
                    // check if category exist
                    $obj->get_record();
                    
                    if ($obj->id > 0){
                        $obj->UploadFile();
                        if (isset($_REQUEST["name"])) {
                            $obj->name = $_REQUEST["name"];
                        }

                        if (isset($_REQUEST["active"])) {
                            $obj->active = $_REQUEST["active"];
                        }

                        if (isset($_REQUEST["restaurant_id"])) {
                            $obj->restaurant_id = $_REQUEST["restaurant_id"];
                        }
                
                        $obj->Update();
                
                        $result["status"] = "ok";
                        $result["obj"]=$obj;
                    }else {
                        $result["status"]="error";
                        $result["msg"]="Record Does not exist";
                    }
        
                    
                }else {
                    $result["status"]="error";
                    $result["msg"]="No valid id";
                }
                break;
            case "new_category":
                $obj = new Category();
                
                $obj->UploadFile();
    
                if (isset($_REQUEST["name"])) {
                    $obj->name = $_REQUEST["name"];
                }

                if (isset($_REQUEST["active"])) {
                    $obj->active = $_REQUEST["active"];
                }

                if (isset($_REQUEST["restaurant_id"])) {
                    $obj->restaurant_id = $_REQUEST["restaurant_id"];
                }
                
                $obj->Save();
                break;
            case "delete_category":
                if (isset($_REQUEST["id"])){
                    $obj = new Category();
                    $obj->id = $_REQUEST["id"];
                    // check if user exist
                    $obj->get_research();
                    
                    if ($obj->id >0){
                        $obj->delete();
                    }else {
                        $result["status"]="error";
                        $result["msg"]="Record Does not exist";
                    }
                    
                
                }else {
                    $result["status"]="err";
                    $result["msg"]="ID must be set";
                }
                break;

            // menuitem API
            case "get_menu_items_by_category":
                $obj = new MenuItem();
                if (isset($_REQUEST['category_id'])){
                    $obj->category_id = $_REQUEST['category_id'];
                }
                $obj_list = $obj->get_records();
                $result['menuitems'] = $obj_list;
                break;
            case "update_menuitem":
                $obj = new MenuItem();
                if (isset($_REQUEST["id"])) {
                    $obj->id = $_REQUEST["id"];
        
                    // check if category exist
                    $obj->get_record();
                    
                    if ($obj->id > 0){
                        $obj->UploadFile();
                        if (isset($_REQUEST["name"])) {
                            $obj->name = $_REQUEST["name"];
                        }

                        if (isset($_REQUEST["description"])) {
                            $obj->description = $_REQUEST["description"];
                        }

                        if (isset($_REQUEST["category_id"])) {
                            $obj->category_id = $_REQUEST["category_id"];
                        }

                        if (isset($_REQUEST["active"])) {
                            $obj->active = $_REQUEST["active"];
                        }

                        if (isset($_REQUEST["restaurant_id"])) {
                            $obj->restaurant_id = $_REQUEST["restaurant_id"];
                        }

                        if (isset($_REQUEST["price"])) {
                            $obj->price = $_REQUEST["price"];
                        }
                
                        $obj->Update();
                
                        $result["status"] = "ok";
                        $result["obj"]=$obj;
                    }else {
                        $result["status"]="error";
                        $result["msg"]="Record Does not exist";
                    }
        
                    
                }else {
                    $result["status"]="error";
                    $result["msg"]="No valid id";
                }
                break;
            case "new_menuitem":
                $obj = new MenuItem();
                
                $obj->UploadFile();
    
                if (isset($_REQUEST["name"])) {
                    $obj->name = $_REQUEST["name"];
                }

                if (isset($_REQUEST["description"])) {
                    $obj->description = $_REQUEST["description"];
                }

                if (isset($_REQUEST["category_id"])) {
                    $obj->category_id = $_REQUEST["category_id"];
                }

                if (isset($_REQUEST["active"])) {
                    $obj->active = $_REQUEST["active"];
                }

                if (isset($_REQUEST["restaurant_id"])) {
                    $obj->restaurant_id = $_REQUEST["restaurant_id"];
                }

                if (isset($_REQUEST["price"])) {
                    $obj->price = $_REQUEST["price"];
                }
                
                $obj->Save();
                break;
            case "delete_menuitem":
                if (isset($_REQUEST["id"])){
                    $obj = new MenuItem();
                    $obj->id = $_REQUEST["id"];
                    // check if user exist
                    $obj->get_research();
                    
                    if ($obj->id >0){
                        $obj->delete();
                    }else {
                        $result["status"]="error";
                        $result["msg"]="Record Does not exist";
                    }
                    
                
                }else {
                    $result["status"]="err";
                    $result["msg"]="ID must be set";
                }
                break;


            // order api
            case "create_order":
                $order = new Order();
                $wallet = new Wallet();

                

                if (isset($_REQUEST["restaurant_id"])){
                    $order->restaurant_id = $_REQUEST['restaurant_id'];
                }else {
                    $result['status'] = "err";
                    $result['msg'] = "Restaurant is required to create order.";
                    break;
                }

                if (isset($_REQUEST["voucher_id"])){
                    $order->voucher_id = $_REQUEST['voucher_id'];
                }

                if (isset($_REQUEST["user_id"])){
                    $order->user_id = $_REQUEST['user_id'];
                    $wallet->user_id = $_REQUEST['user_id'];
                }

                if (isset($_REQUEST["total"])){
                    $order->total = $_REQUEST['total'];
                }

                if (isset($_REQUEST["dine_in"])){
                    $order->dine_in = $_REQUEST['dine_in'];
                }

                $balance = $wallet->GetBalance();

                if ($balance >= $order->total){
                    $order->Save();
                    if (isset($_REQUEST['order_items'])){
                        foreach($_REQUEST['order_items'] as $row){
                            $orderItem = new OrderItem();
                            $orderItem->order_id = $order->id;
                            $orderItem->menu_item_id = $row['menu_item_id'];
                            $orderItem->price = $row['price'];
                            $orderItem->quantity = $row['quantity'];
                            $orderItem->Save();
                        }
                    }
                    $wallet->transaction_type = 2;
                    $wallet->status=2;
                    $wallet->amount = $order->total;
                    $wallet->Save();


                    $userObj = new User();
                    $userObj->restaurant_id = $order->restaurant_id;
                    $userObj->get_user_by_restaurant_id();

                    $merchantWallet = new Wallet();
                    $merchantWallet->user_id = $userObj->id;
                    $merchantWallet->transaction_type = 1;
                    $merchantWallet->status=2;
                    $merchantWallet->amount = $order->total;
                    $merchantWallet->Save();
                }else {
                    $result['status'] = "err";
                    $result['msg']="Not Enough Balance";
                }

                break;
            case "update_order":
                $order = new Order();
                if (isset($_REQUEST["id"])){
                    $order->id = $_REQUEST['id'];
                    $order->get_record();
                    if (isset($_REQUEST['status'])) {
                        $order->status = $_REQUEST['status'];
                    }
                    $order->Update();
                }else {
                    $result["status"]="err";
                    $result["msg"]="ID must be set";
                }
                break;
            case "get_my_orders":
                $order = new Order();
                if (isset($_REQUEST["user_id"])){
                    $order->user_id = $_REQUEST['user_id'];
                    $data = $order->get_orders_by_user_id();
                    $result['orders'] = $data;
                }else {
                    $result["status"]="err";
                    $result["msg"]="User ID must be set";
                }
                break;

            // voucher api
            case "validate_voucher":
                if (isset($_REQUEST['id'])){
                    $tmp = base64_decode($_REQUEST['id']);
                    $tmpParts = explode("DIGITALMENU::",$tmp);
                    $id = 0;
                    $amount = $_REQUEST['amount'];
                    if (count($tmpParts) > 1) {
                        
                        $obj = new Voucher();
                        $obj->id = $tmpParts[1];
                        $obj->get_record();
                        
                        if ($obj->id > 0) {
                            $voucher_series = new VoucherSeries();
                            $voucher_series->id = $obj->series_id;
                            $voucher_series->get_record();

                            if ($voucher_series->active < 1 || $obj->used > 0 || $amount > $obj->amount) {
                                if ($amount > $obj->amount) {
                                    $result["status"]="err";
                                    $result["msg"]="Insuffient voucher amount";
                                }else {
                                    $result["status"]="err";
                                    $result["msg"]="Voucher Inactive or already used.";
                                }
                            }else {
                                $obj->used = 1;
                                $obj->Update();
                                $result['voucher'] = $obj;
                            }
                        }else {
                            $result["status"]="err";
                            $result["msg"]="Invalid QR code";
                        }
                    }else {
                        $result["status"]="err";
                        $result["msg"]="Invalid QR code";
                    }
                    
                }else {
                    $result["status"]="err";
                    $result["msg"]="ID must be set";
                }
                
                break;

                case "update_voucher_series":
                    $obj = new VoucherSeries();
                    if (isset($_REQUEST["id"])) {
                        $obj->id = $_REQUEST["id"];
            
                        // check if category exist
                        $obj->get_record();
                        
                        if ($obj->id > 0){
                            
                            if (isset($_REQUEST["name"])) {
                                $obj->name = $_REQUEST["name"];
                            }
            
                            if (isset($_REQUEST["amount"])) {
                                $obj->amount = $_REQUEST["amount"];
                            }
            
                            if (isset($_REQUEST["active"])) {
                                $obj->active = $_REQUEST["active"];
                            }
                    
                            $obj->Update();
                    
                            $result["status"] = "ok";
                            $result["obj"]=$obj;
                        }else {
                            $result["status"]="error";
                            $result["msg"]="Record Does not exist";
                        }
            
                        
                    }else {
                        $result["status"]="error";
                        $result["msg"]="No valid id";
                    }
                    break;
                case "new_voucher_series":
                    $obj = new VoucherSeries();
        
                    if (isset($_REQUEST["name"])) {
                        $obj->name = $_REQUEST["name"];
                    }
    
                    if (isset($_REQUEST["amount"])) {
                        $obj->amount = $_REQUEST["amount"];
                    }
    
                    if (isset($_REQUEST["active"])) {
                        $obj->active = $_REQUEST["active"];
                    }

                    if (isset($_REQUEST["series_count"])) {
                        $obj->series_count = $_REQUEST["series_count"];
                    }
                    
                    $obj->Save();
                    break;
                case "delete_voucher_series":
                    if (isset($_REQUEST["id"])){
                        $obj = new MenuItem();
                        $obj->id = $_REQUEST["id"];
                        // check if user exist
                        $obj->get_research();
                        
                        if ($obj->id >0){
                            $obj->delete();
                        }else {
                            $result["status"]="error";
                            $result["msg"]="Record Does not exist";
                        }
                        
                    
                    }else {
                        $result["status"]="err";
                        $result["msg"]="ID must be set";
                    }
                    break;

                //Monitoring API
                case "get_monitoring_items":
                    if (isset($_REQUEST["restaurant_id"])){
                        $obj = new OrderItem();
                        if (isset($_REQUEST['restaurant_id'])){
                            $obj->restaurant_id = $_REQUEST["restaurant_id"];
                        }

                        $data = $obj->get_monitoring_items();
                        $result['data'] = $data;
                        
                    
                    }else {
                        $result["status"]="err";
                        $result["msg"]="Restaurant ID must be set";
                    }
                    break;

                //Wallet API
                case "new_wallet_transaction":
                    $obj = new Wallet();
                    if (isset($_REQUEST["user_id"])){
                        $obj->user_id = $_REQUEST["user_id"];                    
                    }
                    if (isset($_REQUEST["transaction_type"])){
                        $obj->transaction_type = $_REQUEST["transaction_type"];                    
                    }
                    if (isset($_REQUEST["status"])){
                        $obj->status = $_REQUEST["status"];                    
                    }
                    if (isset($_REQUEST["amount"])){
                        $obj->amount = $_REQUEST["amount"];                    
                    }
                    $obj->Save();
                    break;
                case "update_wallet_transaction":
                    $obj = new Wallet();
                    if (isset($_REQUEST["id"])){
                        $obj->id = $_REQUEST["id"];
                        if (isset($_REQUEST["status"])){
                            $obj->status = $_REQUEST["status"];
                        }

                        $obj->Update();
                    }else {
                        $result["status"]="err";
                        $result["msg"]="ID must be set";
                    }
                    break;
                case "delete_wallet_transaction":
                        $obj = new Wallet();
                        if (isset($_REQUEST["id"])){
                            $obj->id = $_REQUEST["id"];

                            $obj->Delete();
                        }else {
                            $result["status"]="err";
                            $result["msg"]="ID must be set";
                        }
                        break;
                case "get_wallet_balance":
                        $obj = new Wallet();
                        if (isset($_REQUEST["id"])){
                            $obj->user_id = $_REQUEST["id"];

                            $result['balance'] = $obj->GetBalance();
                        }else {
                            $result["status"]="err";
                            $result["msg"]="ID must be set";
                        }
                        break;
            default:
                $result["status"]="error";
                $result["msg"]="Invalid method";
        }
    }else {
        $result["status"]="error";
        $result["msg"]="Method not set.";
    }

    echo json_encode($result);
?>