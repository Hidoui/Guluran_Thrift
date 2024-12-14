<?php
include '../../config/db.php'; // Pastikan file koneksi sudah ada

if (isset($_GET['id'])) {
    $productId = intval($_GET['id']);
    $sql = "DELETE FROM products WHERE product_id = $productId";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $conn->error]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'ID tidak ditemukan.']);
}
?>
