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
        $check_cart_sql = "SELECT COUNT(*) FROM cart_items WHERE cart_id IN (SELECT cart_id FROM carts WHERE user_id = ?)";
        $check_stmt = $conn->prepare($check_cart_sql);
        $check_stmt->bind_param("i", $user_id);

        if ($stmt->execute()) {
            $check_cart_sql = "SELECT COUNT(*) FROM cart_items WHERE cart_id IN (SELECT cart_id FROM carts WHERE user_id = ?)";
            $check_stmt = $conn->prepare($check_cart_sql);
            $check_stmt->bind_param("i", $user_id);

            if ($check_stmt->execute()) {
                $check_stmt->bind_result($cart_count);
                $check_stmt->fetch();

                $check_stmt->close();

                if ($cart_count == 0) {
                    $delete_cart_sql = "DELETE FROM carts WHERE user_id = ?";
                    $delete_cart_stmt = $conn->prepare($delete_cart_sql);
                    $delete_cart_stmt->bind_param("i", $user_id);
                    $delete_cart_stmt->execute();
                    $delete_cart_stmt->close();
                }
            }
        }
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

$cart_empty = count($items) == 0;
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
                                    <th>Harga</th>
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
                                                <h5><?php echo $item['name']; ?></h5>
                                                <h6>Rp.<?php echo number_format($item['price'], 0, ',', '.'); ?></h6>
                                            </div>
                                        </td>
                                        <td class="cart__price">
                                            <span><?php echo $item['quantity']; ?></span>
                                        </td>
                                        <td class="cart__price">Rp.<?php echo number_format($item['total_price'], 0, ',', '.'); ?></td>
                                        <td class="cart__close">
                                            <a href="?delete=<?php echo $item['cart_item_id']; ?>" class="bx bx-x" style="color:#111111; font-size: 20px; padding-top: 4px"></a>
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
                    <div class="cart__summary">
                        <h4 class="summary__title">Keranjang Anda</h4>
                        <ul class="cart__total__all">
                            <li>Total <span>Rp.<?php echo number_format($total, 0, ',', '.'); ?></span></li>
                        </ul>
                        <a href="<?php echo $cart_empty ? '#' : './checkout.php'; ?>"
                            class="site-btn" id="checkout-button"
                            <?php echo $cart_empty ? 'onclick="showPopup()"' : ''; ?>>Lanjut Pembayaran</a>
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

    <script type="text/javascript">
        function showPopup() {
            alert('Keranjang kosong. Silakan tambah produk terlebih dahulu.');
            window.location.href = 'shopping-cart.php';
        }
    </script>
</body>

</html>