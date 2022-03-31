<!DOCTYPE html>
<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
     include_once 'classes/user.php';
     include_once 'classes/restaurant.php';
    $result = array();
    if (isset($_REQUEST['create-account-btn'])) {
        $user = new User();
    
        if (isset($_REQUEST["input-email"])) {
            $user->username = $_REQUEST["input-email"];
            $user->checkUsername();

            if ($user->id == 0){
                // create a restaurant first
                $restaurant = new Restaurant();
        
                $restaurant->UploadFile();
    
                if (isset($_REQUEST["store-name"])) {
                    $restaurant->name = $_REQUEST["store-name"];
                }

                $restaurant->active = 1;
                
                $restaurant->Save();
                


                if (isset($_REQUEST["input-firstname"])) {
                    $user->firstname = $_REQUEST["input-firstname"];
                }
                if (isset($_REQUEST["input-lastname"])) {
                    $user->lastname = $_REQUEST["input-lastname"];
                }
                if (isset($_REQUEST["input-email"])) {
                    $user->username = $_REQUEST["input-email"];
                    $user->email = $_REQUEST["input-email"];
                }
                if (isset($_REQUEST["input-password"])) {
                    $user->password = $_REQUEST["input-password"];
                }
                $user->user_level_id = 2;

                $user->restaurant_id = $restaurant->id;
        
                $user->Save();
        
                header('Location: '.'/login.php');
            }else {
                $result["status"]="error";
                $result["msg"] ="Username already exist";
            }
            
        }
    }
?>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Register - Digital Menu</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link href="css/sb-admin-2.css" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-gradient-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-7">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Create Account</h3></div>
                                    <div class="card-body">
                                        <form method="POST" enctype="multipart/form-data">
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="input-firstname" name="input-firstname" type="text" placeholder="Enter your first name" />
                                                        <label for="input-firstname">First name</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating">
                                                        <input class="form-control" id="input-lastname" name="input-lastname" type="text" placeholder="Enter your last name" />
                                                        <label for="input-lastname">Last name</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="input-email" name="input-email" type="email" placeholder="name@example.com" />
                                                <label for="input-email">Email address</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="store-name" name="store-name" type="text" placeholder="name@example.com" />
                                                <label for="store-name">Store Name</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="logo" name="logo" type="file" placeholder="name@example.com" />
                                                <!-- <label for="input-logo">Logo</label> -->
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="input-password" name="input-password" type="password" placeholder="Create a password" />
                                                        <label for="input-password">Password</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="input-confirm-password" type="password" placeholder="Confirm password" />
                                                        <label for="input-confirm-password">Confirm Password</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-4 mb-0">
                                                <div class="d-grid"><button type="submit" name="create-account-btn" class="btn btn-primary btn-block">Create Account</button></div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center py-3">
                                        <div class="small"><a href="login.php">Have an account? Go to login</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Digital Menu 2022</div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
