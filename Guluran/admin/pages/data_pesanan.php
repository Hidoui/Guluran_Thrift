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
  <!-- Fonts and icons -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<?php include 'sidebar.php'; ?>

<body>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-3 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Dashboard</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Data Pesanan</li>
          </ol>
        </nav>
      </div>
    </nav>

    <div class="container-fluid py-2">
      <div class="row">
        <div class="ms-3">
          <h3 class="mb-0 h4 font-weight-bolder">Data Pesanan</h3>
        </div>
      </div>
    </div>

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
                <td>Rp. <?= htmlspecialchars($row['total']); ?></td>
                <td><?= htmlspecialchars($row['payment']); ?></td>
                <td><span class="badge <?= $statusColor ?>"><?= htmlspecialchars($row['status']); ?></span></td>
                <td class="d-flex gap-2">
                  <button class="btn btn-primary btn-sm my-0" data-bs-toggle="modal" data-bs-target="#detailOrdersModal" data-id="<?= $row['order_id'] ?>" onclick="showDetail(this)">
                    <i class="fas fa-eye"></i> Detail
                  </button>
                  <button class="btn btn-warning btn-sm my-0" data-bs-toggle="modal" data-bs-target="#editOrderModal" data-id="<?= $row['order_id'] ?>" onclick="editOrder(this)">
                    <i class="fas fa-edit"></i> Edit
                  </button>
                  <form action="hapus_order.php" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesanan ini?')">
                    <input type="hidden" name="order_id" value="<?= $row['order_id'] ?>">
                    <button type="submit" class="btn btn-danger btn-sm my-0"><i class="fas fa-trash-alt"></i> Hapus</button>
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
      function showDetail(btnData) {
        fetch('get_orders.php?id=' + btnData.getAttribute('data-id'))
          .then(response => response.json())
          .then(data => {
            if (data.order) {
              document.getElementById('orderDate').textContent = data.order.created_at;
              document.getElementById('username').textContent = data.order.username;
              document.getElementById('fullAddress').textContent = data.order.alamat_lengkap;
              document.getElementById('address').textContent = data.order.address;
              document.getElementById('orderNotes').textContent = data.order.note;
              document.getElementById('buyerPhone').textContent = data.order.phone;
              document.getElementById('paymentType').textContent = data.order.payment;
              document.getElementById('orderStatus').textContent = data.order.status;
              document.getElementById('totalPayment').textContent = data.order.total_amount;

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

      function editOrder(btnData) {
        fetch('get_orders.php?id=' + btnData.getAttribute('data-id'))
          .then(response => response.json())
          .then(data => {
            if (data.order) {
              document.getElementById('editOrderId').value = data.order.order_id;
              document.getElementById('editOrderDate').value = data.order.created_at;
              document.getElementById('editUsername').value = data.order.username;
              document.getElementById('editTotalAmount').value = data.order.total_amount;
              document.getElementById('editPayment').value = data.order.payment;
              document.getElementById('editStatus').value = data.order.status;
            } else {
              alert('Pesanan tidak ditemukan');
            }
          })
          .catch(error => console.error('Error fetching order data:', error));
      }
    </script>
  </main>
</body>

</html>