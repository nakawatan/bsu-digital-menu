<!DOCTYPE html>
<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    if (isset($_SESSION["user"])){
        if (!$_SESSION["user"]["user_level_id"] == "3"){
            unset($_SESSION);
            header('Location: '.'/login.php');
        }
    }else {
        header('Location: '.'/login.php');
    }

    $root = dirname(__FILE__, 2);
    include $root.'/classes/restaurant.php';
    $obj = new Restaurant();
    $obj->get_active_only = true;
    $obj_list = $obj->get_records();
    
?>
<html lang="en">
<head>
    <style>
        #qr-reader button {
            display: inline-block;
            font-weight: 400;
            line-height: 1.5;
            color: #212529;
            background-color: #198754;
            border-color: #198754;
            text-align: center;
            text-decoration: none;
            vertical-align: middle;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            border-radius: 0.25rem;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        #qr-reader {
            border-radius: 12px;
        }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="author" content="IntegrityNet">
    <meta name="description" content="">
    <meta name="keywords" content="">

    <title>Digital Menu</title>
    <link rel="shortcut icon" href="/static/app-v2/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/static/app-v2/favicon.ico" type="image/x-icon">

    <link rel="stylesheet" href="/static/app-v2/css/base.css">
    <link rel="stylesheet" href="/static/app-v2/css/vendor.css">
    <link rel="stylesheet" href="/static/app-v2/css/main.css">

    <script src="/static/app-v2/js/modernizr.js"></script>
    <script src="/static/app-v2/js/pace.min.js"></script>

</head>
<body class="zapp-dining">
    <header class="header header-top">
        <div class="row narrowest header-nav">
            <!-- <div class="col-four header-nav--btn-left">
                <a class="ordering-btn mobile-btn previousButton"><i class="mdi mdi-arrow-left"></i></a>
            </div>
            <div class="col-four header-nav--center">
                <img hidden src="/static/app-v2/img/icons/resto-logo.png" alt="Resto Logo" class="resto-logo">
            </div> -->
            <!-- <div class="col-four header-nav--btn-right">
                <a class="ordering-btn mobile-btn openLanguage"><i class="mdi mdi-web"></i></a>
            </div> -->
        </div>
    </header>

    <section class="s-option">
        <div class="row narrowest">
            <div class="col-full">
                <div class="dining-option--wrapper">
                    <div class="dining-option--header">
                        <h2>Where will you be eating today?</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="row narrowest block-1-2 block-m-1-2 dining-option--boxes">
            <div id="qr-reader"></div>
            <div id="qr-reader-results"></div>
        </div>
    </section>

    <div id="languageModal" class="modal modal-top modal-small">
        <div class="modal-content">
            <div class="modal-wrapper">
                <div class="row narrowest">
                    <div class="col-full">
                        <div class="languange-list--header">
                            <h3>{{Tf "app/ui" .Language "Select Language"}}</h3>
                        </div>
                    </div>
                </div>

                <div class="row narrowest block-1-2 block-m-1-2 language-list--wrapper">
                    <div class="col-block">
                        <div class="language-list--item">
                            <div class="language-list--item-media">
                                <img src="/static/app-v2/img/icons/united-states.svg" alt="">
                            </div>
                            <div class="language-list--item-text">
                                <h5>English</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-block">
                        <div class="language-list--item">
                            <div class="language-list--item-media">
                                <img src="/static/app-v2/img/icons/philippines.svg" alt="">
                            </div>
                            <div class="language-list--item-text">
                                <h5>Filipino</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-block">
                        <div class="language-list--item">
                            <div class="language-list--item-media">
                                <img src="/static/app-v2/img/icons/japan.svg" alt="">
                            </div>
                            <div class="language-list--item-text">
                                <h5>?????????</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-block">
                        <div class="language-list--item">
                            <div class="language-list--item-media">
                                <img src="/static/app-v2/img/icons/china.svg" alt="">
                            </div>
                            <div class="language-list--item-text">
                                <h5>???????????????</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-block">
                        <div class="language-list--item">
                            <div class="language-list--item-media">
                                <img src="/static/app-v2/img/icons/turkey.svg" alt="">
                            </div>
                            <div class="language-list--item-text">
                                <h5>T??rk</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-block">
                        <div class="language-list--item">
                            <div class="language-list--item-media">
                                <img src="/static/app-v2/img/icons/thailand.svg" alt="">
                            </div>
                            <div class="language-list--item-text">
                                <h5>?????????</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <a class="ordering-btn mobile-btn close-modal"><i class="mdi mdi-close"></i></a>
            </div>
        </div>
    </div>

    <script src="/static/app-v2/js/jquery-3.2.1.min.js"></script>
    <script src="/static/app-v2/js/plugins.js"></script>
    <script src="/static/app-v2/js/main.js"></script>
    <script src="/assets/js/html5-qrcode.min.js"></script>

    <script>
        function docReady(fn) {
            // see if DOM is already available
            if (document.readyState === "complete"
                || document.readyState === "interactive") {
                // call on next available tick
                setTimeout(fn, 1);
            } else {
                $('#qr-reader').find('button')
                document.addEventListener("DOMContentLoaded", fn);
            }
        }

        docReady(function () {
                var resultContainer = document.getElementById('qr-reader-results');
                var lastResult, countResults = 0;
                function onScanSuccess(decodedText, decodedResult) {
                    if (decodedText !== lastResult) {
                        ++countResults;
                        lastResult = decodedText;
                        // Handle on success condition with the decoded message.
                        console.log(`Scan result ${decodedText}`, decodedResult);
                        
                        $.ajax({
                            url: '/api/',
                            data: {
                                method:"get_restaurant_by_qr",
                                id:decodedText
                            },
                            method: 'POST',
                            dataType:"json",
                            success: function(response) {
                                if (response.status != "err") {
                                    window.location.href="dining-option.php?restaurant_id=" + response.data.id;
                                }else {
                                    $("#qr-reader-results").text(response.msg);
                                }
                            }
                        });
                    }
                }

                var html5QrcodeScanner = new Html5QrcodeScanner(
                    "qr-reader", { fps: 10, qrbox: 250 });
                html5QrcodeScanner.render(onScanSuccess);
            });

        // Language Modal
        $('.openLanguage').click(function() {
            $('#languageModal').fadeIn();
        });
        $('#languageModal .close-modal').click(function() {
            $('#languageModal').fadeOut();
        });
    </script>

</body>
</html>