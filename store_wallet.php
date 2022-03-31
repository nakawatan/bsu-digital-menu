<!DOCTYPE html>
<?php
    include_once "validator.php";
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    include 'classes/wallet.php';
    include_once 'classes/user.php';
    $obj = new Wallet();
    $obj->user_id = $_SESSION['user']['id'];
    $obj_list = $obj->get_records();

    $user = new User();
    $users = $user->get_users();
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
                        <h1 class="mt-4">Wallet</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Wallet</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Wallet Transactions
                                <button class="btn btn-primary" onclick="openAddModal();" style="float:right"><i class='fas fa-edit'></i></button>
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Type</th>
                                            <th>Status</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Name</th>
                                            <th>Type</th>
                                            <th>Status</th>
                                            <th>Amount</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    <?php
                                        foreach($obj_list as $row) {
                                            $data = json_encode($row);
                                            $transaction_type = "IN";
                                            if ($row['transaction_type'] == "2") {
                                                $transaction_type = "OUT";
                                            }
                                            $status = "Pending";
                                            if ($row['status'] == "2") {
                                                $status = "Approved";
                                            }
                                            if ($row['status'] == "3") {
                                                $status = "Cancelled";
                                            }
                                            echo "
                                            <tr data-attr-details='${data}'>
                                                
                                                <td>${row['name']}</td>
                                                <td>${transaction_type}</td>
                                                <td>${status}</td>
                                                <td>${row['amount']}</td>
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
        <!-- Delete Wallet Transaction modal -->
        <div class="modal" id="delete-modal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Wallet Transaction</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure to delete Wallet Transaction?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">No</button>
                    <button type="button" id="confirm-delete-btn" class="btn btn-success">Yes</button>
                </div>
                </div>
            </div>
        </div>

        <!-- widraw modal -->
        <div class="modal" id="withdraw-modal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Withdraw</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <div class="mb-3">
                        <label for="balance-input" class="form-label">Balance:</label>
                        <input type="number" class="form-control" id="balance-input" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="amount-input" class="form-label">Withdraw Amount:</label>
                        <input type="number" class="form-control" id="amount-input">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" id="confirm-withdraw-btn" class="btn btn-success">Withdraw</button>
                </div>
                </div>
            </div>
        </div>

        <!-- Edit voucher serires modal -->
        <div class="modal" id="edit-modal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Wallet Transaction</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="user-input" class="form-label">User:</label>
                        <select class="form-select" id="user-input">
                            <?php 
                                foreach($users as $row) {
                                    echo "<option value='${row['id']}'>${row['username']}</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="transaction-type-input" class="form-label">Transaction Type:</label>
                        <select class="form-select" id="transaction-type-input">
                            <option value="1">In</option>
                            <option value="2">Out</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="status-input" class="form-label">Status:</label>
                        <select class="form-select" id="status-input">
                            <option value="1">Pending</option>
                            <option value="2">Approved</option>
                            <option value="3">Cancelled</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="amount-input" class="form-label">Amount:</label>
                        <input type="number" class="form-control" id="amount-input">
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
                        <p>Wallet Transaction has been deleted successfully.</p>
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
                        <p>Wallet Transaction has been updated successfully.</p>
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
            var user_id = "<?php echo $_SESSION['user']['id']; ?>";
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

            function openAddModal(){
                Resetform();

                // get balance
                $.ajax({
                    url: '/api/',
                    data : {
                        "method":"get_wallet_balance",
                        "id":user_id

                    },
                    method: 'POST',
                    dataType:"json",
                    success: function(response) {
                        $("#balance-input").val(response.balance);
                    }
                });

                //intiate click events
                $('#confirm-withdraw-btn').unbind('click').on('click',function(){
                    if (validateform()){
                        $.ajax({
                            url: '/api/',
                            data : {
                                "method":"new_wallet_transaction",
                                "user_id":user_id,
                                "transaction_type":2,
                                "status":1,
                                "amount":$('#amount-input').val()

                            },
                            method: 'POST',
                            success: function(response) {
                                $('#btn-success-update').unbind('click').on('click',function(){
                                    window.location.reload();
                                });
                                $("#confirm-withdraw-btn").modal("hide");
                                $("#success-update-modal").modal("show");
                            }
                        });
                    }
                    
                });

                $("#withdraw-modal").modal("show");
            }

            function Resetform(){
                $('#balance-input').val('');
                $('#amount-input').val('');
            }

            function validateform(){
                if($('#amount-input').val() == ""){
                    $('.error-alert-text').text("Amount is required.");
                    $('#error-alert-modal').modal('show');
                    return false;
                }
                if($('#amount-input').val() > $('#balance-input').val()){
                    $('.error-alert-text').text("Insufficient balance.");
                    $('#error-alert-modal').modal('show');
                    return false;
                }
                return true;
            }
        </script>
    </body>
</html>
