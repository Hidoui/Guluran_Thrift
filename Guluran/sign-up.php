<?php
include('config/db.php');
include('header.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $agree_terms = isset($_POST['agree_terms']) ? 1 : 0;

    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $error_message = "Silahkan lengkapi data pengguna!";
    } elseif ($password !== $confirm_password) {
        $error_message = "Password dan Konfirmasi Password tidak sesuai!";
    } elseif (!$agree_terms) {
        $error_message = "Anda harus menyetujui syarat dan ketentuan!";
    } else {
        $email = $conn->real_escape_string($email);
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $error_message = "Email sudah terdaftar!";
        } else {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            $username = $conn->real_escape_string($username);
            $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password_hash')";
            if ($conn->query($sql) === TRUE) {
                header("Location: sign-in.php");
                exit();
            } else {
                $error_message = "Error: " . $sql . "<br>" . $conn->error;
            }
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

    <!-- Box Icons -->
    <link href="https://unpkg.com/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="path-to-boxicons/css/boxicons.min.css" rel="stylesheet">

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
                        <h4>Sign Up</h4>
                        <div class="breadcrumb__links">
                            <a href="./index.php">Beranda</a>
                            <a href="./sign-in.php">Sign In</a>
                            <span>Sign Up</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Sign Up Section Begin -->
    <section class="login spad">
        <div class="container">
            <div class="login__form">
                <form method="POST">
                    <div class="row justify-content-center">
                        <div class="col-lg-6">
                            <div class="checkout__input">
                                <p>Username<span>*</span></p>
                                <input type="text" name="username" placeholder="Masukkan Nama" required>
                            </div>
                            <div class="checkout__input">
                                <p>Email<span>*</span></p>
                                <input type="email" name="email" placeholder="Masukkan Email" required>
                            </div>
                            <div class="checkout__input">
                                <p>Password<span>*</span></p>
                                <div class="password-container">
                                    <input type="password" name="password" id="password" placeholder="Masukkan Password" required>
                                    <span class="bx bxs-show" id="togglePassword"></span>
                                </div>
                            </div>
                            <div class="checkout__input">
                                <p>Confirm Password<span>*</span></p>
                                <div class="password-container">
                                    <input type="password" name="confirm_password" id="confirm_password" placeholder="Konfirmasi Password" required>
                                    <span class="bx bxs-show" id="toggleConfirmPassword"></span>
                                </div>
                            </div>
                            <div class="checkout__input__checkbox">
                                <label for="agree-terms">
                                    Saya menyetujui syarat dan ketentuan
                                    <input type="checkbox" id="agree-terms" name="agree_terms" required>
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
        const togglePassword = document.getElementById('togglePassword');
        const passwordField = document.getElementById('password');

        const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
        const confirmPasswordField = document.getElementById('confirm_password');

        const form = document.querySelector('form');
        const submitButton = document.querySelector('button[type="submit"]');
        const errorMessage = "<?php echo isset($error_message) ? $error_message : ''; ?>";

        if (errorMessage) {
            alert(errorMessage);
        }

        togglePassword.addEventListener('click', function() {
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                togglePassword.classList.replace('bxs-show', 'bxs-hide');
            } else {
                passwordField.type = 'password';
                togglePassword.classList.replace('bxs-hide', 'bxs-show');
            }
        });

        toggleConfirmPassword.addEventListener('click', function() {
            if (confirmPasswordField.type === 'password') {
                confirmPasswordField.type = 'text';
                toggleConfirmPassword.classList.replace('bxs-show', 'bxs-hide');
            } else {
                confirmPasswordField.type = 'password';
                toggleConfirmPassword.classList.replace('bxs-hide', 'bxs-show');
            }
        });

        submitButton.addEventListener('click', function(event) {
            var username = document.querySelector('input[name="username"]').value;
            var email = document.querySelector('input[name="email"]').value;
            var password = document.querySelector('input[name="password"]').value;
            var confirmPassword = document.querySelector('input[name="confirm_password"]').value;
            var agreeTerms = document.querySelector('input[name="agree_terms"]').checked;

            if (!username || !email || !password || !confirmPassword) {
                alert("Silahkan lengkapi data pengguna!");
                event.preventDefault();
            } else if (password !== confirmPassword) {
                alert("Password dan Konfirmasi Password tidak sesuai!");
                event.preventDefault();
            } else if (!agreeTerms) {
                alert("Anda harus menyetujui syarat dan ketentuan!");
                event.preventDefault();
            }
        });
    </script>
</body>

</html>