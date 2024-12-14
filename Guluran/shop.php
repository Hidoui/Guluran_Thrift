<?php
include('config/db.php');
include('header.php');

if (!isset($_SESSION['user_id'])) {
    $user_id = null;
} else {
    $user_id = $_SESSION['user_id'];
}

$category_filter = '';
$price_filter = '';
$size_filter = '';

if (isset($_GET['category_id']) && is_numeric($_GET['category_id'])) {
    $category_filter = " WHERE category_id = " . $_GET['category_id'];
}

if (isset($_GET['price']) && preg_match('/^(\d+)-(\d+)$/', $_GET['price'], $matches)) {
    $min_price = $matches[1];
    $max_price = $matches[2];
    if ($category_filter === '') {
        $price_filter = " WHERE price BETWEEN $min_price AND $max_price";
    } else {
        $price_filter = " AND price BETWEEN $min_price AND $max_price";
    }
}

if (isset($_GET['size']) && in_array($_GET['size'], ['S', 'M', 'L', 'XL'])) {
    $size_filter = " AND size = '" . $_GET['size'] . "'";
}

$sql = "SELECT * FROM products" . $category_filter . $price_filter . $size_filter;
$result = $conn->query($sql);

$sql_categories = "SELECT * FROM categories";
$result_categories = $conn->query($sql_categories);

if (isset($_GET['add_to_cart']) && is_numeric($_GET['add_to_cart'])) {
    if (!$user_id) {
        header('Location: sign-in.php');
        exit;
    }

    $product_id = $_GET['add_to_cart'];

    $check_cart_sql = "SELECT cart_id FROM carts WHERE user_id = ?";
    $check_cart_stmt = $conn->prepare($check_cart_sql);
    $check_cart_stmt->bind_param("i", $user_id);
    $check_cart_stmt->execute();
    $cart_result = $check_cart_stmt->get_result();

    if ($cart_result->num_rows === 0) {
        $insert_cart_sql = "INSERT INTO carts (user_id) VALUES (?)";
        $insert_cart_stmt = $conn->prepare($insert_cart_sql);
        $insert_cart_stmt->bind_param("i", $user_id);
        $insert_cart_stmt->execute();

        $cart_id = $conn->insert_id;
    } else {
        $cart_row = $cart_result->fetch_assoc();
        $cart_id = $cart_row['cart_id'];
    }

    $check_sql = "SELECT ci.cart_item_id FROM cart_items ci
                  WHERE ci.cart_id = ? AND ci.product_id = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("ii", $cart_id, $product_id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows > 0) {
        header('Location: shop.php?exists=true');
        exit;
    } else {
        $insert_sql = "INSERT INTO cart_items (cart_id, product_id, quantity) 
                       VALUES (?, ?, 1)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("ii", $cart_id, $product_id);
        $insert_stmt->execute();
    }

    header('Location: shopping-cart.php');
    exit;
}
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

    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__text" style="font-family: 'Poppins', sans-serif;">
                        <h4>Belanja</h4>
                        <div class="breadcrumb__links">
                            <a href="./index.php">Beranda</a>
                            <span>Belanja</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Shop Section Begin -->
    <section class="shop spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="shop__sidebar">
                        <div class="shop__sidebar__accordion">
                            <div class="accordion" id="accordionExample">
                                <div class="card">
                                    <div class="card-heading">
                                        <a data-toggle="collapse" data-target="#collapseOne">Kategori</a>
                                    </div>
                                    <div id="collapseOne" class="collapse show" data-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="shop__sidebar__categories">
                                                <ul class="nice-scroll">
                                                    <?php
                                                    if ($result_categories->num_rows > 0) {
                                                        while ($category = $result_categories->fetch_assoc()) {
                                                            $category_name = $category['category_name'];
                                                            $category_id = $category['category_id'];
                                                            echo '<li><a href="?category_id=' . $category_id . '">' . $category_name . '</a></li>';
                                                        }
                                                    } else {
                                                        echo "No categories found";
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-heading">
                                        <a data-toggle="collapse" data-target="#collapseTwo">Harga</a>
                                    </div>
                                    <div id="collapseTwo" class="collapse show" data-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="shop__sidebar__price">
                                                <ul>
                                                    <li><a href="?category_id=<?php echo $_GET['category_id'] ?? ''; ?>&price=0-50000">Rp.0 - Rp.50.000</a></li>
                                                    <li><a href="?category_id=<?php echo $_GET['category_id'] ?? ''; ?>&price=50000-100000">Rp.50.000 - Rp.100.000</a></li>
                                                    <li><a href="?category_id=<?php echo $_GET['category_id'] ?? ''; ?>&price=100000-200000">Rp.100.000 - Rp.200.000</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-heading">
                                        <a data-toggle="collapse" data-target="#collapseThree">Ukuran</a>
                                    </div>
                                    <div id="collapseThree" class="collapse show" data-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="shop__sidebar__size">
                                                <label for="sm">S
                                                    <input type="radio" id="sm" name="size" value="S" <?php echo isset($_GET['size']) && $_GET['size'] == 'S' ? 'checked' : ''; ?>>
                                                </label>
                                                <label for="md">M
                                                    <input type="radio" id="md" name="size" value="M" <?php echo isset($_GET['size']) && $_GET['size'] == 'M' ? 'checked' : ''; ?>>
                                                </label>
                                                <label for="lg">L
                                                    <input type="radio" id="lg" name="size" value="L" <?php echo isset($_GET['size']) && $_GET['size'] == 'L' ? 'checked' : ''; ?>>
                                                </label>
                                                <label for="xl">XL
                                                    <input type="radio" id="xl" name="size" value="XL" <?php echo isset($_GET['size']) && $_GET['size'] == 'XL' ? 'checked' : ''; ?>>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="row">
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

                                echo '<div class="col-lg-4 col-md-6 col-sm-6 mix ' . $new_class . ' ' . $sale_class . '">';
                                echo '<div class="product__item ' . ($is_sale ? 'sale' : '') . '">';
                                echo '<div class="product__item__pic set-bg" data-setbg="admin/pages/uploads/' . $product_image . '">' .
                                    ($is_new ? '<span class="label">New</span>' : '') .
                                    ($is_sale ? '<span class="label">Best</span>' : '') .
                                    '<ul class="product__hover">' .
                                    '<li><a href="./shop-details.php?id=' . $product_id . '"><img src="img/icon/search.png" alt=""> <span>Details</span></a></li>' .
                                    '<li><a href="?add_to_cart=' . $product_id . '"><img src="img/icon/cart.png" alt=""> <span>Cart</span></a></li>' .
                                    '</ul>' .
                                    '</div>';
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
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="product__pagination">
                                <a class="active" href="#">1</a>
                                <a href="#">2</a>
                                <a href="#">3</a>
                                <span>...</span>
                                <a href="#">10</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shop Section End -->

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

    <script>
        const urlParams = new URLSearchParams(window.location.search);
        const productExists = urlParams.get('exists');

        if (productExists) {
            alert('Produk sudah ada di keranjang!');
            urlParams.delete('exists');
            window.history.replaceState({}, '', '?' + urlParams.toString());
        }
    </script>
</body>

</html>