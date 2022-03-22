<!DOCTYPE html>

<?php 
    $root = dirname(__FILE__, 2);
    include $root.'/classes/category.php';
    $obj = new Category();

    $obj->restaurant_id = $_REQUEST['restaurant_id'];
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

    <style>
        .active-category {
            background-color:#f84c22;
        }

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

</head>

<body class="zapp-main">
    <div id="preloader">
        <div id="loader">
            <div class="line-scale-pulse-out">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
    </div>

    <header class="header header-top">
        <div class="row narrowest header-nav">
            <div class="col-two header-nav--btn-left">
                <a class="ordering-btn mobile-btn openSideNavMenu"><i class="mdi mdi-menu"></i></a>
            </div>
            <div class="col-eight header-nav--center">
            </div>
            <div class="col-two header-nav--btn-right">
                <a class="ordering-btn mobile-btn openSideNavProfile"><i class="mdi mdi-account-circle"></i></a>
            </div>
        </div>
    </header>

    <nav class="main-nav nav-bottom">
        <div class="row narrowest block-1-3 main-nav--wrapper">
            <div class="col-block">
                <div class="main-nav--item active" data-nav="main-home">
                    <div class="main-nav--icon">
                        <i class="mdi mdi-home-variant"></i>
                    </div>
                </div>
            </div>
            <div class="col-block">
                <div class="main-nav--item" data-nav="main-search">
                    <div class="main-nav--icon">
                        <i class="mdi mdi-magnify"></i>
                    </div>
                </div>
            </div>
            <div class="col-block">
                <div class="main-nav--item" data-nav="main-cart">
                    <div class="main-nav--icon">
                        <i class="mdi mdi-shopping"></i>
                    </div>

                    <!-- <span class="item-cart--count"></span> -->
                </div>
            </div>
        </div>
    </nav>

    <nav class="side-nav nav-left nav-menu">
        <div class="row narrowest header-nav">
            <div class="col-two header-nav--btn-left">
                <a class="ordering-btn mobile-btn openLanguage"><i class="mdi mdi-web"></i></a>
            </div>
            <div class="col-eight header-nav--center">
                <h5>Menu</h5>
            </div>
            <div class="col-two header-nav--btn-right">
                <a class="ordering-btn mobile-btn close-nav"><i class="mdi mdi-close"></i></a>
            </div>
        </div>

        <div class="row narrowest nav-menu--group" data-nav-menu="resto">
            <h6>Welcome to</h6>
            <h1 class="resto-name"><img src="/static/app-v2/img/icons/resto-logo.png" alt="" class="resto-logo"> Restaurant Name</h1>
            <h5 class="resto-address"><i class="mdi mdi-map-marker"></i> Restaurant Address</h5>

            <hr>
        </div>

        <div class="row narrowest nav-menu--group" data-nav-menu="categories">
            <h4>Categories</h4>
            <div class="row block-1-4 block-m-1-4 block-tab-1-3 block-mob-1-3 categories-list">
            <?php foreach($obj_list as $row){ 
             echo "
                <div class='col-block'>
                    <div class='categories-list--block'>
                        <div class='categories-list--image'>
                            <img src='${row['image']}' alt=''>
                        </div>

                        <div class='categories-list--name'>
                            <h6>${row['name']}</h6>
                        </div>
                    </div>
                </div>
             ";   
                
            }?>
            </div>

            <hr>
        </div>

        <div hidden class="row narrowest footer-nav">
            <a class="btn btn--pill btn--small full-width"><i class="mdi mdi-swap-horizontal"></i> Switch to <span class="dining-option--name">Takeout</span></a>
        </div>
    </nav>
    
    <nav class="side-nav nav-right nav-profile">
        <div class="row narrowest header-nav">
            <div class="col-two header-nav--btn-left">
                <a class="ordering-btn mobile-btn close-nav"><i class="mdi mdi-chevron-left"></i></a>
            </div>
            <div class="col-eight header-nav--center">
                <h5>Profile</h5>
            </div>
            <div class="col-two header-nav--btn-right">
                <a class="ordering-btn mobile-btn openExitApp"><i class="mdi mdi-exit-to-app"></i></a>
            </div>
        </div>

        <div class="row narrowest nav-profile--group">
            <div class="profile-details">
                <img class="profile-image" src="/static/app-v2/img/icons/account-circle.png" alt="">
                <h1 class="profile-name">Camille Ilan</h1>

                <h4 class="profile-table-code"><span class="light-text">Table Code:</span> <span class="table-code">12345</span></h4>

                <h5 class="light-text">Date logged in:
                    <br>
                    <span class="login-date medium-text">March 06, 2020</span>
                    <span class="login-time medium-text">12:34pm</span>
                </h5>

                <div class="profile-details--cta">
                    <a class="btn btn--stroke btn--pill btn--small openLogout">Logout</a>
                </div>
            </div>

            <hr>
        </div>
    </nav>

    <main class="main-content main-home">
    
        <section class="s-categories">
            <div class="row narrowest categories--wrapper">
                <div class="col-full categories--header">
                    <div class="col-six section--title">
                        <h5>Categories</h5>
                    </div>
                    <div class="col-six section--action">
                        <a hidden class="hide-section--btn"><i class="mdi mdi-minus-box"></i></a>
                    </div>
                </div>
            </div>

            <div class="row narrowest categories--slide">
            <?php foreach($obj_list as $row){ 
                $data = json_encode($row);
                echo "
                <div data-attr-details='${data}' class='categories--slide-item category-item'>
                    <div class='categories--icon'>
                        <img src='${row['image']}' alt=''>
                    </div>
                    <div class='categories--text'>
                        <h6>${row['name']}</h6>
                    </div>
                </div>";
            }?>
            </div>
        </section>
    
        <section class="s-menu">
            <div class="row narrowest menu-grid--wrapper">
                <div class="col-full menu-grid--header">
                    <div class="col-six section--title">
                        <h5 class="menu-grid--category"><img src="/static/app-v2/img/icons/icons8-star-100.png" alt="" class="menu-grid--category-image"> Specials</h5>
                    </div>
                    <div class="col-six section--action">
                        <a class="view-option--btn view-option--grid"><i class="mdi mdi-view-grid"></i></a>
                        <a class="view-option--btn view-option--full active"><i class="mdi mdi-view-agenda"></i></a>
                    </div>
                </div>
            </div>

            <div class="row narrowest block-1-1 menu-grid-items menu-view--full">
                
            </div>
        </section>
    </main>

    <main class="main-content main-filters hidden">
        
    </main>

    <main class="main-content main-search hidden">
        <section class="s-search">
            <div class="search--wrapper">
                <div class="row narrowest search--header">
                    <div class="col-full search--input">
                        <input class="full-width" type="text" placeholder="Search" id="mainSearch">
                    </div>
                </div>
            </div>
        </section>

        <section class="s-results">
            <div class="results-wrapper">
                <div class="row narrowest results-header">
                    <div class="col-six section--title">
                        <h5>Results</h5>
                    </div>
                    <div class="col-six section--action">
                        <a class="view-option--btn view-option--grid"><i class="mdi mdi-view-grid"></i></a>
                        <a class="view-option--btn view-option--full active"><i class="mdi mdi-view-agenda"></i></a>
                    </div>
                </div>
            </div>

            <div hidden class="empty-results--wrapper">
                <div class="row narrowest">
                    <div class="col-full">
                        <div class="empty-results">
                            <i class="mdi mdi-feature-search-outline"></i>
                            <h3>No items available.</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row narrowest block-1-1 menu-grid-items menu-view--solo">
                <div class="col-block">
                    <div class="menu-grid-item">
                        <div class="menu-grid-item--image">
                            <img src="/static/app-v2/img/menu/demo-menu-01.jpg" alt="">
                        </div>
                        <div class="menu-grid-item--text">
                            <h5 class="menu-grid-item--name">Amazing Combo</h5>
                            <p class="menu-grid-item--price">P 1,234.00</p>
                        </div>
                    </div>
                </div>
                <div class="col-block">
                    <div class="menu-grid-item">
                        <div class="menu-grid-item--image">
                            <img src="/static/app-v2/img/menu/demo-menu-01.jpg" alt="">
                        </div>
                        <div class="menu-grid-item--text">
                            <h5 class="menu-grid-item--name">Amazing Combo dasd qawd cxzca ewa eweqaw eqwaxs</h5>
                            <p class="menu-grid-item--price">P 1,234.00</p>
                        </div>
                    </div>
                </div>
                <div class="col-block">
                    <div class="menu-grid-item">
                        <div class="menu-grid-item--image">
                            <img src="/static/app-v2/img/menu/demo-menu-01.jpg" alt="">
                        </div>
                        <div class="menu-grid-item--text">
                            <h5 class="menu-grid-item--name">Amazing Combo</h5>
                            <p class="menu-grid-item--price">P 1,234.00</p>
                        </div>
                    </div>
                </div>
                <div class="col-block">
                    <div class="menu-grid-item">
                        <div class="menu-grid-item--image">
                            <img src="/static/app-v2/img/menu/demo-menu-01.jpg" alt="">
                        </div>
                        <div class="menu-grid-item--text">
                            <h5 class="menu-grid-item--name">Amazing Combo</h5>
                            <p class="menu-grid-item--price">P 1,234.00</p>
                        </div>
                    </div>
                </div>
                <div class="col-block">
                    <div class="menu-grid-item">
                        <div class="menu-grid-item--image">
                            <img src="/static/app-v2/img/menu/demo-menu-01.jpg" alt="">
                        </div>
                        <div class="menu-grid-item--text">
                            <h5 class="menu-grid-item--name">Amazing Combo</h5>
                            <p class="menu-grid-item--price">P 1,234.00</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <main class="main-content main-cart hidden">
        <section class="s-cart">
            <div class="row narrowest cart--header">
                <div class="col-full">
                    <h3>Your Orders</h3>
                </div>
            </div>

            <div hidden class="row narrowest empty-card--wrapper">
                <div class="col-full">
                    <div class="empty-cart">
                        <i class="mdi mdi-shopping-outline"></i>
                        <h3>Your cart is currently empty.</h3>
                    </div>
                </div>
            </div>

            <div class="row narrowest cart-items">
                
            </div>

            <div class="row narrowest cart-receipts">
                <div class="col-full cart-receipt--wrapper">
                    
                    <div class="col-full cart-receipt--group">
                        <div class="col-six cart-receipt--text">
                            <h4>Total</h4>
                        </div>
                        <div class="col-six cart-receipt--amount cart-receipt--total">
                            <h4>P 12,345.00</h4>
                        </div>
                    </div>
                </div>
                <div class="col-twelve cta--primary">
                        <a class="btn btn--primary btn--pill full-width openReviewOrder">Place order(s) <i class="mdi mdi-check-all"></i></a>
                    </div>
            </div>
        </section>
    </main>

    <div id="menuItemModal" class="modal modal-bottom">
        <div class="modal-content">
            <div class="modal-wrapper">
                <header class="header header-top">
                    <div class="row narrowest header-nav">
                        <div class="col-two header-nav--btn-left">
                            <a class="ordering-btn mobile-btn close-modal"><i class="mdi mdi-chevron-left"></i></a>
                        </div>
                        <div class="col-eight header-nav--center">
                            &nbsp;
                        </div>
                        <div class="col-two header-nav--btn-right">
                            &nbsp;
                        </div>
                    </div>
                </header>

                <section class="s-menuitem">
                    <div class="row narrowest menu-item--img-wrapper">
                        <img src="/static/app-v2/img/menu/demo-menu-02.jpg" alt="" class="menu-item--img">
                    </div>
    
                    <div class="row narrowest menu-item--details">
                        <div class="col-full">
                            <div class="menu-item--name">
                                <h3>Amazing Combo (Good for 6 persons)</h3>
                            </div>
                        </div>
    
                        <div class="col-six">
                            <div class="menu-item--price">
                                <h4>P 1,234.00</h4>
                            </div>
                        </div>
    
                        <div class="col-six">
                            <div class="menu-item--quantity modal-proceed-quantity">
                                <i class="quantity-decrease">&minus;</i>
                                <input type="text" value="1" readonly>
                                <i class="quantity-increase">&plus;</i>
                            </div>
                        </div>
    
                        <div class="col-full">
                            <div class="menu-item--description">
                                <div class="menu-item--description-header">
                                    <h5>Description</h5>
                                </div>
                                <div class="menu-item--description-text">
                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Architecto placeat tenetur voluptas vel doloribus voluptatem, distinctio porro repudiandae doloremque vitae esse excepturi sapiente commodi inventore vero officia, eos, nostrum ipsum aperiam? Fugit.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
    
                <div class="cta-wrapper cta-bottom">
                    <div class="row narrowest">
                        <div class="col-twelve cta--primary">
                            <a class="btn btn--primary btn--pill full-width openItemCart">Add To Cart <i class="mdi mdi-shopping"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="itemCartModal" class="modal modal-bottom">
        <div class="modal-content">
            <div class="modal-wrapper">
                <header class="header header-top">
                    <div class="row narrowest header-nav">
                        <div class="col-two header-nav--btn-left">
                            <a class="ordering-btn mobile-btn close-modal"><i class="mdi mdi-chevron-left"></i></a>
                        </div>
                        <div class="col-eight header-nav--center">
                            <h5>Item Cart <span class="item-cart--count">3</span></h5>
                        </div>
                        <div class="col-two header-nav--btn-right">
    
                        </div>
                    </div>
                </header>
    
                <section class="s-itemcart">
                    <div hidden class="row narrowest empty-cart--wrapper">
                        <div class="col-full">
                            <div class="empty-cart">
                                <i class="mdi mdi-shopping-outline"></i>
                                <h3>Your cart is currently empty.</h3>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="row narrowest cart-items">
                        
                    </div> -->
    
                    <div class="row narrowest cart-receipts">
                        <div class="col-full cart-receipt--wrapper">
                            <div class="col-full cart-receipt--group">
                                <div class="col-six cart-receipt--text">
                                    <h4>Total</h4>
                                </div>
                                <div class="col-six cart-receipt--amount cart-receipt--total">
                                    <h4>P 12,345.00</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
    
                <div class="cta-wrapper cta-bottom">
                    <div class="row narrowest">
                        <div class="col-three cta--secondary">
                            <a class="btn btn--pill full-width"><i class="mdi mdi-plus-circle"></i></a>
                        </div>
                        <div class="col-nine cta--primary">
                            <a class="btn btn--primary btn--pill full-width openReviewOrder">Place order(s) <i class="mdi mdi-check-all"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="removeCartItemModal" class="modal modal-top modal-small">
        <div class="modal-content">
            <div class="modal-wrapper">
                <div class="row narrowest">
                    <div class="col-full remove-item--wrapper">
                        <h4>Remove this item?</h4>

                        <div class="remove-item--cta">
                            <a class="ordering-btn primary-btn rounded-btn block-btn removeItemBtn">Remove <i class="mdi mdi-trash-can-outline"></i></a>
                            <a class="ordering-btn secondary-btn rounded-btn block-btn close-modal">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="reviewOrderModal" class="modal modal-top modal-small">
        <div class="modal-content">
            <div class="modal-wrapper">
                <div class="row narrowest">
                    <div class="col-full review-order--wrapper">
                        <h1><i class="mdi mdi-information-outline"></i></h1>
                        <h3>Confirm Order?</h3>
    
                        <div class="review-order--cta">
                            <a class="ordering-btn primary-btn rounded-btn block-btn openPaymentMethod">Confirm <i class="mdi mdi-check-all"></i></a>
                            <a class="ordering-btn secondary-btn rounded-btn block-btn close-modal">Cancel <i class="mdi mdi-eye-outline"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="scan-voucher-modal" class="modal modal-top">
        <div class="modal-content">
            <div class="modal-wrapper">
                <header class="header header-top">
                    <div class="row narrowest header-nav">
                        <div class="col-two header-nav--btn-left">
                            <a class="ordering-btn mobile-btn close-modal"><i class="mdi mdi-chevron-left"></i></a>
                        </div>
                        <div class="col-eight header-nav--center">
                            <h5>Scan Voucher</h5>
                        </div>
                        <div class="col-two header-nav--btn-right">

                        </div>
                    </div>
                </header>

                <section class="s-payment">
                    <div class="row narrowest">
                        <div class="col-full">
                            <div class="payment-method--wrapper">
                                <div class="payment-method--header">
                                    
                                </div>

                                <div class="row block-1-2 payment-method--boxes">
                                    <div id="qr-reader"></div>
                                    <div id="qr-reader-results"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <div id="paymentThanksModal" class="modal modal-top modal-small">
        <div class="modal-content">
            <div class="modal-wrapper">
                <div class="row narrowest">
                    <div class="col-full">
                        <div class="payment-thanks--wrapper">
                            <h1><i class="mdi mdi-checkbox-marked-circle-outline"></i></h1>
                            <!-- <img src="img/illustrations/undraw_confirmed_81ex.svg" alt="" class="payment-thanks--image"> -->
                            <h3>Order Confirmed</h3>
                            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Magnam veritatis officia, sed quaerat eius iste.</p>

                            <div class="payment-thanks--cta">
                                <a class="ordering-btn primary-btn rounded-btn block-btn close-modal--all">Add More Items <i class="mdi mdi-plus-circle"></i></a>
                                <a class="ordering-btn secondary-btn rounded-btn block-btn openExitApp">Exit App <i class="mdi mdi-exit-to-app"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="logoutModal" class="modal modal-left modal-small">
        <div class="modal-content">
            <div class="modal-wrapper">
                <div class="row narrowest">
                    <div class="col-full">
                        <div class="logout--wrapper">
                            <h1><i class="mdi mdi-information-outline"></i></h1>
                            <h3>Are you sure you want to logout?</h3>

                            <div class="review-order--cta">
                            <a href="customer.html" class="ordering-btn primary-btn rounded-btn block-btn logoutButton">Logout</a>
                            <a class="ordering-btn secondary-btn rounded-btn block-btn close-modal">Cancel</a>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="exitAppModal" class="modal modal-right modal-small">
        <div class="modal-content">
            <div class="modal-wrapper">
                <div class="row narrowest">
                    <div class="col-full">
                        <div class="exit-app--wrapper">
                            <h1><i class="mdi mdi-information-outline"></i></h1>
                            <h3>Exit App?</h3>

                            <div class="review-order--cta">
                                <a href="./" class="ordering-btn primary-btn rounded-btn block-btn exitAppButton">Exit <i class="mdi mdi-exit-to-app"></i></a>
                                <a class="ordering-btn secondary-btn rounded-btn block-btn close-modal">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="languageModal" class="modal modal-top modal-small">
        <div class="modal-content">
            <div class="modal-wrapper">
                <div class="row narrowest">
                    <div class="col-full">
                        <div class="languange-list--header">
                            <h3>Select Language</h3>
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
    <script src="/static/app-v2/js/item.js"></script>

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
        var restaurant_id = "<?php echo $_REQUEST['restaurant_id']; ?>";
        /* Interface
        * ------------------------------------------------------ */
        
        /* Main Nav Tabs
        * ------------------------------------------------------ */
        $('.main-nav--wrapper .main-nav--item').unbind().click(function() {
            $('.main-nav--wrapper .main-nav--item').removeClass('active');
            $(this).addClass('active');
            $('.main-content').addClass('hidden');
            $('.main-content.' + $(this).attr('data-nav')).removeClass('hidden');
        });


        /* Side Nav
        * ------------------------------------------------------ */
        // Side Nav Left
        $('.openSideNavMenu').click(function() {
            $('.side-nav.nav-left').css("width", "100%");
            $('body').addClass('side-nav-open');
        });
        $('.close-nav').click(function() {
            $('.side-nav.nav-left').css("width", "0");
            $('body').removeClass('side-nav-open');
        });

        // Side Nav Right
        $('.openSideNavProfile').click(function() {
            $('.side-nav.nav-right').css("width", "100%");
            $('body').addClass('side-nav-open');
        });
        $('.close-nav').click(function() {
            $('.side-nav.nav-right').css("width", "0");
            $('body').removeClass('side-nav-open');
        });


        /* Sticky Header: Categories, Search
        * ------------------------------------------------------ */
        $(window).scroll(function() {
            if ($(window).scrollTop() > 100){  
                $('.s-categories, .s-search').addClass("sticky");
            }
            else{
                $('.s-categories, .s-search').removeClass("sticky");
            }
        });


        /* Menu View Option (Full or Grid)
        * ------------------------------------------------------ */
        $('.view-option--full').click(function() {
            $('.menu-grid-items').removeClass('block-1-2');
            $('.menu-grid-items').addClass('block-1-1');
            $('.menu-grid-items').removeClass('menu-view--grid');
            $('.menu-grid-items').addClass('menu-view--full');
            $('.view-option--grid').removeClass('active');
            $(this).addClass('active');
        });
        $('.view-option--grid').click(function() {
            $('.menu-grid-items').removeClass('block-1-1');
            $('.menu-grid-items').addClass('block-1-2');
            $('.menu-grid-items').removeClass('menu-view--full');
            $('.menu-grid-items').addClass('menu-view--grid');
            $('.view-option--full').removeClass('active');
            $(this).addClass('active');
        });


        /* Hide Section Buttons
        * ------------------------------------------------------ */
        // Promo
        $('.s-promo .hide-section--btn').click(function() {
            $('.featured-promo--slide').slideToggle("fast");
            $('.s-promo .hide-section--btn i').toggleClass("mdi-minus-box mdi-plus-box");
        });
        $('.nav-menu .featured-promo--header').click(function() {
            $('.featured-promo--content').slideToggle("fast");
            $('.nav-menu .featured-promo--header i').toggleClass("mdi-chevron-down mdi-chevron-right");
        });
        

        // Categories
        $('.s-categories .hide-section--btn').click(function() {
            $('.categories--slide').slideToggle("fast");
            $('.s-categories .hide-section--btn i').toggleClass("mdi-minus-box mdi-plus-box");
        });

        // Modifiers
        $('.s-modifier').on('click', '.modifier-group--header', function(e) {
            console.log("hide");
            e.preventDefault();
            $(this).find('.hide-section--btn i').toggleClass("mdi-minus-box mdi-plus-box");
            $(this).next('.modifier-group--items').slideToggle("fast");
        });

        /* Modals
        * ------------------------------------------------------ */
        // Menu Item Modal
        $('.menu-grid-item').unbind().click(function() {
            $('body').addClass('modal-open');
            $('#menuItemModal').fadeIn();
        });
        $('#menuItemModal .close-modal').unbind().click(function() {
            $('body').removeClass('modal-open');
            $('#menuItemModal').fadeOut();
        });
        
        // Menu Item Modifiier Modal
        $('.openMenuItemModifier').click(function() {
            $('#menuItemModifierModal').fadeIn();
        })
        $('#menuItemModifierModal .close-modal').click(function() {
            $('#menuItemModifierModal').fadeOut();
        });
        
        // Item Cart Modal
        $('.openItemCart').click(function() {
            $('#itemCartModal').fadeIn();
        })
        $('#itemCartModal .close-modal').click(function() {
            $('#itemCartModal').fadeOut();
        });
        
        // Remove Cart Item Modal
        $('.delete-section--btn').click(function() {
            $('#removeCartItemModal').fadeIn();
        })
        $('#removeCartItemModal .close-modal').click(function() {
            $('#removeCartItemModal').fadeOut();
        });

        // Review Order Modal
        $('.openReviewOrder').click(function() {
            $('#reviewOrderModal').fadeIn();
        })
        $('#reviewOrderModal .close-modal').click(function() {
            $('#reviewOrderModal').fadeOut();
        });
        
        // Payment Method Modal
        $('.openPaymentMethod').click(function() {
            // PlaceOrder();
            $('#scan-voucher-modal').fadeIn();

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
                                method:"validate_voucher",
                                id:decodedText,
                                amount:calculateTotal()
                            },
                            method: 'POST',
                            dataType:"json",
                            success: function(response) {
                                if (response.status=="ok") {
                                    PlaceOrder(response.voucher.id);
                                }else {
                                    alert(response.msg);
                                }
                            }
                        });
                    }
                }

                var html5QrcodeScanner = new Html5QrcodeScanner(
                    "qr-reader", { fps: 10, qrbox: 250 });
                html5QrcodeScanner.render(onScanSuccess);
            });


            $('#reviewOrderModal').fadeOut();
        })
        $('#scan-voucher-modal .close-modal').click(function() {
            $('#scan-voucher-modal').fadeOut();
        });
        
        // Payment Thanks Modal
        $('.payment-method--cash').click(function() {
            $('#paymentThanksModal').fadeIn();
        })
        $('#paymentThanksModal .close-modal').click(function() {
            $('#paymentThanksModal').fadeOut();
        });

        // Exit App Modal
        $('.openLogout').click(function() {
            $('#logoutModal').fadeIn();
        });
        $('#logoutModal .close-modal').click(function() {
            $('#logoutModal').fadeOut();
        });
        
        // Exit App Modal
        $('.openExitApp').click(function() {
            $('#exitAppModal').fadeIn();
        });
        $('#exitAppModal .close-modal').click(function() {
            $('#exitAppModal').fadeOut();
        });
        
        // Language Modal
        $('.openLanguage').click(function() {
            $('#languageModal').fadeIn();
        });
        $('#languageModal .close-modal').click(function() {
            $('#languageModal').fadeOut();
        });
        
        // Close All
        $('.close-modal--all').click(function() {
            $('body').removeClass('modal-open');
            $('.modal').fadeOut();
        });


        /* Selected Menu Item
        * ------------------------------------------------------ */
        $('.selected-menuitem--open').click(function() {
            $('.selected-menuitem').fadeToggle();
        });
        $('.collapse-section--btn').click(function() {
            $('.selected-menuitem').fadeOut();
        });


        /* Modifier Selection
        * ------------------------------------------------------ */
        $('.modifier-group--item').unbind().click(function(){
            $('.modifier-group--item').removeClass('active');
            $(this).addClass('active');
            // $('.modifier-item--quantity').fadeIn();
        });


        /* Quantity Counter
        * ------------------------------------------------------ */
        $('.modal-proceed-quantity i').click(function() {
            val = parseInt($('.modal-proceed-quantity input').val());

            if ($(this).hasClass('quantity-decrease')) {
                val = val - 1;
            } else if ($(this).hasClass('quantity-increase')) {
                val = val + 1;
            }

            if (val < 1) {
                val = 1;
            }

            $('.modal-proceed-quantity input').val(val);
        });

        
        /* Remove Cart Item - Test
        * ------------------------------------------------------ */
        $('.removeItemBtn').click(function() {
            $('#removeCartItemModal').fadeOut();
            $('.test-remove').fadeOut();
        });

        // category click
        $('.category-item').on('click',function() {
            data = JSON.parse($(this).attr('data-attr-details'));
            $('.menu-grid--category').text(data.name);
            $('.category-item').removeClass('active-category');
            $(this).addClass('active-category');
            $.ajax({
                url: '/api/',
                data: {
                    method:"get_menu_items_by_category",
                    category_id:data.id
                },
                method: 'POST',
                dataType:"json",
                success: function(response) {
                    $('.menu-grid-items').html('');
                    $.each(response.menuitems,function(k,v){
                        var details = JSON. stringify(v);
                        $('.menu-grid-items').append(
                            $('<div>').addClass('col-block').append(
                                $("<div>").addClass('menu-grid-item').attr('data-attr-details',details).append(
                                    $('<div>').addClass('menu-grid-item--image').append(
                                        $('<img>').attr('src',v.image)
                                    ),
                                    $('<div>').addClass('menu-grid-item--text').append(
                                        $('<h5>').addClass('menu-grid-item--name').text(v.name),
                                        $('<p>').addClass('menu-grid-item--price').text(v.price)
                                    )
                                )
                            )
                        );
                        // <div class="col-block">
                        //     <div class="menu-grid-item">
                        //         <div class="menu-grid-item--image">
                        //             <img src="/static/app-v2/img/menu/demo-menu-01.jpg" alt="">
                        //         </div>
                        //         <div class="menu-grid-item--text">
                        //             <h5 class="menu-grid-item--name">Amazing Combo</h5>
                        //             <p class="menu-grid-item--price">P 1,234.00</p>
                        //         </div>
                        //     </div>
                        // </div>
                    });

                    // click functionality
                    $('.menu-grid-item').unbind().click(function() {
                        var data = JSON.parse($(this).attr('data-attr-details'));
                        $('.menu-item--img').attr('src',data.image);
                        $('.menu-item--name').html('').append(
                            $('<h3>').text(data.name)
                        );
                        $('.menu-item--price').html('').append(
                            $('<h4>').text('Php ' + data.price)
                        );
                        $('.menu-item--description-text').html('').append(
                            $('<p>').text(data.description)
                        );
                        $('body').addClass('modal-open');
                        $('#menuItemModal').fadeIn();

                        // proceed modal
                        $('.openItemCart').unbind().click(function() {
                            var orderitem = {
                                "menuitem":data,
                                "quantity":$('.modal-proceed-quantity input').val()
                            }
                            var details = JSON. stringify(orderitem);
                            $('body').removeClass('modal-open');
                            $('#menuItemModal').fadeOut();
                            $('.cart-items').append(
                                $('<div>').addClass('col-full cart-item--block with-modifier test-remove').attr('data-attr-details',details).append(
                                    $('<div>').addClass('col-full cart-item').append(
                                        $('<div>').addClass('col-four cart-item--image').append(
                                            $('<img>').attr('src',data.image)
                                        ),
                                        $('<div>').addClass('col-eight cart-item--text').append(
                                            $('<h5>').addClass('cart-item--name').text(data.name),
                                            $('<p>').addClass('cart-item--price').text('Php ' + data.price).append(
                                                $('<span>').addClass('cart-item--quantity-count').text(' [x'+$('.modal-proceed-quantity input').val()+']')
                                            )
                                        ),
                                        $('<div>').addClass('cart-item-delete').append(
                                            $('<a>').addClass('delete-section--btn').append(
                                                $('<i>').addClass('mdi mdi-trash-can-outline')
                                            )
                                        ),
                                        $('<div>').addClass('col-full').append(
                                            $('<div>').addClass('cart-item--quantity').append(
                                                $('<div>').addClass('menu-item--quantity').append(
                                                    $('<i>').addClass('quantity-decrease').text('−'),
                                                    $('<input>').attr('type','text').val($('.modal-proceed-quantity input').val()).attr('readonly','readonly'),
                                                    $('<i>').addClass('quantity-increase').text('+')
                                                )
                                            )
                                        )
                                    )
                                )
                            );
                             /* Quantity Counter
                            * ------------------------------------------------------ */
                            $('.test-remove .menu-item--quantity i').unbind().click(function() {
                                var details = JSON.parse($(this).parents('.test-remove').attr('data-attr-details'));
                                
                                val = parseInt($(this).siblings('.menu-item--quantity input').val());

                                if ($(this).hasClass('quantity-decrease')) {
                                    val = val - 1;
                                } else if ($(this).hasClass('quantity-increase')) {
                                    val = val + 1;
                                }

                                if (val < 1) {
                                    val = 1;
                                }

                                $(this).siblings('.menu-item--quantity input').val(val);
                                details.quantity = val
                                $(this).siblings('.menu-item--quantity input').val(val);
                                $(this).parents('.test-remove').find('.cart-item--quantity-count').text(' [x' + val +']')
                                var orderitem = JSON. stringify(details);
                                $(this).parents('.test-remove').attr('data-attr-details',orderitem);
                                calculateTotal();
                            });
                            calculateTotal();
                        })
                        $('#itemCartModal .close-modal').click(function() {
                            $('body').removeClass('modal-open');
                            $('#itemCartModal').fadeOut();
                        });
                    });
                    $('#menuItemModal .close-modal').unbind().click(function() {
                        $('body').removeClass('modal-open');
                        $('#menuItemModal').fadeOut();
                    });
                }
            });
        });

        if ($('.category-item').length > 0) {
            $('.category-item')[0].click();
        }

        function calculateTotal() {
            total = 0;
            $.each($('.cart-item'),function(k,v) {
                details = JSON.parse($(v).parents('.test-remove').attr('data-attr-details'));
                total += details.quantity * details.menuitem.price;
            });
            $('.cart-receipt--total h4').text(total);
            return total;
        }

        function PlaceOrder(voucher_id){
            total = 0;
            var order_items = [];
            $.each($('.cart-item'),function(k,v) {
                details = JSON.parse($(v).parents('.test-remove').attr('data-attr-details'));
                total += details.quantity * details.menuitem.price;
                order_items.push({
                    menu_item_id:details.menuitem.id,
                    price:details.menuitem.price,
                    quantity:details.quantity
                });
            });
            $.ajax({
                url: '/api/',
                data: {
                    method:"create_order",
                    restaurant_id:restaurant_id,
                    voucher_id : voucher_id,
                    user_id : 1,
                    total:  total,
                    order_items: order_items,
                },
                method: 'POST',
                dataType:"json",
                success: function(response) {
                    console.log(response);
                }
            });
            $('#scan-voucher-modal').fadeOut();
            $('.cart-items').empty();
            $('.cart-receipt--total h4').text("0.00");
        }

    </script>
</body>

</html>