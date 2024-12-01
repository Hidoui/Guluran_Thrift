<?php
include('db.php');
include('header.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    if ($password !== $confirm_password) {
        echo "Password tidak cocok!";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (full_name, email, password) VALUES ('$full_name', '$email', '$hashed_password')";
        if (mysqli_query($conn, $sql)) {
            echo "Registrasi berhasil!";
            header("Location: sign-in.php");
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
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
        <!-- Sign Up Section Begin -->
        <section class="login spad">
            <div class="container">
                <div class="login__form">
                    <form method="POST">
                        <div class="row justify-content-center">
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Full Name<span>*</span></p>
                                    <input type="text" name="full_name" placeholder="Masukkan Nama Lengkap" required>
                                </div>
                                <div class="checkout__input">
                                    <p>Email<span>*</span></p>
                                    <input type="email" name="email" placeholder="Masukkan Email" required>
                                </div>
                                <div class="checkout__input">
                                    <p>Password<span>*</span></p>
                                    <input type="password" name="password" placeholder="Masukkan Password" required>
                                </div>
                                <div class="checkout__input">
                                    <p>Confirm Password<span>*</span></p>
                                    <input type="password" name="confirm_password" placeholder="Konfirmasi Password" required>
                                </div>
                                <div class="checkout__input__checkbox">
                                    <label for="remember-me">
                                        I agree to the terms and conditions
                                        <input type="checkbox" id="remember-me" required>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <div class="continue__btn update__btn">
                                            <button type="submit">Konfirmasi</button>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <div class="continue__btn">
                                            <a href="./sign-in.php">Sign In</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        <!-- Sign Up Section End -->

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