<?php
include('config/db.php');
include('header.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: sign-in.php');
    exit;
}

$user_id = $_SESSION['user_id'];

$user_sql = "SELECT username FROM users WHERE user_id = ?";
$stmt = $conn->prepare($user_sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user_result = $stmt->get_result();
$user_fullname = '';

if ($user_row = $user_result->fetch_assoc()) {
    $user_fullname = $user_row['username'];
}

$sql = "SELECT address, province, city, district, postal_code, phone 
        FROM orders 
        WHERE user_id = ? 
        ORDER BY created_at DESC 
        LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$shipping_data = [
    'address' => '',
    'province' => '',
    'city' => '',
    'district' => '',
    'postal_code' => '',
    'phone' => ''
];

if ($row = $result->fetch_assoc()) {
    $shipping_data = $row;
}

$sql = "SELECT ci.cart_item_id, p.name, ci.quantity, p.price, (p.price * ci.quantity) AS total_price, p.product_id 
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
    if (!isset($row['product_id']) || $row['product_id'] == null) {
        echo "Error: ID Produk tidak ditemukan!";
    } else {
        $items[] = $row;
        $total += $row['total_price'];
    }
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
            $product_id = $item['product_id'];
            $quantity = $item['quantity'];

            $stock_sql = "SELECT stock FROM products WHERE product_id = ?";
            $stmt = $conn->prepare($stock_sql);
            $stmt->bind_param("i", $product_id);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($stock);
            $stmt->fetch();
            $stmt->free_result();

            if ($stock >= $quantity) {
                $new_stock = $stock - $quantity;

                if ($new_stock == 0) {
                    $update_stock_sql = "UPDATE products SET stock = 0 WHERE product_id = ?";
                    $stmt = $conn->prepare($update_stock_sql);
                    $stmt->bind_param("i", $product_id);
                    $stmt->execute();
                    $stmt->free_result();
                } else {
                    $update_stock_sql = "UPDATE products SET stock = ? WHERE product_id = ?";
                    $stmt = $conn->prepare($update_stock_sql);
                    $stmt->bind_param("ii", $new_stock, $product_id);
                    $stmt->execute();
                    $stmt->free_result();
                }
            } else {
                echo "Stok produk tidak mencukupi" . $item['name'];
                exit;
            }

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

        $delete_cart_sql = "DELETE FROM carts WHERE user_id = ?";
        $stmt = $conn->prepare($delete_cart_sql);
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
                            <h6 class="checkout__title">Data Pengiriman</h6>
                            <div class="checkout__input">
                                <p>Nama Lengkap<span>*</span></p>
                                <input type="text" name="fullname" value="<?php echo $user_fullname; ?>" required>
                            </div>
                            <div class="checkout__input">
                                <p>Provinsi<span>*</span></p>
                                <input type="text" name="province" value="<?php echo $shipping_data['province']; ?>" required>
                            </div>
                            <div class="checkout__input">
                                <p>Kota<span>*</span></p>
                                <input type="text" name="city" value="<?php echo $shipping_data['city']; ?>" required>
                            </div>
                            <div class="checkout__input">
                                <p>Kecamatan<span>*</span></p>
                                <input type="text" name="district" value="<?php echo $shipping_data['district']; ?>" required>
                            </div>
                            <div class="checkout__input">
                                <p>Kode Pos<span>*</span></p>
                                <input type="text" name="postal_code" value="<?php echo $shipping_data['postal_code']; ?>" required>
                            </div>
                            <div class="checkout__input">
                                <p>Alamat<span>*</span></p>
                                <input type="text" name="address" value="<?php echo $shipping_data['address']; ?>" required class="checkout__input__add">
                            </div>
                            <div class="checkout__input">
                                <p>No. Telepon<span>*</span></p>
                                <input type="text" name="phone" value="<?php echo $shipping_data['phone']; ?>" required>
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
                                        <li><?php echo $item['name']; ?> <span>Rp<?php echo number_format($item['total_price'], 0, ',', '.'); ?></span></li>
                                    <?php } ?>
                                </ul>
                                <ul class="checkout__total__all">
                                    <li>Total <span>Rp<?php echo number_format($total, 0, ',', '.'); ?></span></li>
                                </ul>
                                <div class="checkout__input__checkbox">
                                    <label for="payment">
                                        Bank Transfer
                                        <input type="radio" name="payment" id="payment" value="Bank Transfer" required>
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
            var fullname = document.querySelector('input[name="fullname"]').value;
            var province = document.querySelector('input[name="province"]').value;
            var city = document.querySelector('input[name="city"]').value;
            var district = document.querySelector('input[name="district"]').value;
            var postal_code = document.querySelector('input[name="postal_code"]').value;
            var address = document.querySelector('input[name="address"]').value;
            var phone = document.querySelector('input[name="phone"]').value;
            var paymentChecked = document.querySelector('input[name="payment"]:checked');

            if (!fullname || !province || !city || !district || !postal_code || !address || !phone) {
                alert("Silahkan lengkapi data pengiriman!");
                event.preventDefault();
                return false;
            }

            if (!paymentChecked) {
                alert("Silahkan pilih metode pembayaran!");
                event.preventDefault();
                return false;
            }

            var userConfirmation = confirm("Apakah anda yakin ingin melanjutkan pesanan?");
            if (!userConfirmation) {
                event.preventDefault();
            }
        }

        document.querySelector('.site-btn').addEventListener('click', confirmOrder);
    </script>
</body>

</html>