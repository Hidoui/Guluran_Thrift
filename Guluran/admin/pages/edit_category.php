<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include '../../config/db.php'; // Koneksi ke database

    $category_id = $_POST['category_id'];
    $category_name = $_POST['category_name'];

    $stmt = $conn->prepare("UPDATE categories SET category_name = ?, updated_at = CURRENT_TIMESTAMP WHERE category_id = ?");
    $stmt->bind_param("si", $category_name, $category_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }

    $stmt->close();
    $conn->close();
}
?>
