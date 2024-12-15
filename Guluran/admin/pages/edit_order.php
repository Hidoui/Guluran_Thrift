<?php
include "../../config/db.php";

if (isset($_POST['order_id']) && isset($_POST['status'])) {
  $order_id = $_POST['order_id'];
  $status = $_POST['status'];

  $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE order_id = ?");
  $stmt->bind_param("si", $status, $order_id);

  if ($stmt->execute()) {
    echo "<script>
            alert('Status pesanan berhasil diperbarui!');
            window.history.back(); 
          </script>";
  } else {
    echo "<script>
            alert('Pembaruan status gagal!');
            window.history.back();
          </script>";
  }
} else {
  echo "<script>
          alert('Request Invalid!');
          window.history.back();
        </script>";
}
