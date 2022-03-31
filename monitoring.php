<!DOCTYPE html>
<?php
    include_once "validator.php";
    if(!isset($_SESSION)){
        session_start();
    }
?>
<html lang="en">
    <head>
        <?php include'links.php'; ?>
        <style>
            main:before{
            content: '';
            display:block;
            background: url('/images/logo_borderless.png') center center / 100% auto no-repeat;
            width:45%;
            height: 100%;
            top:25px;
            position: fixed;
            left: 0;
            right: 0;
            margin: auto;
            opacity: 0.1;
            z-index: -1 !important;
        }
        </style>
    </head>
    <body class="sb-nav-fixed">
        <?php include 'headers.php'; ?>
        <div id="layoutSidenav">
            <?php include'sidebar.php'; ?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Monitoring</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Monitoring</li>
                        </ol>
                        <div class="row order-list">
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
                setInterval(GetOrders, 1000);
                
            });

            function GetOrders() {
                $.ajax({
                    url: '/api/',
                    data: {
                        method:"get_monitoring_items",
                        restaurant_id : restaurant_id
                    },
                    method: 'POST',
                    dataType:"json",
                    success: function(response) {
                        $.each(response.data,function(k,v){
                            if ($('.order-list').find('[data-attr-order-id="'+v.order_id+'"]').length ==0) {
                                createOrder(v);
                            }
                            
                            if ($('.order-list').find('[data-attr-order-id="'+v.order_id+'"]').find('[data-attr-oi-id="'+v.id+'"]').length == 0) {
                                $('.order-list').find('[data-attr-order-id="'+v.order_id+'"]').find('.card-body').
                                append(
                                    $('<label>').addClass('col-12 d-flex').attr('data-attr-oi-id',v.id).append(
                                        $('<span>').addClass('col-10').text(v.name + "[" + v.quantity +"]"),
                                        $('<div>').addClass('small text-white col-2').append(
                                            $('<i>').text(v.price)
                                        )
                                    )
                                )
                            }
                        });

                        $('.btn-served').unbind().on('click',function(){
                            $elem = $(this);
                            $.ajax({
                                url: '/api/',
                                data: {
                                    method:"update_order",
                                    id : $(this).parents('.main-container').attr('data-attr-order-id'),
                                    status:4
                                },
                                method: 'POST',
                                dataType:"json",
                                success: function(response) {
                                    $elem.parents('.main-container').remove();
                                }
                            });
                        });
                        
                    }
                });
            }

            function createOrder(data) {
                var status = "bg-success";

                $('.order-list').append(
                    $('<div>').addClass('main-container col-xl-3 col-md-6').attr('data-attr-order-id',data.order_id).append(
                        $('<div>').addClass('card '+status+' text-white mb-4').append(
                            $('<div>').addClass('card-header').text(data.firstname + " " + data.lastname),
                            $('<div>').addClass('card-body').css('height', '150px').css('overflow','auto'),
                            $('<div>').addClass('card-footer align-item-center justify-content-between').append(
                                $('<button>').addClass('btn btn-warning form-control btn-served').text('Served')
                            )
                        )
                    )
                );
            }
        </script>
    </body>
</html>
