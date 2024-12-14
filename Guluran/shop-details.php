<?php
include('config/db.php');
include('header.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: sign-in.php');
    exit;
}

$user_id = $_SESSION['user_id'];

if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    $check_cart_sql = "SELECT cart_id FROM carts WHERE user_id = ?";
    $stmt = $conn->prepare($check_cart_sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $cart = $result->fetch_assoc();
        $cart_id = $cart['cart_id'];

        $check_item_sql = "SELECT cart_item_id FROM cart_items WHERE cart_id = ? AND product_id = ?";
        $stmt = $conn->prepare($check_item_sql);
        $stmt->bind_param("ii", $cart_id, $product_id);
        $stmt->execute();
        $item_result = $stmt->get_result();

        if ($item_result->num_rows > 0) {
            $product_exists = true;
        } else {
            $insert_sql = "INSERT INTO cart_items (cart_id, product_id, quantity) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($insert_sql);
            $stmt->bind_param("iii", $cart_id, $product_id, $quantity);
            $stmt->execute();
        }
    } else {
        $create_cart_sql = "INSERT INTO carts (user_id) VALUES (?)";
        $stmt = $conn->prepare($create_cart_sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $cart_id = $stmt->insert_id;

        $insert_sql = "INSERT INTO cart_items (cart_id, product_id, quantity) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insert_sql);
        $stmt->bind_param("iii", $cart_id, $product_id, $quantity);
        $stmt->execute();
    }

    if (isset($product_exists) && $product_exists) {
        header('Location: shop-details.php?id=' . $product_id . '&exists=true');
        exit;
    }

    header('Location: shopping-cart.php');
    exit;
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $product_id = $_GET['id'];

    $sql = "SELECT p.*, c.category_name FROM products p 
            LEFT JOIN categories c ON p.category_id = c.category_id 
            WHERE p.product_id = $product_id";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        echo "Produk tidak ditemukan!";
        exit;
    }
} else {
    echo "ID produk tidak valid!";
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
                            <a href="./shop.php">Belanja</a>
                            <span>Detail Produk</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Shop Details Section Begin -->
    <section class="shop-details">
        <div class="product__details__pic">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-3">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab">
                                    <div class="product__thumb__pic set-bg"
                                        data-setbg="img/product/<?php echo $product['image']; ?>">
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-6 col-md-9">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tabs-1" role="tabpanel">
                                <div class="product__details__pic__item">
                                    <img src="img/product/<?php echo $product['image']; ?>" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="product__details__content">
            <div class="container">
                <div class="row d-flex justify-content-center">
                    <div class="col-lg-8">
                        <div class="product__details__text">
                            <h3><?php echo $product['name']; ?></h3>
                            <h4>Rp.<?php echo number_format($product['price'], 2, ',', '.'); ?></h4>
                            <div class="product__details__option">
                                <div class="product__details__option__size">
                                    <span>Size:</span>
                                    <?php if ($product['size'] == 'S') { ?>
                                        <label for="sm">S
                                            <input type="radio" id="sm" checked disabled>
                                        </label>
                                    <?php } ?>
                                    <?php if ($product['size'] == 'M') { ?>
                                        <label for="md">M
                                            <input type="radio" id="md" checked disabled>
                                        </label>
                                    <?php } ?>
                                    <?php if ($product['size'] == 'L') { ?>
                                        <label for="lg">L
                                            <input type="radio" id="lg" checked disabled>
                                        </label>
                                    <?php } ?>
                                    <?php if ($product['size'] == 'XL') { ?>
                                        <label for="xl">XL
                                            <input type="radio" id="xl" checked disabled>
                                        </label>
                                    <?php } ?>
                                    <span>Stok:</span>
                                    <?php
                                    $stock = $product['stock'];
                                    for ($i = 1; $i <= $stock; $i++) {
                                        echo '<label for="qty' . $i . '">' . $i . '<input type="radio" id="qty' . $i . '" name="quantity" value="' . $i . '" disabled></label>';
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="product__details__cart__option">
                                <form method="POST" action="">
                                    <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" name="add_to_cart" class="primary-btn">Masukkan Keranjang</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="product__details__tab">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#tabs-5"
                                        role="tab">Deskripsi</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tabs-5" role="tabpanel">
                                    <div class="product__details__tab__content">
                                        <div class="product__details__tab__content__item">
                                            <h5>Informasi Produk</h5>
                                            <p><?php echo $product['description']; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shop Details Section End -->

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