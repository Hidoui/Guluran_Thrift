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

<?php include 'sidebar.php'; ?>

<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-3 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Data Product</li>
          </ol>
        </nav>
        </div>
      </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid py-2">
      <div class="row">
        <div class="ms-3">
          <h3 class="mb-0 h4 font-weight-bolder">Data Product</h3>
        </div>
        </div>
      </div>
  <!-- Button to Add Product -->
  <div class="btn-add-container" style="text-align: left; margin-bottom: 20px; margin-left: 23px;">
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addProductModal">
      <i class="fas fa-plus"></i> Tambah Data Produk
    </button>
  </div>

  <!-- Table displaying products -->
  <div class="table-wrapper">
    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>No.</th>
          <th>Foto 1</th>
          <th>Foto 2</th>
          <th>Nama Produk</th>
          <th>description</th>
          <th>Kategori</th>
          <th>Size</th>
          <th>Harga</th>
          <th>Stok</th>
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
          <td><img src="uploads/<?= $row['images'] ?>" width="150" alt="" class=""></td>
          <td><?= $row['name']?></td>
          <td><?= $row['description']?></td>
          <td><?= $row['category_name']?></td>
          <td><?= $row['size']?></td>  
          <td><?= $row['price']?></td>
          <td><?= $row['stock']?></td>
          <td class="action-btns">
          <button 
            class="btn btn-edit btn-primary" 
            data-bs-toggle="modal" 
            data-bs-target="#editProductModal" 
            data-id="<?= $row['product_id'] ?>" 
            data-name="<?= htmlspecialchars($row['name']) ?>" 
            data-description="<?= htmlspecialchars($row['description']) ?>" 
            data-category="<?= $row['category_id'] ?>" 
            data-size="<?= htmlspecialchars($row['size']) ?>" 
            data-stock="<?= $row['stock'] ?>" 
            data-price="<?= $row['price'] ?>" 
            data-image="<?= htmlspecialchars($row['image']) ?>">
            Ubah
          </button>
    <button class="btn btn-delete" data-id="<?= $row['product_id'] ?>"><i class="fas fa-trash-alt"></i> Hapus</button>
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
        <h5 class="modal-title" id="addProductModalLabel">Tambah Data Produk</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
  <form>
    <div class="mb-3">
      <label for="productName" class="form-label custom-label">Nama Produk</label>
      <input type="text" class="form-control custom-input" id="productName" placeholder="Masukkan Nama Produk" required>
    </div>
    <div class="mb-3">
      <label for="productdescription" class="form-label custom-label">description</label>
      <textarea class="form-control custom-input" id="productdescription" placeholder="Masukkan description"></textarea>
    </div>
    <div class="mb-3">
      <label for="productCategory" class="form-label custom-label">Kategori</label>
      <input type="text" class="form-control custom-input" id="productCategory" placeholder="Masukkan Kategori Produk"required>
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
      <input type="text" class="form-control custom-input" id="size" placeholder="Masukkan Size" required>
    </div>
    <div class="mb-3">
      <label for="productImage" class="form-label custom-label">Foto Produk 1</label>
      <input type="file" class="form-control custom-input" id="productImage" accept="image/*">
      <small class="form-text text-muted">Pilih gambar produk (JPG, PNG, JPEG)</small>
    </div>
    <div class="mb-3">
      <label for="productImages" class="form-label custom-label">Foto Produk 2</label>
      <input type="file" class="form-control custom-input" id="productImages" accept="image/*">
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

  <!-- Modal to Edit Product -->
