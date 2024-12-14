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
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $sql = "SELECT * FROM categories";
        $hasil = $conn->query($sql);
        if ($hasil->num_rows > 0) {
          $i = 1;
          while ($row = $hasil->fetch_assoc()) {
        ?>
            <tr>
              <td><?= $i ?></td>
              <td><?= $row['category_name'] ?></td>
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
              <label for="CategoryName" class="form-label custom-label">Nama Category Celana</label>
              <input type="text" class="form-control custom-input" id="CategoryName" placeholder="Masukkan Nama Category" required>
            </div>
          </form>
        </div>

        <!-- Add custom styles -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
          <button type="button" class="btn btn-success" id="saveCategoryBtn">Simpan</button>
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
<script src="../assets/js/core/popper.min.js"></script>
<script src="../assets/js/core/bootstrap.min.js"></script>
<script>
  document.getElementById('saveCategoryBtn').addEventListener('click', function() {
    const categoryName = document.getElementById('CategoryName').value;
    const formData = new FormData();
    formData.append('category_name', categoryName);

    fetch('save_category.php', {
        method: 'POST',
        body: formData
      })
      .then(response => {
        if (!response.ok) {
          throw new Error(`HTTP error! Status: ${response.status}`);
        }
        return response.json();
      })
      .then(data => {
        if (data.success) {
          alert('Kategori berhasil ditambahkan!');
          location.reload();
        } else {
          alert('Gagal menambahkan kategori: ' + data.message);
        }
      })
      .catch(error => console.error('Error:', error));
  });
</script>
</body>

</html>