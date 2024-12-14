<?php

include "../../config/db.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" href="../assets/img/gulur.jpg">
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

<?php include 'sidebar.php'; ?>

<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
  <!-- Navbar -->
  <nav class="navbar navbar-main navbar-expand-lg px-0 mx-3 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
    <div class="container-fluid py-1 px-3">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
          <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Dashboard</a></li>
          <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Data Pesanan</li>
        </ol>
      </nav>
    </div>
    </div>
  </nav>
  <div class="row">
    <div class="ms-3">
      <h3 class="mb-0 h4 font-weight-bolder">Data Pesanan</h3>
    </div>
  </div>
  </div>

  <!-- Button to Add Product
  <div class="btn-add-container" style="text-align: left; margin-bottom: 20px; margin-left: 23px;">
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addProductModal">
      <i class="fas fa-plus"></i> Tambah Data Produk
    </button>
  </div> -->

  <!-- Table displaying products -->
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pesanan</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
      .table-wrapper {
        margin: 20px auto;
        max-width: 90%;
      }

      .action-btns .btn {
        margin-right: 5px;
      }

      img.rounded-circle {
        width: 50px;
        height: 50px;
      }
    </style>
  </head>

  <body>
  <div class="table-wrapper">
    <table class="table align-items-center mb-0">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama Pembeli</th>
          <th>Kategori</th>
          <th>Jumlah</th>
          <th>Total Harga</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($orders)) : ?>
          <?php foreach ($orders as $row) : ?>
            <tr>
              <td class="text-muted"><?= htmlspecialchars($row['order_id']); ?></td>
              <td class="text-muted"><?= htmlspecialchars($row['customer_name']); ?></td>
              <td class="text-muted"><?= htmlspecialchars($row['product_name']); ?></td>
              <td class="text-muted"><?= htmlspecialchars($row['category']); ?></td>
              <td class="text-muted"><?= htmlspecialchars($row['quantity']); ?></td>
              <td class="text-muted"><?= "Rp " . number_format($row['total_price'], 0, ',', '.'); ?></td>
              <td>
                <span class="badge bg-success"><?= htmlspecialchars($row['status']); ?></span>
              </td>
              <td>
                <button data-bs-toggle="modal" data-bs-target="#editOrderModal" class="btn btn-warning btn-sm" data-id="<?= $row['order_id']; ?>" data-customer="<?= $row['customer_name'] ?>" data-product="<?= $row['product_name'] ?>" data-status="<?= $row['status'] ?>" onclick="setEditOrder(this)">Ubah</button>
                <button class="btn btn-danger btn-sm" data-id="<?= $row['order_id']; ?>" onclick="deleteOrder(<?= $row['order_id']; ?>)">Hapus</button>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else : ?>
          <tr>
            <td colspan="8" class="text-center text-muted">Tidak ada data pesanan.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
</div>

<!-- Modal Edit Order -->
<div class="modal fade" id="editOrderModal" tabindex="-1" aria-labelledby="editOrderModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editOrderModalLabel">Edit Pesanan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="editOrderForm">
          <div class="mb-3">
            <label for="editCustomerName" class="form-label">Nama Pembeli</label>
            <input type="text" class="form-control" id="editCustomerName" required>
          </div>
          <div class="mb-3">
            <label for="editProductName" class="form-label">Nama Produk</label>
            <input type="text" class="form-control" id="editProductName" required>
          </div>
          <div class="mb-3">
            <label for="editStatus" class="form-label">Status</label>
            <select class="form-select" id="editStatus" required>
              <option value="Lunas">Lunas</option>
              <option value="Pending">Pending</option>
              <option value="Batal">Batal</option>
            </select>
          </div>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
      </div>
    </div>
  </div>
</div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
  </body>

  </html>

</main>
<!--   Core JS Files   -->
<script src="../assets/js/core/popper.min.js"></script>
<script src="../assets/js/core/bootstrap.min.js"></script>
<script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
<script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
<script src="../assets/js/plugins/chartjs.min.js"></script>

<script>
  var win = navigator.platform.indexOf('Win') > -1;
  if (win && document.querySelector('#sidenav-scrollbar')) {
    var options = {
      damping: '0.5'
    }
    Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
  }
</script>
<!-- Github buttons -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
<!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
<script src="../assets/js/material-dashboard.min.js?v=3.2.0"></script>
</body>

</html>