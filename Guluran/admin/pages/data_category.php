<?php
  session_start();

  include "../../config/db.php";
  error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon"  href="../assets/img/gulur.jpg">
  <link rel="icon" type="image/png" sizes="100x100" href="../assets/img/gulur.jpg">
  <title>
    Guluran
  </title>
  <!--     Fonts and icons     -->
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
</head>
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

    .table th, .table td {
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
    border-radius: 10px; /* Rounded corners */
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1); /* Soft shadow */
    transition: all 0.3s ease; /* Smooth transition for focus */
  }

  .custom-input:focus {
    border-color: #0056b3; /* Change border color when focused */
    box-shadow: 0 0 5px rgba(0, 86, 179, 0.5); /* Highlight input with blue shadow */
    outline: none; /* Remove the default focus outline */
  }

  .form-label {
    font-weight: 600; /* Make labels bold */
    color: #333; /* Dark color for the label text */
  }

  .form-text.text-muted {
    font-size: 0.875rem; /* Slightly smaller text */
  }
  .custom-label {
    margin-left: 10px; /* Move the label slightly to the left */
    font-weight: 600; /* Bold label */
    color: #333; /* Dark color for label text */
  }

  .custom-input {
    border-radius: 2px; /* Rounded corners */
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1); /* Soft shadow */
    padding-left: 20px; /* Add space to the left of placeholder text */
    transition: all 0.3s ease; /* Smooth transition for focus */
  }

  .custom-input::placeholder {
    color: #999; /* Placeholder text color */
    font-size: 0.9rem; /* Slightly smaller font size */
  }

  .custom-input:focus {
    border-color: #0056b3; /* Border color on focus */
    box-shadow: 0 0 5px rgba(0, 86, 179, 0.5); /* Blue shadow on focus */
    outline: none; /* Remove default outline */
  }

  .form-text.text-muted {
    font-size: 0.875rem; /* Slightly smaller text */
  }

  </style>

