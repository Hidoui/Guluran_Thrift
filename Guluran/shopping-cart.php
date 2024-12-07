<?php
include('config/db.php');
include('header.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: sign-in.php');
    exit;
}

$user_id = $_SESSION['user_id'];

if (isset($_GET['delete'])) {
    $cart_item_id = $_GET['delete'];

    $delete_sql = "DELETE FROM cart_items WHERE cart_item_id = ? AND cart_id IN (SELECT cart_id FROM carts WHERE user_id = ?)";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("ii", $cart_item_id, $user_id);

    if ($stmt->execute()) {
        header('Location: shopping-cart.php');
        exit;
    } else {
        echo "Gagal menghapus produk dari keranjang.";
    }
}

$sql = "SELECT c.cart_id, ci.cart_item_id, p.name, p.price, ci.quantity, p.image, (p.price * ci.quantity) AS total_price 
        FROM carts c
        JOIN cart_items ci ON c.cart_id = ci.cart_id
        JOIN products p ON ci.product_id = p.product_id
        WHERE c.user_id = $user_id";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $items = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $items = [];
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
                    <div class="breadcrumb__text">
                        <h4>Keranjang</h4>
                        <div class="breadcrumb__links">
                            <a href="./index.php">Beranda</a>
                            <a href="./shop.php">Belanja</a>
                            <span>Keranjang</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Shopping Cart Section Begin -->
    <section class="shopping-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="shopping__cart__table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>Jumlah</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $total = 0;
                                foreach ($items as $item) {
                                    $total += $item['total_price'];
                                ?>
                                    <tr>
                                        <td class="product__cart__item">
                                            <div class="product__cart__item__pic">
                                                <a href="./shop-details.php"><img src="img/products/<?php echo $item['image']; ?>" alt=""></a>
                                            </div>
                                            <div class="product__cart__item__text">
                                                <h6><?php echo $item['name']; ?></h6>
                                                <h5>Rp. <?php echo number_format($item['price'], 0, ',', '.'); ?></h5>
                                            </div>
                                        </td>
                                        <td class="quantity__item">
                                            <div class="quantity">
                                                <div class="pro-qty-2">
                                                    <input type="text" value="<?php echo $item['quantity']; ?>">
                                                </div>
                                            </div>
                                        </td>
                                        <td class="cart__price">Rp. <?php echo number_format($item['total_price'], 0, ',', '.'); ?></td>
                                        <td class="cart__close">
                                            <a href="?delete=<?php echo $item['cart_item_id']; ?>" class="bx bx-x" style="color:#111111; font-size: 20px"></a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="continue__btn">
                                <a href="./shop.php">Lanjut Berbelanja</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="checkout__order">
                        <h4 class="order__title">Pesanan Anda</h4>
                        <ul class="checkout__total__all">
                            <li>Subtotal <span>Rp. <?php echo number_format($total, 0, ',', '.'); ?></span></li>
                            <li>Total <span>Rp. <?php echo number_format($total * 1.1, 0, ',', '.'); ?></span></li>
                        </ul>
                        <a href="./checkout.php" class="primary-btn">Lanjut Pembayaran</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shopping Cart Section End -->

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