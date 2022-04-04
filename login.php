<!DOCTYPE html>
<?php 
    include 'classes/user.php';
    $user = new User();
    session_start();
    if (isset($_POST['submit-login'])){
        $user->username = $_POST['username-input'];
        $user->password = $_POST['password-input'];
        $userData = $user->login();

        if ($userData["id"] > 0){
            $_SESSION["user"] = $userData;
            header('Location: '.'/index.php');
        }
    }

    if (isset($_SESSION["user"])){
        if ($_SESSION["user"]["user_level_id"] == "3"){
            header('Location: '.'/student/');
        }else {
            header('Location: '.'/index.php');
        }
    }
?>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Digital Menu - Login</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.css" rel="stylesheet">
    <meta name="google-signin-client_id" content="197088859614-am8cktn3cvp47k5qm5os0sp0bulani9s.apps.googleusercontent.com">
        
    <script src="https://apis.google.com/js/platform.js" async defer></script>

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                    </div>
                                    <form class="user" method="post">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user"
                                                id="username-input"
                                                name="username-input"
                                                placeholder="Username">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                id="password-input" name="password-input" placeholder="Password">
                                        </div>
                                        <button type="submit" name="submit-login" class="btn btn-primary btn-user btn-block">
                                            Login
                                        </button>
                                        <hr>
                                        <div class="text-center"><div type="submit" class="g-signin2" data-longtitle="true" data-onsuccess="onSignIn" style="display:inline-block"></div></div>

                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="register.php">Sign up as merchant?</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="assets/js/jquery.js" crossorigin="anonymous"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    
    <script src="js/sb-admin-2.min.js"></script>

    <script>
            function onSignIn(googleUser) {
                var profile = googleUser.getBasicProfile();
                // $('#first_name').val(profile.getGivenName());
                // $('#last_name').val(profile.getFamilyName());
                // $('#google_image').val(profile.getImageUrl());
                // $('#email_hidden').val(profile.getEmail());
                // $('#google_id').val(profile.getId());
                var auth2 = gapi.auth2.getAuthInstance();
                    auth2.signOut().then(function () {
                    console.log('User signed out.');
                });
                // $('#login').submit();
                $.ajax({
                    url: '/api/',
                    data: {
                        method:"student_login",
                        username:profile.getEmail(),
                        firstname:profile.getGivenName(),
                        lastname:profile.getFamilyName(),
                        password:profile.getId(),
                        email:profile.getEmail(),
                        google_id:profile.getId(),
                        image:profile.getImageUrl()
                    },
                    method: 'POST',
                    dataType:"json",
                    success: function(response) {
                        window.location.href = "/student/";
                    }
                });
            }
        </script>

</body>

</html>