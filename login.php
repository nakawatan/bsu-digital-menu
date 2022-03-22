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
        <?php include'links.php'; ?>
        <meta name="google-signin-client_id" content="180607259648-knu2mj80ku44bum6336jd71ub3u692dn.apps.googleusercontent.com">
        <script src="https://apis.google.com/js/platform.js" async defer></script>
        <style>
            .logo-margin-negative{
                margin-top: -100px;
            }
        </style>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main1>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header">
                                        <h3 class="text-center font-weight-light my-4"><img width="100px" src="/images/logo_borderless.png" class="center-block img-circle logo-margin-negative"></h3>
                                        <h3 class="text-center font-weight-light my-4">Login</h3>
                                    </div>
                                    <div class="card-body">
                                        <form method="post">
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="username-input" type="text" name="username-input" placeholder="Username"/>
                                                <label for="username-input">Username</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="password-input" type="password" placeholder="Password" name="password-input"/>
                                                <label for="password-input">Password</label>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <!-- <a class="small" href="password.html">Forgot Password?</a> -->
                                                <button type="submit" class="btn btn-primary" name="submit-login">Login</button>
                                                <div class="text-center"><div type="submit" class="g-signin2" data-longtitle="true" data-onsuccess="onSignIn" style="display:inline-block"></div></div>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- <div class="card-footer text-center py-3">
                                        <div class="small"><a href="register.html">Need an account? Sign up!</a></div>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </main1>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Digital Menu 2021</div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>

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
