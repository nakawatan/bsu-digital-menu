<!DOCTYPE html>
<?php
    include_once "validator.php";
    include 'classes/menuitem.php';
    include 'classes/category.php';
    $obj = new MenuItem();

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    // merchant account is logged in
    if ($_SESSION["user"]["user_level_id"] == "2"){
        $obj->restaurant_id = $_SESSION["user"]["restaurant_id"];
    }
    $obj_list = $obj->get_records();

    $category = new Category();
    // merchant account is logged in
    if ($_SESSION["user"]["user_level_id"] == "2"){
        $category->restaurant_id = $_SESSION["user"]["restaurant_id"];
    }
    $categories = $category->get_records();
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
                        <h1 class="mt-4">Menu Item</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Menu Item</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Menu Item Maintenance
                                <button class="btn btn-primary" onclick="openAddModal();" style="float:right"><i class='fas fa-edit'></i></button>
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Category</th>
                                            <th>Price</th>
                                            <th>Active</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Category</th>
                                            <th>Price</th>
                                            <th>Active</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    <?php
                                        foreach($obj_list as $row) {
                                            $data = json_encode($row);
                                            $active = "<i class='fas fa-solid fa-check' style='color:#004d03'></i>";
                                            if ($row['active'] == "0") {
                                                $active = "<i style='color:#841306;font-weight: bold;'>x</i>";
                                            }
                                            echo "
                                            <tr data-attr-details='${data}'>
                                                <td><img width='75px' src='${row['image']}'></img></td>
                                                <td>${row['name']}</td>
                                                <td>${row['description']}</td>
                                                <td>${row['category_name']}</td>
                                                <td>${row['price']}</td>
                                                <td>${active}</td>
                                                <td>
                                                    <button class='btn btn-primary' onclick='OpenEditModal(this);'><i class='fas fa-edit'></i></button>
                                                    
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
        <!-- Delete Menu Item modal -->
        <div class="modal" id="delete-modal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Menu Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure to delete Menu Item?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">No</button>
                    <button type="button" id="confirm-delete-btn" class="btn btn-success">Yes</button>
                </div>
                </div>
            </div>
        </div>

        <!-- Edit Menu Item modal -->
        <div class="modal" id="edit-modal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Menu Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name-input" class="form-label">Name:</label>
                        <input type="text" class="form-control" id="name-input">
                    </div>
                    <div class="mb-3">
                        <label for="image-input" class="form-label">Image:</label>
                        <input class="form-control" type="file" id="image-input">
                    </div>
                    <div class="mb-3">
                        <label for="description-input" class="form-label">Description:</label>
                        <!-- <input type="text" class="form-control" id="abstract-input"> -->
                        <textarea class="form-control" id="description-input">

                        </textarea>
                    </div>
                    <div class="mb-3">
                        <label for="category-input" class="form-label">Category:</label>
                        <select class="form-select" id="category-input">
                            <option value="0">--Select Category--</option>
                            <?php
                                foreach($categories as $row) {
                                    echo "<option value='${row['id']}'>${row['name']}</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="price-input" class="form-label">Price:</label>
                        <input class="form-control" type="number" id="price-input">
                    </div>
                    <div class="mb-3">
                        <label for="active-input" class="form-label">Active:</label>
                        <!-- <input type="checkbox" class="form-control" id = "active-input" checked data-toggle="toggle" data-on="Active" data-off="Inactive"> -->
                        <input type="checkbox" id = "active-input" checked data-toggle="toggle">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" id="confirm-update-btn" class="btn btn-success">Save</button>
                </div>
                </div>
            </div>
        </div>

        <!-- success Delete modal -->
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
                        <p>Menu Item has been deleted successfully.</p>
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
                        <p>Menu Item has been updated successfully.</p>
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
            var restaurant_id = "<?php echo $_SESSION["user"]["restaurant_id"]; ?>";
            $(function() {
            });
            function openDeleteModal(id){
                $("#delete-modal").modal("show");
                $('#confirm-delete-btn').attr('data-attr-id',id);

                $('#confirm-delete-btn').unbind('click').on('click',function(){
                    
                    $.ajax({
                        url: '/api/',
                        data: {
                            method:"delete_menuitem",
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
                
                $('#name-input').val(data.name);
                $('#price-input').val(data.price);
                $('#description-input').val(data.description);
                $('#category-input').val(data.category_id);
                $('#active-input').bootstrapToggle((data.active == "1" ? "on" : "off"));

                //intiate click events
                $('#confirm-update-btn').unbind('click').on('click',function(){
                    if(validateform()){
                        var formData = new FormData();
                        if ($('#image-input')[0].files.length > 0) {
                            myFile = $('#image-input')[0].files[0];
                            formData.append("image",myFile);
                        }
                        formData.append("method","update_menuitem");
                        formData.append("name",$('#name-input').val());
                        formData.append("price",$('#price-input').val());
                        formData.append("description",$('#description-input').val());
                        formData.append("category_id",$('#category-input').val());
                        formData.append("active",($('#active-input').is(":checked") ? "1" : "0"));
                        formData.append("restaurant_id",restaurant_id);
                        formData.append("id",data.id);
                        $.ajax({
                            url: '/api/',
                            data : formData,
                            method: 'POST',
                            contentType: false,
				            processData: false,
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

                $('#edit-modal').find('.modal-title').text('Edit Menu Item');
                $("#edit-modal").modal("show");
            }

            function openAddModal(){
                Resetform();
                $('#edit-modal').find('.modal-title').text('Add New Menu Item');

                //intiate click events
                $('#confirm-update-btn').unbind('click').on('click',function(){
                    if (validateform()){
                        var formData = new FormData();
                        if ($('#image-input')[0].files.length > 0) {
                            myFile = $('#image-input')[0].files[0];
                            formData.append("image",myFile);
                        }
                        formData.append("method","new_menuitem");
                        formData.append("name",$('#name-input').val());
                        formData.append("price",$('#price-input').val());
                        formData.append("description",$('#description-input').val());
                        formData.append("category_id",$('#category-input').val());
                        formData.append("active",($('#active-input').is(":checked") ? "1" : "0"));
                        formData.append("restaurant_id",restaurant_id);
                        $.ajax({
                            url: '/api/',
                            data : formData,
                            method: 'POST',
                            contentType: false,
				            processData: false,
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
                $('#name-input').val('');
            }

            function validateform(){
                if($('#name-input').val() == ""){
                    $('.error-alert-text').text("Name is required.");
                    $('#error-alert-modal').modal('show');
                    return false;
                }
                return true;
            }
        </script>
    </body>
</html>