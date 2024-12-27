<?php

include "../../config/db.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);

$query = "SELECT orders.*, users.username FROM orders INNER JOIN users ON orders.user_id=users.user_id";
$result = mysqli_query($conn, $query);
$orders = mysqli_fetch_all($result, MYSQLI_ASSOC);
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

  <style>
  .search-container {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
    align-items: center;
  }

  .search-container input {
    flex: 1;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
  }

  .search-container button {
    padding: 8px 16px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }

  .search-container button:hover {
    background-color: #0056b3;
  }
</style>
</head>

<?php include 'sidebar.php'; ?>

<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
  <!-- Navbar -->
  <nav class="navbar navbar-main navbar-expand-lg px-0 mx-3 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
    <div class="container-fluid py-1 px-3">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
          <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="dashboard.php">Dashboard</a></li>
          <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Laporan Penjualan</li>
        </ol>
      </nav>
    </div>
    </div>
  </nav>
  <!-- End Navbar -->
  <div class="container-fluid py-2">
    <div class="row">
      <div class="ms-3">
        <h3 class="mb-0 h4 font-weight-bolder">Laporan Penjualan</h3>
      </div>
    </div>
  </div>

  <!-- Button to Add Product -->
  <div class="search-container mx-3">
  <input type="text" id="searchInput" placeholder="Cari...">
  <button id="searchButton">Cari</button>
</div>

<script>
  document.getElementById('searchButton').addEventListener('click', function() {
    const searchValue = document.getElementById('searchInput').value.toLowerCase();
    const tableRows = document.querySelectorAll('.table tbody tr');

    tableRows.forEach(row => {
      const rowText = row.textContent.toLowerCase();
      if (rowText.includes(searchValue)) {
        row.style.display = '';
      } else {
        row.style.display = 'none';
      }
    });
  });

  // Optional: Trigger search on pressing "Enter"
  document.getElementById('searchInput').addEventListener('keypress', function(event) {
    if (event.key === 'Enter') {
      document.getElementById('searchButton').click();
    }
  });
</script>

