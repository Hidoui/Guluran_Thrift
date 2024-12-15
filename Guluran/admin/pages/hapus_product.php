<?php
include "../../config/db.php"; // Sesuaikan dengan jalur file koneksi Anda

header('Content-Type: application/json');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Validasi ID untuk keamanan
    
    $sql = "DELETE FROM products WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Produk berhasil dihapus.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal menghapus produk.']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'ID produk tidak ditemukan.']);
}

$conn->close();
?>
