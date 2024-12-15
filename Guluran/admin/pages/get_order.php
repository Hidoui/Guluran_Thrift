<?php
include "../../config/db.php";

// Cek apakah parameter 'id' ada dalam URL
if (isset($_GET['id'])) {
  $order_id = $_GET['id'];

  // Query untuk mengambil data berdasarkan ID
  $query = "SELECT 
        orders.order_id, orders.created_at, orders.note, 
        orders.address, orders.phone, orders.payment, orders.status, orders.total_amount, 
        users.username, 
        CONCAT(orders.province, ', ', orders.city, ', ', orders.district, ', Kode Pos : ', orders.postal_code) AS alamat_lengkap,
        products.name AS product_name,
        products.price, 
        order_items.quantity, 
        (products.price * order_items.quantity) AS subtotal
      FROM orders
      LEFT JOIN order_items ON order_items.order_id = orders.order_id
      LEFT JOIN products ON order_items.product_id = products.product_id
      LEFT JOIN users ON orders.user_id = users.user_id
      WHERE orders.order_id = ?";

  $stmt = $conn->prepare($query);
  $stmt->bind_param('i', $order_id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $orderData = [
        'order_id' => $row['order_id'],
        'created_at' => $row['created_at'],
        'username' => $row['username'],
        'alamat_lengkap' => $row['alamat_lengkap'],
        'address' => $row['address'],
        'note' => $row['note'],
        'phone' => $row['phone'],
        'payment' => $row['payment'],
        'status' => $row['status'],
        'total_amount' => $row['total_amount']
      ];
      $orderItems[] = [
        'product_name' => $row['product_name'],
        'price' => $row['price'],
        'quantity' => $row['quantity'],
        'subtotal' => $row['subtotal']
      ];
    }
    $response = [
      'order' => $orderData,
      'items' => $orderItems
    ];
    echo json_encode($response);
  } else {
    echo json_encode(['error' => 'Order not found']);
  }
} else {
  echo json_encode(['error' => 'ID parameter is missing']);
}