<div class="mx-4 pb-3">
      <table class="table mb-0">
        <thead>
          <tr class="text-start px-0">
            <th class="px-2">No.</th>
            <th class="px-2">ID Pesanan</th>
            <th class="px-2">Waktu Pesanan</th>
            <th class="px-2">Nama Pembeli</th>
            <th class="px-2">Total Harga</th>
            <th class="px-2">Jenis Payment</th>
            <th class="px-2">Status</th>
            <th class="px-2">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php $no = 0;
          if (!empty($orders)) : ?>
            <?php foreach ($orders as $row) : ?>
              <?php
              if ($row['status'] == "Pending") {
                $statusColor = "bg-warning";
              } else if ($row['status'] == "Completed") {
                $statusColor = "bg-success";
              } else {
                $statusColor = "bg-secondary";
              }
              ?>
              <tr>
                <td><?= ++$no ?></td>
                <td><?= htmlspecialchars($row['order_id']); ?></td>
                <td><?= htmlspecialchars($row['created_at']); ?></td>
                <td><?= htmlspecialchars($row['username']); ?></td>
                <td>Rp. <?= htmlspecialchars($row['total_amount']); ?></td>
                <td><?= htmlspecialchars($row['payment']); ?></td>
                <td><span class="badge <?= $statusColor ?>"><?= htmlspecialchars($row['status']); ?></span></td>
                <td class="d-flex gap-2">
                  <button class="btn btn-primary btn-sm my-0" data-bs-toggle="modal" data-bs-target="#detailOrdersModal" data-id="<?= $row['order_id'] ?>" onclick="showDetail(this)">
                    <i class="fas fa-eye"></i> Detail
                  </button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else : ?>
            <tr>
              <td colspan="8" class="text-center">Tidak ada data pesanan.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <div id="detailOrdersModal" class="modal fade" tabindex="-1" aria-labelledby="detailOrdersModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">Detail Pesanan</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="list-group">
              <div class="list-group-item">
                <strong>Waktu Pemesanan : </strong>
                <span id="created_at"></span>
              </div>
              <div class="list-group-item">
                <strong>Nama Pembeli : </strong>
                <span id="username"></span>
              </div>
              <div class="list-group-item">
                <strong>Alamat : </strong>
                <span id="address"></span> <span id="fullAddress"></span>
              </div>
              <div class="list-group-item">
                <strong>Catatan : </strong>
                <span id="note"></span>
              </div>
              <div class="list-group-item">
                <strong>No. HP : </strong>
                <span id="phone"></span>
              </div>
              <div class="list-group-item">
                <strong>Jenis Pembayaran : </strong>
                <span id="payment"></span>
              </div>
              <div class="list-group-item">
                <strong>Status Pesanan : </strong>
                <span id="status"></span>
              </div>
              <div class="list-group-item">
                <strong>Total Pembayaran : </strong>
                <span id="total_amount"></span>
              </div>
            </div>
            <div class="mt-2 fs-5">Daftar Barang</div>
            <table id="orderItemsTable" class="table table-striped">
              <thead>
                <tr>
                  <th class="px-2">No</th>
                  <th class="px-2">Nama Barang</th>
                  <th class="px-2">Harga</th>
                  <th class="px-2">Jumlah</th>
                  <th class="px-2">Subtotal</th>
                </tr>
              </thead>
              <tbody id="orderItemsBody">
              </tbody>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <!-- <div id="editOrderModal" class="modal fade" tabindex="-1" aria-labelledby="editOrderModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Status Pesanan</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form id="editOrderForm" action="edit_order.php" method="POST">
            <div class="modal-body">
              <input type="hidden" name="order_id" id="editOrderId">
              <div class="list-group">
                <div class="list-group-item">
                  <strong>Waktu Pemesanan : </strong>
                  <input type="text" class="form-control" id="editOrderDate" readonly>
                </div>
                <div class="list-group-item">
                  <strong>Nama Pembeli : </strong>
                  <input type="text" class="form-control" id="editUsername" readonly>
                </div>
                <div class="list-group-item">
                  <strong>Total Pembayaran : </strong>
                  <input type="number" class="form-control" id="editTotalAmount" readonly>
                </div>
                <div class="list-group-item">
                  <strong>Jenis Pembayaran : </strong>
                  <input type="text" class="form-control" id="editPayment" readonly>
                </div>
                <div class="list-group-item">
                  <strong>Status : </strong>
                  <select class="form-select px-3 border" name="status" id="editStatus">
                    <option value="Pending">Proses</option>
                    <option value="Completed">Selesai</option>
                    <option value="Canceled">Batal</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
              <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
          </form>
        </div>
      </div>
    </div> -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
      function showDetail(btnData) {
        fetch('get_laporan.php?id=' + btnData.getAttribute('data-id'))
          .then(response => response.json())
          .then(data => {
            if (data.order) {
              document.getElementById('created_at').textContent = data.order.created_at;
              document.getElementById('username').textContent = data.order.username;
              document.getElementById('address').textContent = data.order.address;
              document.getElementById('note').textContent = data.order.note;
              document.getElementById('phone').textContent = data.order.phone;
              document.getElementById('payment').textContent = data.order.payment;
              document.getElementById('status').textContent = data.order.status;
              document.getElementById('total_amount').textContent = data.order.total_amount;

              const orderItemsBody = document.getElementById('orderItemsBody');
              orderItemsBody.innerHTML = '';
              no = 0;
              data.items.forEach(item => {
                const row = document.createElement('tr');
                row.innerHTML = `
                  <td>${++no}</td>
                  <td>${item.product_name}</td>
                  <td>Rp. ${item.price}</td>
                  <td>${item.quantity}</td>
                  <td>${item.subtotal}</td>
                `;
                orderItemsBody.appendChild(row);
              });
            } else {              
              alert('Pesanan tidak ditemukan');
            }
          })
          .catch(error => console.error('Error fetching order data:', error));
      };

      // function editOrder(btnData) {
      //   fetch('get_laporan.php?id=' + btnData.getAttribute('data-id'))
      //     .then(response => response.json())
      //     .then(data => {
      //       if (data.order) {
      //         document.getElementById('editOrderId').value = data.order.order_id;
      //         document.getElementById('editOrderDate').value = data.order.created_at;
      //         document.getElementById('editUsername').value = data.order.username;
      //         document.getElementById('editTotalAmount').value = data.order.total_amount;
      //         document.getElementById('editPayment').value = data.order.payment;
      //         document.getElementById('editStatus').value = data.order.status;
      //       } else {
      //         alert('Pesanan tidak ditemukan');
      //       }
      //     })
      //     .catch(error => console.error('Error fetching order data:', error));
      // }
    </script>
  </main>
</body>

</html>