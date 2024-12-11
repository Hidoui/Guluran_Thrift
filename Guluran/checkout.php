<?php
include('config/db.php');
include('header.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: sign-in.php');
    exit;
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT ci.cart_item_id, p.name, ci.quantity, p.price, (p.price * ci.quantity) AS total_price 
        FROM cart_items ci
        JOIN products p ON ci.product_id = p.product_id
        JOIN carts c ON ci.cart_id = c.cart_id
        WHERE c.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$items = [];
$total = 0;
while ($row = $result->fetch_assoc()) {
    $items[] = $row;
    $total += $row['total_price'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = $_POST['fullname'];
    $province = $_POST['province'];
    $city = $_POST['city'];
    $district = $_POST['district'];
    $postal_code = $_POST['postal_code'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $note = $_POST['note'];
    $payment = $_POST['payment'];

    $order_sql = "INSERT INTO orders (user_id, total_amount, address, province, city, district, postal_code, phone, note, payment) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($order_sql);
    $stmt->bind_param("idssssssss", $user_id, $total, $address, $province, $city, $district, $postal_code, $phone, $note, $payment);
    if ($stmt->execute()) {
        $order_id = $stmt->insert_id;

        foreach ($items as $item) {
            $order_item_sql = "INSERT INTO order_items (order_id, product_id, quantity, total_price) 
                               VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($order_item_sql);
            $stmt->bind_param("iiii", $order_id, $item['product_id'], $item['quantity'], $item['total_price']);
            $stmt->execute();
        }

        $delete_sql = "DELETE FROM cart_items WHERE cart_id IN (SELECT cart_id FROM carts WHERE user_id = ?)";
        $stmt = $conn->prepare($delete_sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();

        header('Location: index.php');
        exit;
    } else {
        echo "Gagal memproses pesanan.";
    }
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
                        <h4>Check Out</h4>
                        <div class="breadcrumb__links">
                            <a href="./index.php">Beranda</a>
                            <a href="./shop.php">Belanja</a>
                            <a href="./shopping-cart.php">Keranjang</a>
                            <span>Check Out</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Checkout Section Begin -->
    <section class="checkout spad">
        <div class="container">
            <div class="checkout__form">
                <form method="POST">
                    <div class="row">
                        <div class="col-lg-8 col-md-6">
                            <h6 class="checkout__title">Detail</h6>
                            <div class="checkout__input">
                                <p>Nama Lengkap<span>*</span></p>
                                <input type="text" name="fullname" required>
                            </div>
                            <div class="checkout__input">
                                <p>Provinsi<span>*</span></p>
                                <input type="text" name="province" required>
                            </div>
                            <div class="checkout__input">
                                <p>Kota<span>*</span></p>
                                <input type="text" name="city" required>
                            </div>
                            <div class="checkout__input">
                                <p>Kecamatan<span>*</span></p>
                                <input type="text" name="district" required>
                            </div>
                            <div class="checkout__input">
                                <p>Kode Pos<span>*</span></p>
                                <input type="text" name="postal_code" required>
                            </div>
                            <div class="checkout__input">
                                <p>Alamat<span>*</span></p>
                                <input type="text" name="address" required class="checkout__input__add">
                            </div>
                            <div class="checkout__input">
                                <p>No. Telepon<span>*</span></p>
                                <input type="text" name="phone" required>
                            </div>
                            <div class="checkout__input">
                                <p>Pesan</p>
                                <input type="text" name="note" placeholder="Catatan pesanan (opsional)">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="checkout__order">
                                <h4 class="order__title">Pesanan Anda</h4>
                                <div class="checkout__order__products">Produk <span>Harga</span></div>
                                <ul class="checkout__total__products">
                                    <?php foreach ($items as $item) { ?>
                                        <li><?php echo $item['name']; ?> <span>Rp. <?php echo number_format($item['total_price'], 0, ',', '.'); ?></span></li>
                                    <?php } ?>
                                </ul>
                                <ul class="checkout__total__all">
                                    <li>Total <span>Rp. <?php echo number_format($total, 0, ',', '.'); ?></span></li>
                                </ul>
                                <div class="checkout__input__checkbox">
                                    <label for="payment">
                                        Bank Transfer
                                        <input type="radio" name="payment" id="payment" value="Bank" required>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="checkout__input__checkbox">
                                    <label for="paypal">
                                        Cash On Delivery
                                        <input type="radio" name="payment" id="paypal" value="COD" required>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <button type="submit" class="site-btn">Order</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- Checkout Section End -->

    <?php include('footer.php'); ?>

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
        function confirmOrder(event) {
            var userConfirmation = confirm("Apakah Anda yakin ingin melanjutkan pesanan?");
            if (!userConfirmation) {
                event.preventDefault();
            }
        }

        document.querySelector('form').addEventListener('submit', confirmOrder);
    </script>
</body>

</html>