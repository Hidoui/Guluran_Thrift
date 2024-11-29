<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                            <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>"><a href="./index.php">Halaman</a></li>
                            <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'shop.php' ? 'active' : ''; ?>"><a href="./shop.php">Belanja</a></li>
                            <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'contact.php' ? 'active' : ''; ?>"><a href="./contact.php">Kontak</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="col-lg-3 col-md-3">
                    <div class="header__nav__option">
                        <a href="#" class="search-switch">
                            <img src="img/icon/search.png" alt="">
                        </a>
                        <a href="./shopping-cart.php">
                            <img src="img/icon/cart.png" alt="">
                        </a>
                        <nav class="header__top__hover">
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <a href="#">
                                    <img src="img/icon/heart.png" alt="">
                                </a>
                                <ul class="dropdown">
                                    <li><a href="./account.php">Account</a></li>
                                    <li><a href="./log-out.php">Sign Out</a></li>
                                </ul>
                            <?php else: ?>
                                <a href="#">
                                    <img src="img/icon/heart.png" alt="">
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
                <input type="text" id="search-input" placeholder="Search...">
            </form>
        </div>
    </div>
    <!-- Search End -->
</body>

</html>