<?php
include "config/db.php";

// Cek apakah parameter 'id' ada dalam URL
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Query untuk mengambil data berdasarkan ID
    $query = "SELECT * FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Jika data ditemukan
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode([
            'id' => $row['user_id'],
            'username' => $row['username'],
            'email' => $row['email']
        ]);
    } else {
        echo json_encode(['error' => 'User not found']);
    }
} else {
    echo json_encode(['error' => 'ID parameter is missing']);
}
