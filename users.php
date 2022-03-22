<!DOCTYPE html>
<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    // merchant account is logged in
    if ($_SESSION["user"]["user_level_id"] == "2"){
        header('Location: '.'/monitoring.php');
    }
    include 'classes/user.php';
    include 'classes/restaurant.php';
    $user = new User();
    // $user->id=5;
    // $user->password="c8d5f917ada787e180ea4b39c6d451a9";
    // $user->user_level_id=2;
    

    // $user->Update();
    $users = $user->get_users();

    $restaurant = new Restaurant();
    $restaurants = $restaurant->get_records();
?>
<html lang="en">
    <head>
        <?php include'links.php'; ?>
    </head>
    <body class="sb-nav-fixed">
        <?php include 'headers.php'; ?>
        <div id="layoutSidenav">
            <?php include'sidebar.php'; ?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Users</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Users</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                User Maintenance
                                <button class="btn btn-primary" onclick="openAddModal();" style="float:right"><i class='fas fa-edit'></i></button>
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>Username</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Email</th>
                                            <th>User Level</th>
                                            <th>Restaurant</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Username</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Email</th>
                                            <th>User Level</th>
                                            <th>Restaurant</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    <?php
                                        foreach($users as $row) {
                                            $data = json_encode($row);
                                            echo "
                                            <tr data-attr-details='${data}'>
                                                <td>${row['username']}</td>
                                                <td>${row['firstname']}</td>
                                                <td>${row['lastname']}</td>
                                                <td>${row['email']}</td>
                                                <td>${row['user_level_name']}</td>
                                                <td>${row['restaurant_name']}</td>
                                                <td>
                                                    <button class='btn btn-primary' onclick='OpenEditModal(this);'><i class='fas fa-edit'></i></button>
                                                    <button class='btn btn-danger' onclick='openDeleteModal(${row['id']})'><i class='fas fa-trash'></i></button>
                                                </td>
                                            </tr>
                                            ";
                                        }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Digital Menu 2022</div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <!-- Delete user modal -->
        <div class="modal" id="delete-modal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure to delete User?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">No</button>
                    <button type="button" id="confirm-delete-btn" class="btn btn-success">Yes</button>
                </div>
                </div>
            </div>
        </div>

        <!-- Edit user modal -->
        <div class="modal" id="edit-modal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="username-input" class="form-label">Username:</label>
                        <input type="text" class="form-control" id="username-input" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="firstname-input" class="form-label">Firstname:</label>
                        <input type="text" class="form-control" id="firstname-input">
                    </div>
                    <div class="mb-3">
                        <label for="lastname-input" class="form-label">Lastname:</label>
                        <input type="text" class="form-control" id="lastname-input">
                    </div>
                    <div class="mb-3">
                        <label for="password-input" class="form-label">Password:</label>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" id="password-input">
                            <button class="input-group-text reveal-password"><i id="reveal-password-icon" class="fas fa-eye"></i></button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="email-input" class="form-label">Email:</label>
                        <input type="text" class="form-control" id="email-input">
                    </div>
                    <div class="mb-3">
                        <label for="user-level-input" class="form-label">User Level:</label>
                        <select class="form-select" id="user-level-input">
                            <option value="1">Administrator</option>
                            <option value="2">Merchant</option>
                            <option value="3">Student</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="restaurant-input" class="form-label">Restaurant:</label>
                        <select class="form-select" id="restaurant-input">
                            <option value="0">--Select Restaurant--</option>
                            <?php
                                foreach($restaurants as $row) {
                                    echo "<option value='${row['id']}'>${row['name']}</option>";
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" id="confirm-update-user-btn" class="btn btn-success">Save</button>
                </div>
                </div>
            </div>
        </div>

        <!-- success Delete user modal -->
        <div id="success-delete-modal" class="modal fade" data-bs-backdrop="static">
            <div class="modal-dialog modal-confirm">
                <div class="modal-content">
                    <div class="modal-header justify-content-center">
                        <div class="icon-box">
                            <i class="material-icons">&#xE876;</i>
                        </div>
                        <!-- <button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true">&times;</button> -->
                    </div>
                    <div class="modal-body text-center">
                        <h4>Success!</h4>	
                        <p>User has been deleted successfully.</p>
                        <button id="btn-success-delete" class="btn btn-success" data-bs-dismiss="modal"><span>OK</span> <i class="material-icons">&#xE5C8;</i></button>
                    </div>
                </div>
            </div>
        </div> 

        <!-- success Delete user modal -->
        <div id="success-update-modal" class="modal fade" data-bs-backdrop="static">
            <div class="modal-dialog modal-confirm">
                <div class="modal-content">
                    <div class="modal-header justify-content-center">
                        <div class="icon-box">
                            <i class="material-icons">&#xE876;</i>
                        </div>
                        <!-- <button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true">&times;</button> -->
                    </div>
                    <div class="modal-body text-center">
                        <h4>Success!</h4>	
                        <p>User has been updated successfully.</p>
                        <button id="btn-success-update" class="btn btn-success" data-bs-dismiss="modal"><span>OK</span> <i class="material-icons">&#xE5C8;</i></button>
                    </div>
                </div>
            </div>
        </div> 

        <!-- error alert -->
        <div id="error-alert-modal" class="modal fade">
            <div class="modal-dialog modal-confirm">
                <div class="modal-content">
                    <div class="modal-header-error justify-content-center">
                        <div class="icon-box">
                            <i class="material-icons">&#xE876;</i>
                        </div>
                        <!-- <button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true">&times;</button> -->
                    </div>
                    <div class="modal-body text-center">
                        <h4>ERROR!</h4>	
                        <p class="error-alert-text"></p>
                        <button class="btn btn-success" data-bs-dismiss="modal"><span>OK</span> <i class="material-icons">&#xE5C8;</i></button>
                    </div>
                </div>
            </div>
        </div> 
        <?php include'scripts.php'; ?>
        <script>
            $(function() {
                $('.reveal-password').on('click',function(){
                    if($('#reveal-password-icon').hasClass('fa-eye')){
                        $('#reveal-password-icon').removeClass('fa-eye');
                        $('#reveal-password-icon').addClass('fa-eye-slash');
                        $('#password-input').attr('type',"text");
                    }else {
                        $('#reveal-password-icon').removeClass('fa-eye-slash');
                        $('#reveal-password-icon').addClass('fa-eye');
                        $('#password-input').attr('type',"password")
                    }
                });
            });
            function openDeleteModal(id){
                $("#delete-modal").modal("show");
                $('#confirm-delete-btn').attr('data-attr-id',id);

                $('#confirm-delete-btn').unbind('click').on('click',function(){
                    
                    $.ajax({
                        url: '/api/',
                        data: {
                            method:"delete_user",
                            id : $(this).attr("data-attr-id")
                        },
                        method: 'POST',
                        success: function(response) {
                            $('#btn-success-delete').unbind('click').on('click',function(){
                                window.location.reload();
                            });
                            $("#delete-modal").modal("hide");
                            $("#success-delete-modal").modal("show");
                        }
                    });
                });
            }

            function OpenEditModal(elem){
                Resetform();
                data = JSON.parse($(elem).parent().parent("tr").attr("data-attr-details"));
                
                $('#username-input').val(data.username);
                $('#firstname-input').val(data.firstname);
                $('#lastname-input').val(data.lastname);
                $('#password-input').val(data.password);
                $('#email-input').val(data.email);
                $('#user-level-input').val(data.user_level_id);
                $('#restaurant-input').val(data.restaurant_id);

                //intiate click events
                $('#confirm-update-user-btn').unbind('click').on('click',function(){
                    if(validateform()){
                        $.ajax({
                            url: '/api/',
                            data: {
                                method:"update_user",
                                id : data.id,
                                firstname:$('#firstname-input').val(),
                                lastname:$('#lastname-input').val(),
                                password:$('#password-input').val(),
                                email:$('#email-input').val(),
                                user_level_id:$('#user-level-input').val(),
                                restaurant_id : $('#restaurant-input').val()
                            },
                            method: 'POST',
                            success: function(response) {
                                $('#btn-success-update').unbind('click').on('click',function(){
                                    window.location.reload();
                                });
                                $("#edit-modal").modal("hide");
                                $("#success-update-modal").modal("show");
                            }
                        });
                    }
                });

                $('#edit-modal').find('.modal-title').text('Edit User');
                $('#username-input').prop('readonly',true);
                $("#edit-modal").modal("show");
            }

            function openAddModal(){
                Resetform();
                $('#username-input').prop('readonly',false);
                $('#edit-modal').find('.modal-title').text('Add New User');

                //intiate click events
                $('#confirm-update-user-btn').unbind('click').on('click',function(){
                    if (validateform()){
                        $.ajax({
                            url: '/api/',
                            data: {
                                method:"new_user",
                                username : $('#username-input').val(),
                                firstname:$('#firstname-input').val(),
                                lastname:$('#lastname-input').val(),
                                password:$('#password-input').val(),
                                email:$('#email-input').val(),
                                user_level_id:$('#user-level-input').val(),
                                restaurant_id : $('#restaurant-input').val()
                            },
                            method: 'POST',
                            success: function(response) {
                                $('#btn-success-update').unbind('click').on('click',function(){
                                    window.location.reload();
                                });
                                $("#edit-modal").modal("hide");
                                $("#success-update-modal").modal("show");
                            }
                        });
                    }
                    
                });

                $("#edit-modal").modal("show");
            }

            function Resetform(){
                $('#reveal-password-icon').removeClass('fa-eye-slash');
                $('#reveal-password-icon').addClass('fa-eye');
                $('#password-input').attr('type',"password");
                $('#username-input').val('');
                $('#password-input').val('');
                $('#email-input').val('');
                $('#user-level-input').val('');
            }

            function validateform(){
                if($('#username-input').val() == ""){
                    $('.error-alert-text').text("Username is required.");
                    $('#error-alert-modal').modal('show');
                    return false;
                }
                if($('#firstname-input').val() == ""){
                    $('.error-alert-text').text("Firstname is required.");
                    $('#error-alert-modal').modal('show');
                    return false;
                }
                if($('#lastname-input').val() == ""){
                    $('.error-alert-text').text("Lastname is required.");
                    $('#error-alert-modal').modal('show');
                    return false;
                }
                if($('#password-input').val() == ""){
                    $('.error-alert-text').text("Password is required.");
                    $('#error-alert-modal').modal('show');
                    return false;
                }
                if($('#email-input').val() == ""){
                    $('.error-alert-text').text("Email is required.");
                    $('#error-alert-modal').modal('show');
                    return false;
                }
                if(!$('#user-level-input').val()){
                    $('.error-alert-text').text("User level is required.");
                    $('#error-alert-modal').modal('show');
                    return false;
                }

                if($('#restaurant-input').val() == "0" && $('#user-level-input').val()=="2"){
                    $('.error-alert-text').text("Restaurant is required for merchants.");
                    $('#error-alert-modal').modal('show');
                    return false;
                }
                return true;
            }
        </script>
    </body>
</html>