<body class="g-sidenav-show  bg-gray-100">
<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2  bg-white my-2" id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand px-4 py-3 m-0" href=" https://demos.creative-tim.com/material-dashboard/pages/dashboard " target="_blank">
        <img src="../assets/img/gulur.jpg" class="navbar-brand-img" width="35%" height="50" alt="main_logo">
        <span class="ms-1 text-sm text-dark">GULURAN</span>
      </a>
    </div>
    <hr class="horizontal dark mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link text-dark" href="../pages/dashboard.php">
            <i class="material-symbols-rounded opacity-5">dashboard</i>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="../pages/data_product.php">
            <i class="material-symbols-rounded opacity-5">Box</i>
            <span class="nav-link-text ms-1">Data Product</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark " href="../pages/data_pesanan.php">
            <i class="material-symbols-rounded opacity-5">receipt_long</i>
            <span class="nav-link-text ms-1">Data Pesanan</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="../pages/laporan_penjualan.php">
            <i class="material-symbols-rounded opacity-5">view_in_ar</i>
            <span class="nav-link-text ms-1">Laporan Penjualan</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="../pages/data_pengguna.php">
            <i class="material-symbols-rounded opacity-5">person</i>
            <span class="nav-link-text ms-1">Data Pengguna</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link active bg-gradient-dark text-white" href="../pages/data_category.php">
            <i class="material-symbols-rounded opacity-5">view_in_ar</i>
            <span class="nav-link-text ms-1">Data Category</span>
          </a>
        </li>
        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Account pages</h6>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="../pages/profile.html">
            <i class="material-symbols-rounded opacity-5">person</i>
            <span class="nav-link-text ms-1">Profile</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="../pages/sign-Out.html">
            <i class="material-symbols-rounded opacity-5">login</i>
            <span class="nav-link-text ms-1">Sign Out</span>
          </a>
        </li>
       </ul>
    </div>
  </aside>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-3 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Data Category</li>
          </ol>
        </nav>
        </div>
      </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid py-2">
      <div class="row">
        <div class="ms-3">
          <h3 class="mb-0 h4 font-weight-bolder">Data Category</h3>
        </div>
        </div>
      </div>
  <!-- Button to Add Product -->
  <div class="btn-add-container" style="text-align: left; margin-bottom: 20px; margin-left: 23px;">
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addProductModal">
      <i class="fas fa-plus"></i> Tambah Data Category 
    </button>
  </div>

  <!-- Table displaying products -->
  <div class="table-wrapper">
    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>No.</th>
          <th>Nama Category Celana</th>
          <th>Kategori</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $sql = "SELECT * FROM products pr INNER JOIN categories cr ON pr.category_id = cr.category_id;";
          $hasil = $conn->query($sql);
          if($hasil->num_rows > 0) {
            $i = 1;
            while($row = $hasil->fetch_assoc()) {
        ?>
        <tr>
          <td><?= $i?></td>
          <td><img src="uploads/<?= $row['image'] ?>" width="150" alt="" class=""></td>
          <td><?= $row['name']?></td>
          <td><?= $row['category_name']?></td>
          <td><?= $row['size']?></td>  
          <td><?= $row['price']?></td>
          <td><?= $row['stock']?></td>
          <td class="action-btns">
            <button class="btn btn-edit"><i class="fas fa-edit"></i> Ubah</button>
            <button class="btn btn-delete"><i class="fas fa-trash-alt"></i> Hapus</button>
          </td>
        </tr>
        <?php 
            $i++;
            }
          }
        ?>
        <!-- Add more rows as needed -->
      </tbody>
    </table>
  </div>

  <!-- Modal to Add Product -->
  <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-success text-black">
        <h5 class="modal-title" id="addProductModalLabel">Tambah Data Category</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
  <form>
    <div class="mb-3">
      <label for="productName" class="form-label custom-label">Nama Produk</label>
      <input type="text" class="form-control custom-input" id="productName" placeholder="Masukkan Nama Produk" required>
    </div>
    <div class="mb-3">
      <label for="productCategory" class="form-label custom-label">Kategori</label>
      <input type="text" class="form-control custom-input" id="productCategory" placeholder="Masukkan Kategori Produk" required>
    </div>
    <div class="mb-3">
      <label for="productPrice" class="form-label custom-label">Harga</label>
      <input type="text" class="form-control custom-input" id="productPrice" placeholder="Masukkan Harga Produk" required>
    </div>
    <div class="mb-3">
      <label for="productStock" class="form-label custom-label">Stok</label>
      <input type="number" class="form-control custom-input" id="productStock" placeholder="Masukkan Stok Produk" required>
    </div>
    <div class="mb-3">
      <label for="productStock" class="form-label custom-label">Size</label>
      <input type="number" class="form-control custom-input" id="size" placeholder="Masukkan Size" required>
    </div>
    <div class="mb-3">
      <label for="productImage" class="form-label custom-label">Foto Produk</label>
      <input type="file" class="form-control custom-input" id="productImage" accept="image/*">
      <small class="form-text text-muted">Pilih gambar produk (JPG, PNG, JPEG)</small>
    </div>
  </form>
</div>

<!-- Add custom styles -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        <button type="button" class="btn btn-success" id="saveProductBtn">Simpan</button>
      </div>
    </div>
  </div>
</div>
    </div>
  </main>
  

  <!--   Core JS Files   -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/chartjs.min.js"></script>
 
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/material-dashboard.min.js?v=3.2.0"></script>
</body>
<script>
  document.getElementById('saveProductBtn').addEventListener('click', function () {
    // Ambil data dari form
    const productData = {
      name: document.getElementById('productName').value,
      category: document.getElementById('productCategory').value,
      price: document.getElementById('productPrice').value,
      stock: document.getElementById('productStock').value,
      size: document.getElementById('size').value,
      image: document.getElementById('productImage').files[0]
    };

    // Buat form data untuk mengirim file gambar
    const formData = new FormData();
    formData.append('name', productData.name);
    formData.append('category', productData.category);
    formData.append('price', productData.price);
    formData.append('stock', productData.stock);
    formData.append('size', productData.size);
    if (productData.image) {
      formData.append('image', productData.image);
    }

    // Kirim data ke server
    fetch('save_product.php', {
  method: 'POST',
  body: formData
})
  .then(response => {
    if (!response.ok) {
      throw new Error(`HTTP error! Status: ${response.status}`);
    }
    return response.text(); // Gunakan text() untuk debug
  })
  .then(text => {
    try {
      const data = JSON.parse(text); // Parse JSON
      if (data.success) {
        alert('Produk berhasil disimpan!');
      } else {
        alert('Gagal menyimpan produk: ' + data.message);
      }
    } catch (error) {
      console.error('Invalid JSON:', text);
      alert('Terjadi kesalahan: Respons server tidak valid.');
    }
  })
  .catch(error => console.error('Error:', error));

  });
</script>
</html>