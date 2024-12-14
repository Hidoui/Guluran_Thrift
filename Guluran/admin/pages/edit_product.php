<?php
include '../../config/db.php';
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Menghindari SQL Injection
    $sql = "SELECT * FROM products WHERE product_id = $id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        echo "Produk tidak ditemukan.";
        exit;
    }
} else {
    echo "ID tidak ditemukan.";
    exit;
}
?>
