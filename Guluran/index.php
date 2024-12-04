<?php
include('db.php');
include('header.php');

$sql = "SELECT * FROM products";
$result = $conn->query($sql);
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
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $product_id = $row['product_id'];
                        $product_name = $row['name'];
                        $product_description = $row['description'];
                        $product_price = $row['price'];
                        $product_image = $row['image'];
                        $created_at = $row['created_at'];

                        $time_diff = strtotime('now') - strtotime($created_at);
                        $is_new = ($time_diff <= 3600);

                        $is_sale = ($product_price > 100000);

                        $new_class = $is_new ? 'new-arrivals' : '';
                        $sale_class = $is_sale ? 'best-sellers' : '';

                        echo '<div class="col-lg-3 col-md-6 col-sm-6 mix ' . $new_class . ' ' . $sale_class . '">';
                        echo '<div class="product__item ' . ($is_sale ? 'sale' : '') . '">';
                        echo '<div class="product__item__pic set-bg" data-setbg="img/product/' . $product_image . '">';

                        if ($is_new) {
                            echo '<span class="label">New</span>';
                        }

                        if ($is_sale) {
                            echo '<span class="label">Best</span>';
                        }

                        echo '<ul class="product__hover">';
                        echo '<li><a href="./shop-details.php?id=' . $product_id . '"><img src="img/icon/search.png" alt=""> <span>Details</span></a></li>';
                        echo '<li><a href="#"><img src="img/icon/cart.png" alt=""> <span>Cart</span></a></li>';
                        echo '</ul>';
                        echo '</div>';
                        echo '<div class="product__item__text">';
                        echo '<h5>' . $product_name . '</h5>';
                        echo '<h6>Rp.' . number_format($product_price, 0, ',', '.') . '</h6>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo "No products found";
                }
                ?>
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