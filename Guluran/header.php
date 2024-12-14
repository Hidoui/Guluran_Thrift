<?php
session_start();
$cartCount = 0;

if (isset($_SESSION['user_id'])) {
    $role = $_SESSION['role'];
    include('config/db.php');

    if ($role === 'user') {
        $user_id = $_SESSION['user_id'];

        $sql = "SELECT COUNT(*) AS cart_item_count
        FROM cart_items ci
        JOIN carts c ON ci.cart_id = c.cart_id
        WHERE c.user_id = ?";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param('i', $user_id);
            $stmt->execute();
            $stmt->bind_result($cartCount);
            $stmt->fetch();
            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Box Icons -->
    <link href="https://unpkg.com/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="path-to-boxicons/css/boxicons.min.css" rel="stylesheet">
</head>

<body>
    <!-- Header Section Begin -->
    <header class="header">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3">
                    <div class="header__logo">
                        <a href="./index.php">
                            <h1 style="font-family: 'Poppins', sans-serif; font-size: 25px; font-weight: 800; color: #000;">Guluran</h1>
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <nav class="header__menu">
                        <ul>
                            <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>"><a href="./index.php">Beranda</a></li>
                            <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'shop.php' ? 'active' : ''; ?>"><a href="./shop.php">Belanja</a></li>
                            <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'contact.php' ? 'active' : ''; ?>"><a href="./contact.php">Kontak</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="col-lg-3 col-md-3">
                    <div class="header__nav__option">
                        <a href="#" class="search-switch">
                            <i class="bx bx-search" style="color:#111111; font-size: 20px"></i>
                        </a>
                        <a href="./shopping-cart.php">
                            <i class="bx bx-shopping-bag" style="color:#111111; font-size: 20px"></i>
                            <?php if ($cartCount > 0): ?>
                                <span class="cart-count"><?php echo $cartCount; ?></span>
                            <?php endif; ?>
                        </a>
                        <nav class="header__top__hover">
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <a href="#">
                                    <i class="bx bx-user" style="color:#111111; font-size: 20px"></i>
                                </a>
                                <ul class="dropdown">
                                    <?php if ($_SESSION['role'] === 'admin'): ?>
                                        <li><a href="./admin/pages/dashboard.php">Admin</a></li>
                                    <?php endif; ?>
                                    <li><a href="./account.php">Account</a></li>
                                    <li><a href="./sign-out.php">Sign Out</a></li>
                                </ul>
                            <?php else: ?>
                                <a href="#">
                                    <i class="bx bx-user" style="color:#111111; font-size: 20px"></i>
                                </a>
                                <ul class="dropdown">
                                    <li><a href="./sign-in.php">Sign In</a></li>
                                    <li><a href="./sign-up.php">Sign Up</a></li>
                                </ul>
                            <?php endif; ?>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <div class="canvas__open"><i class="fa fa-bars"></i></div>
    </header>
    <!-- Header Section End -->

    <!-- Search Begin -->
    <div class="search-model">
        <div class="h-100 d-flex align-items-center justify-content-center">
            <div class="search-close-switch">+</div>
            <form class="search-model-form">
                <input type="text" id="search-input" placeholder="Pencarian...">
            </form>
        </div>
    </div>
    <!-- Search End -->
</body>

</html>