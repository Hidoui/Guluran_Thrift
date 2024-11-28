<?php
include('db.php');
include('header.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['user_name'] = $row['full_name'];
            $_SESSION['user_email'] = $row['email'];

            $domain = substr(strrchr($email, "@"), 1);
            if ($domain == "admin.com") {
                header("Location: dashboard.php");
            } elseif ($domain == "gmail.com") {
                header("Location: index.php");
            } else {
                header("Location: index.php");
            }
            exit();
        } else {
            echo "Password salah!";
        }
    } else {
        echo "Email tidak ditemukan!";
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

    <body>
        <!-- Sign In Section Begin -->
        <section class="login spad">
            <div class="container">
                <div class="login__form">
                    <form method="POST">
                        <div class="row justify-content-center">
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Email<span>*</span></p>
                                    <input type="email" name="email" placeholder="Your email" required>
                                </div>
                                <div class="checkout__input">
                                    <p>Password<span>*</span></p>
                                    <input type="password" name="password" placeholder="Your password" required>
                                </div>
                                <div class="checkout__input__checkbox">
                                    <label for="remember-me">
                                        Remember Me
                                        <input type="checkbox" id="remember-me">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <div class="continue__btn update__btn">
                                            <button type="submit">Confirm</button>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <div class="continue__btn">
                                            <a href="./sign-up.php">Sign Up</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        <!-- Sign In Section End -->

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