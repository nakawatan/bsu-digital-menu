<!DOCTYPE html>
<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    $root = dirname(__FILE__, 2);
    include $root.'/classes/restaurant.php';
    $obj = new Restaurant();
    $obj->get_active_only = true;
    $obj_list = $obj->get_records();
?>
<html lang="en">
<head>
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
            <?php foreach($obj_list as $row) { ?>
                <div class="col-block" style="margin-bottom: 10px;">
                <a href="main.php?restaurant_id=<?php echo $row['id']?>">
                    <div class="dining-option--box dining-option--dinein">
                        <div class="dining-option--box-media">
                            <img src="<?php echo $row['logo']; ?>" style="height:100px" alt="">
                        </div>
                        <div class="dining-option--box-text">
                            <h5><?php echo $row['name']; ?></h5>
                        </div>
                    </div>
                </a>
            </div>
            <?php } ?>
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
                                <h5>日本語</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-block">
                        <div class="language-list--item">
                            <div class="language-list--item-media">
                                <img src="/static/app-v2/img/icons/china.svg" alt="">
                            </div>
                            <div class="language-list--item-text">
                                <h5>マンダリン</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-block">
                        <div class="language-list--item">
                            <div class="language-list--item-media">
                                <img src="/static/app-v2/img/icons/turkey.svg" alt="">
                            </div>
                            <div class="language-list--item-text">
                                <h5>Türk</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-block">
                        <div class="language-list--item">
                            <div class="language-list--item-media">
                                <img src="/static/app-v2/img/icons/thailand.svg" alt="">
                            </div>
                            <div class="language-list--item-text">
                                <h5>ไทย</h5>
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