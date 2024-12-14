<?php
include '../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['product_id']);
    $name = $conn->real_escape_string($_POST['name']);
    $description = $conn->real_escape_string($_POST['description']);
    $category = intval($_POST['category']);
    $size = $conn->real_escape_string($_POST['size']);
    $price = floatval($_POST['price']);
    $stock = intval($_POST['stock']);

    $sql = "UPDATE products 
            SET name = '$name', 
                description = '$description', 
                category_id = $category, 
                size = '$size', 
                price = $price, 
                stock = $stock, 
                updated_at = NOW() 
            WHERE product_id = $id";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $conn->error]);
    }
}
?>
