<?php
include('header.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guluran Thrift</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="css/magnific-popup.css" type="text/css">
    <link rel="stylesheet" href="css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">
</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Hero Section Begin -->
    <section class="hero">
        <div class="hero__slider owl-carousel">
            <div class="hero__items set-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-5 col-lg-7 col-md-8">
                            <div class="hero__text">
                                <h2>Thrift Store 2024</h2>
                                <p>Temukan koleksi thrift terbaik untuk penampilan yang elegan dan stylish.</p>
                                <a href="./shop.php" class="primary-btn">Belanja Sekarang <span class="arrow_right"></span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->

    <!-- Product Section Begin -->
    <section class="product spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <ul class="filter__controls">
                        <li class="active" data-filter="*">Related Products</li>
                        <li data-filter=".best-sellers">Best Sellers</li>
                        <li data-filter=".new-arrivals">New Arrivals</li>
                    </ul>
                </div>
            </div>
            <div class="row product__filter">
                <div class="col-lg-3 col-md-6 col-sm-6 col-md-6 col-sm-6 mix best-sellers">
                    <div class="product__item sale">
                        <div class="product__item__pic set-bg" data-setbg="img/product/product-2.jpg">
                            <span class="label">Best</span>
                            <ul class="product__hover">
                                <li><a href="./shop-details.php"><img src="img/icon/search.png" alt=""> <span>Details</span></a></li>
                                <li><a href="#"><img src="img/icon/cart.png" alt=""> <span>Cart</span></a></li>
                            </ul>
                        </div>
                        <div class="product__item__text">
                            <h6>Piqué Biker Jacket</h6>
                            <h5>Rp.50.000</h5>
                            <div class="product__color__select">
                                <label class="active black" for="pc-23">
                                    <input type="radio" id="pc-23">
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-md-6 col-sm-6 mix new-arrivals">
                    <div class="product__item new">
                        <div class="product__item__pic set-bg" data-setbg="img/product/product-12.jpg">
                            <span class="label">New</span>
                            <ul class="product__hover">
                                <li><a href="./shop-details.php"><img src="img/icon/search.png" alt=""> <span>Details</span></a></li>
                                <li><a href="#"><img src="img/icon/cart.png" alt=""> <span>Cart</span></a></li>
                            </ul>
                        </div>
                        <div class="product__item__text">
                            <h6>Multi-pocket Chest Bag</h6>
                            <h5>Rp.100.000</h5>
                            <div class="product__color__select">
                                <label class="active black" for="pc-23">
                                    <input type="radio" id="pc-23">
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-md-6 col-sm-6 mix best-sellers">
                    <div class="product__item">
                        <div class="product__item__pic set-bg" data-setbg="img/product/product-4.jpg">
                            <ul class="product__hover">
                                <li><a href="./shop-details.php"><img src="img/icon/search.png" alt=""> <span>Details</span></a></li>
                                <li><a href="#"><img src="img/icon/cart.png" alt=""> <span>Cart</span></a></li>
                            </ul>
                        </div>
                        <div class="product__item__text">
                            <h6>Diagonal Textured Cap</h6>
                            <h5>Rp.50.000</h5>
                            <div class="product__color__select">
                                <label class="active black" for="pc-23">
                                    <input type="radio" id="pc-23">
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-md-6 col-sm-6 mix new-arrivals">
                    <div class="product__item">
                        <div class="product__item__pic set-bg" data-setbg="img/product/product-8.jpg">
                            <ul class="product__hover">
                                <li><a href="./shop-details.php"><img src="img/icon/search.png" alt=""> <span>Details</span></a></li>
                                <li><a href="#"><img src="img/icon/cart.png" alt=""> <span>Cart</span></a></li>
                            </ul>
                        </div>
                        <div class="product__item__text">
                            <h6>Basic Flowing Scarf</h6>
                            <h5>Rp.100.000</h5>
                            <div class="product__color__select">
                                <label class="active black" for="pc-23">
                                    <input type="radio" id="pc-23">
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Product Section End -->

    <?php
    include('footer.php');
    ?>

    <!-- JS Plugins -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/jquery.nicescroll.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/jquery.countdown.min.js"></script>
    <script src="js/jquery.slicknav.js"></script>
    <script src="js/mixitup.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>