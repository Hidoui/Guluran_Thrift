<?php
include "../../config/db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'])) {
  $order_id = $_POST['order_id'];
  try {
    $conn->begin_transaction();
    $stmt = $conn->prepare("DELETE FROM order_items WHERE order_id = ?");
    $stmt->bind_param("i", $order_id);
    if (!$stmt->execute()) {
      throw new Exception("Order Items gagal dihapus!");
    }
    $stmt = $conn->prepare("DELETE FROM orders WHERE order_id = ?");
    $stmt->bind_param("i", $order_id);
    if (!$stmt->execute()) {
      throw new Exception("Hapus data pesanan gagal!");
    }
    $conn->commit();
    echo "<script>
            alert('Pesanan berhasil dihapus.');
            window.history.back();
          </script>";
  } catch (Exception $e) {
    $conn->rollback();
    echo "<script>
            alert('Gagal menghapus pesanan: " . addslashes($e->getMessage()) . "');
            window.history.back();
          </script>";
  }
}
