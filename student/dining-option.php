<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="author" content="IntegrityNet">
    <meta name="description" content="">
    <meta name="keywords" content="">

    <title>Digital Ordering</title>
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
            <div class="col-four header-nav--btn-left">
                <a class="ordering-btn mobile-btn previousButton"><i class="mdi mdi-arrow-left"></i></a>
            </div>
            <div class="col-four header-nav--center">
                <img hidden src="/static/app-v2/img/icons/resto-logo.png" alt="Resto Logo" class="resto-logo">
            </div>
        </div>
    </header>

    <section class="s-option">
        <div class="row narrowest">
            <div class="col-full">
                <div class="dining-option--wrapper">
                    <div class="dining-option--header">
                        <h2>Select Dining Option</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="row narrowest block-1-2 block-m-1-2 dining-option--boxes">
            <div class="col-block">
                <a href="main.php?dining_option=1&restaurant_id=<?php echo $_REQUEST['restaurant_id'];?>">
                    <div class="dining-option--box dining-option--dinein">
                        <div class="dining-option--box-media">
                            <img src="/static/app-v2/img/icons/dinein.png" alt="">
                        </div>
                        <div class="dining-option--box-text">
                            <h5>Dine In</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-block">
                <a href="main.php?dining_option=0&restaurant_id=<?php echo $_REQUEST['restaurant_id'];?>">
                    <div class="dining-option--box dining-option--takeout">
                        <div class="dining-option--box-media">
                            <img src="/static/app-v2/img/icons/takeout.png" alt="">
                        </div>
                        <div class="dining-option--box-text">
                            <h5>Take Out</h5>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <script src="/static/app-v2/js/jquery-3.2.1.min.js"></script>
    <script src="/static/app-v2/js/plugins.js"></script>
    <script src="/static/app-v2/js/main.js"></script>

    <script>
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