<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="editProductModalLabel">Edit Data Produk</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="editProductForm">
          <input type="hidden" id="editProductId">
          <div class="mb-3">
            <label for="editProductName" class="form-label">Nama Produk</label>
            <input type="text" class="form-control" id="editProductName" required>
          </div>
          <div class="mb-3">
            <label for="editProductDescription" class="form-label">Deskripsi</label>
            <textarea class="form-control" id="editProductDescription" required></textarea>
          </div>
          <div class="mb-3">
            <label for="editProductCategory" class="form-label">Kategori</label>
            <input type="text" class="form-control" id="editProductCategory" required>
          </div>
          <div class="mb-3">
            <label for="editProductPrice" class="form-label">Harga</label>
            <input type="text" class="form-control" id="editProductPrice" required>
          </div>
          <div class="mb-3">
            <label for="editProductStock" class="form-label">Stok</label>
            <input type="number" class="form-control" id="editProductStock" required>
          </div>
          <div class="mb-3">
            <label for="editProductSize" class="form-label">Ukuran</label>
            <input type="text" class="form-control" id="editProductSize" required>
          </div>
          <div class="mb-3">
            <label for="editProductImage" class="form-label">Foto Produk 1</label>
            <input type="file" class="form-control" id="editProductImage" accept="image/*">
          </div>
          <div class="mb-3">
            <label for="editProductImages" class="form-label">Foto Produk 2</label>
            <input type="file" class="form-control" id="editProductImages" accept="image/*">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        <button type="button" class="btn btn-primary" id="updateProductBtn">Simpan Perubahan</button>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const editButtons = document.querySelectorAll('.btn-edit');
    editButtons.forEach(button => {
      button.addEventListener('click', function () {
        // Ambil data dari atribut tombol
        const productId = this.getAttribute('data-id');
        const productName = this.getAttribute('data-name');
        const productDescription = this.getAttribute('data-description');
        const productCategory = this.getAttribute('data-category');
        const productPrice = this.getAttribute('data-price');
        const productStock = this.getAttribute('data-stock');
        const productSize = this.getAttribute('data-size');

        // Isi data ke dalam form modal
        document.getElementById('editProductId').value = productId;
        document.getElementById('editProductName').value = productName;
        document.getElementById('editProductDescription').value = productDescription;
        document.getElementById('editProductCategory').value = productCategory;
        document.getElementById('editProductPrice').value = productPrice;
        document.getElementById('editProductStock').value = productStock;
        document.getElementById('editProductSize').value = productSize;
      });
    });

    // Event untuk menyimpan perubahan
    document.getElementById('updateProductBtn').addEventListener('click', function () {
      const formData = new FormData();
      formData.append('id', document.getElementById('editProductId').value);
      formData.append('name', document.getElementById('editProductName').value);
      formData.append('description', document.getElementById('editProductDescription').value);
      formData.append('category', document.getElementById('editProductCategory').value);
      formData.append('price', document.getElementById('editProductPrice').value);
      formData.append('stock', document.getElementById('editProductStock').value);
      formData.append('size', document.getElementById('editProductSize').value);

      const image = document.getElementById('editProductImage').files[0];
      const images = document.getElementById('editProductImages').files[0];
      if (image) formData.append('image', image);
      if (images) formData.append('images', images);

      fetch('edit_product.php', {
        method: 'POST',
        body: formData
      })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            alert('Produk berhasil diperbarui!');
            location.reload();
          } else {
            alert('Gagal memperbarui produk: ' + data.message);
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('Terjadi kesalahan saat memperbarui produk.');
        });
    });
  });
</script>
  
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
      description: document.getElementById('productdescription').value,
      category: document.getElementById('productCategory').value,
      price: document.getElementById('productPrice').value,
      stock: document.getElementById('productStock').value,
      size: document.getElementById('size').value,
      image: document.getElementById('productImage').files[0],
      images: document.getElementById('productImages').files[0]
    };
    console.log(productData);

    // Buat form data untuk mengirim file gambar
    const formData = new FormData();
    formData.append('name', productData.name);
    formData.append('description', productData.description);
    formData.append('category', productData.category);
    formData.append('price', productData.price);
    formData.append('stock', productData.stock);
    formData.append('size', productData.size);
    if (productData.image) {
      formData.append('image', productData.image);
    }
    if (productData.images) {
      formData.append('images', productData.images);
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

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const deleteButtons = document.querySelectorAll('.btn-delete');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function () {
            const productId = this.getAttribute('data-id');
            const confirmDelete = confirm('Apakah Anda yakin ingin menghapus produk ini?');

            if (confirmDelete) {
                // Kirim permintaan ke server untuk menghapus produk
                fetch(`hapus_product.php?id=${productId}`, {
                  method: 'GET',
                })

                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Produk berhasil dihapus!');
                        location.reload(); // Refresh halaman setelah penghapusan
                    } else {
                        alert('Gagal menghapus produk: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menghapus produk.');
                });
            }
        });
    });
});
</script>
</html>