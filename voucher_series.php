<!DOCTYPE html>
<?php
    include_once "validator.php";
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    // merchant account is logged in
    if ($_SESSION["user"]["user_level_id"] == "2"){
        header('Location: '.'/monitoring.php');
    }
    include 'classes/voucher_series.php';
    $obj = new VoucherSeries();
    $obj_list = $obj->get_records();
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
                        <h1 class="mt-4">Voucher Series</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Voucher Series</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Voucher Series Maintenance
                                <button class="btn btn-primary" onclick="openAddModal();" style="float:right"><i class='fas fa-edit'></i></button>
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Amount</th>
                                            <th>Active</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Name</th>
                                            <th>Amount</th>
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
                                                
                                                <td>${row['name']}</td>
                                                <td>${row['amount']}</td>
                                                <td>${active}</td>
                                                <td>
                                                    <a class='btn btn-success' target='_blank' href='/export.php?series_id=${row['id']}'><i class='fas fa-print'></i></a>
                                                    <a class='btn btn-warning' href='/vouchers.php?series_id=${row['id']}'><i class='fas fa-eye'></i></a>
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
        <!-- Delete Voucher Series modal -->
        <div class="modal" id="delete-modal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Voucher Series</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure to delete Voucher Series?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">No</button>
                    <button type="button" id="confirm-delete-btn" class="btn btn-success">Yes</button>
                </div>
                </div>
            </div>
        </div>

        <!-- Edit voucher serires modal -->
        <div class="modal" id="edit-modal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Voucher Series</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name-input" class="form-label">Name:</label>
                        <input type="text" class="form-control" id="name-input">
                    </div>
                    <div class="mb-3">
                        <label for="amount-input" class="form-label">Amount:</label>
                        <input type="number" class="form-control" id="amount-input">
                    </div>
                    <div class="mb-3 series-acount-div">
                        <label for="series-count-input" class="form-label">Count:</label>
                        <input type="number" class="form-control" id="series-count-input">
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
                        <p>Voucher Series has been deleted successfully.</p>
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
                        <p>Voucher Series has been updated successfully.</p>
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
            });
            function openDeleteModal(id){
                $("#delete-modal").modal("show");
                $('#confirm-delete-btn').attr('data-attr-id',id);

                $('#confirm-delete-btn').unbind('click').on('click',function(){
                    
                    $.ajax({
                        url: '/api/',
                        data: {
                            method:"delete_voucher_series",
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
                $('#active-input').bootstrapToggle((data.active == "1" ? "on" : "off"));
                $('#amount-input').val(data.amount);
                $('#series-count-input').val("0");

                $('.series-acount-div').hide();

                //intiate click events
                $('#confirm-update-btn').unbind('click').on('click',function(){
                    if(validateform()){
                        var formData = new FormData();

                        formData.append("method","update_voucher_series");
                        formData.append("id",data.id);
                        formData.append("name",$('#name-input').val());
                        formData.append("amount",$('#amount-input').val());
                        formData.append("active",($('#active-input').is(":checked") ? "1" : "0"));
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

                $('#edit-modal').find('.modal-title').text('Edit Voucher Series');
                $("#edit-modal").modal("show");
            }

            function openAddModal(){
                Resetform();
                $('#edit-modal').find('.modal-title').text('Add New Voucher Series');

                $('.series-acount-div').show();

                //intiate click events
                $('#confirm-update-btn').unbind('click').on('click',function(){
                    if (validateform()){
                        var formData = new FormData();
                        formData.append("method","new_voucher_series");
                        formData.append("name",$('#name-input').val());
                        formData.append("amount",$('#amount-input').val());
                        formData.append("series_count",$('#series-count-input').val());
                        formData.append("active",($('#active-input').is(":checked") ? "1" : "0"));
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

                if($('#amount-input').val() == ""){
                    $('.error-alert-text').text("Amount is required.");
                    $('#error-alert-modal').modal('show');
                    return false;
                }

                if($('#series-count-input').val() == ""){
                    $('.error-alert-text').text("Count is required.");
                    $('#error-alert-modal').modal('show');
                    return false;
                }
                return true;
            }
        </script>
    </body>
</html>
