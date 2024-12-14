<?php
session_start();

include "../../config/db.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guluran Thrift</title>

    <!-- Fonts and icons -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
    <!-- Nucleo Icons -->
    <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Material Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
    <!-- CSS Files -->
    <link id="pagestyle" href="../assets/css/material-dashboard.css?v=3.2.0" rel="stylesheet" />

    <style>
        /* body {
            font-family: 'Roboto', sans-serif;
            background-color: #f9f9f9;
        } */

        .container {
            max-width: 1200px;
            margin: 30px auto;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 2.5em;
            color: #333;
        }

        .table th,
        .table td {
            vertical-align: middle;
        }

        .action-btns button {
            margin-left: 5px;
        }

        .btn-detail {
            background-color: #4CAF50;
            color: white;
        }

        .btn-edit {
            background-color: #ffa500;
            color: white;
        }

        .btn-delete {
            background-color: #f44336;
            color: white;
        }

        .btn-add {
            background-color: #007bff;
            color: white;
        }

        .btn-detail:hover {
            background-color: #45a049;
        }

        .btn-edit:hover {
            background-color: #e68900;
        }

        .btn-delete:hover {
            background-color: #d32f2f;
        }

        .btn-add:hover {
            background-color: #0069d9;
        }

        .pagination .page-item .page-link {
            color: #333;
        }

        .pagination .page-item.active .page-link {
            background-color: #4CAF50;
            border-color: #4CAF50;
            color: white;
        }

        .pagination .page-item:hover .page-link {
            background-color: #45a049;
            border-color: #45a049;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        .btn-add-container {
            text-align: right;
            margin-bottom: 20px;
        }

        .custom-input {
            border-radius: 10px;
            /* Rounded corners */
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            /* Soft shadow */
            transition: all 0.3s ease;
            /* Smooth transition for focus */
        }

        .custom-input:focus {
            border-color: #0056b3;
            /* Change border color when focused */
            box-shadow: 0 0 5px rgba(0, 86, 179, 0.5);
            /* Highlight input with blue shadow */
            outline: none;
            /* Remove the default focus outline */
        }

        .form-label {
            font-weight: 600;
            /* Make labels bold */
            color: #333;
            /* Dark color for the label text */
        }

        .form-text.text-muted {
            font-size: 0.875rem;
            /* Slightly smaller text */
        }

        .custom-label {
            margin-left: 10px;
            /* Move the label slightly to the left */
            font-weight: 600;
            /* Bold label */
            color: #333;
            /* Dark color for label text */
        }

        .custom-input {
            border-radius: 2px;
            /* Rounded corners */
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            /* Soft shadow */
            padding-left: 20px;
            /* Add space to the left of placeholder text */
            transition: all 0.3s ease;
            /* Smooth transition for focus */
        }

        .custom-input::placeholder {
            color: #999;
            /* Placeholder text color */
            font-size: 0.9rem;
            /* Slightly smaller font size */
        }

        .custom-input:focus {
            border-color: #0056b3;
            /* Border color on focus */
            box-shadow: 0 0 5px rgba(0, 86, 179, 0.5);
            /* Blue shadow on focus */
            outline: none;
            /* Remove default outline */
        }

        .form-text.text-muted {
            font-size: 0.875rem;
            /* Slightly smaller text */
        }
    </style>
</head>

<body class="g-sidenav-show  bg-gray-100">
    <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2  bg-white my-2" id="sidenav-main">
        <div class="sidenav-header">
            <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
            <a class="navbar-brand px-4 py-3 m-0" href="https://demos.creative-tim.com/material-dashboard/pages/dashboard" target="_blank">
                <img src="../assets/img/gulur.jpg" class="navbar-brand-img" width="35%" height="50" alt="main_logo">
                <span class="ms-1 text-sm text-dark">GULURAN</span>
            </a>
        </div>
        <hr class="horizontal dark mt-0 mb-2">
        <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
            <ul class="navbar-nav">
                <?php
                $current_page = basename($_SERVER['PHP_SELF']);
                ?>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == 'dashboard.php') ? 'active bg-gradient-dark text-white' : 'text-dark'; ?>" href="../pages/dashboard.php">
                        <i class="material-symbols-rounded opacity-5">dashboard</i>
                        <span class="nav-link-text ms-1">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == 'data_pengguna.php') ? 'active bg-gradient-dark text-white' : 'text-dark'; ?>" href="../pages/data_pengguna.php">
                        <i class="material-symbols-rounded opacity-5">group</i>
                        <span class="nav-link-text ms-1">Data Pengguna</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == 'data_product.php') ? 'active bg-gradient-dark text-white' : 'text-dark'; ?>" href="../pages/data_product.php">
                        <i class="material-symbols-rounded opacity-5">Box</i>
                        <span class="nav-link-text ms-1">Data Product</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == 'data_category.php') ? 'active bg-gradient-dark text-white' : 'text-dark'; ?>" href="../pages/data_category.php">
                        <i class="material-symbols-rounded opacity-5">Category</i>
                        <span class="nav-link-text ms-1">Data Category</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == 'data_pesanan.php') ? 'active bg-gradient-dark text-white' : 'text-dark'; ?>" href="../pages/data_pesanan.php">
                        <i class="material-symbols-rounded opacity-5">receipt_long</i>
                        <span class="nav-link-text ms-1">Data Pesanan</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == 'laporan_penjualan.php') ? 'active bg-gradient-dark text-white' : 'text-dark'; ?>" href="../pages/laporan_penjualan.php">
                        <i class="material-symbols-rounded opacity-5">view_in_ar</i>
                        <span class="nav-link-text ms-1">Laporan Penjualan</span>
                    </a>
                </li>
                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Account pages</h6>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == 'sign-Out.html') ? 'active bg-gradient-dark text-white' : 'text-dark'; ?>" href="../pages/sign-Out.html">
                        <i class="material-symbols-rounded opacity-5">login</i>
                        <span class="nav-link-text ms-1">Sign Out</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>
</body>

</html>