<?php
include '../../config/db.php'; 

if (isset($_GET['id'])) {
    $userId = intval($_GET['id']);
    $sql = "DELETE FROM users WHERE user_id = $userId";
    
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $conn->error]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'ID tidak ditemukan.']);
}
?>
