<?php
include '../../config/db.php'; // Pastikan file koneksi sudah ada

// Memeriksa apakah data POST sudah diterima dengan lengkap
if (isset($_POST['user_id'], $_POST['username'], $_POST['email'])) {
    $userId = intval($_POST['user_id']);
    $username = $_POST['username'];
    $email = $_POST['email'];

    // Memeriksa apakah koneksi ke database berhasil
    if ($conn) {
        // Query untuk memperbarui data pengguna
        $sql = "UPDATE users SET username = ?, email = ? WHERE user_id = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            // Mengikat parameter dan mengeksekusi query
            $stmt->bind_param("ssi", $username, $email, $userId);
            
            // Mengeksekusi query dan memeriksa hasilnya
            if ($stmt->execute()) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'error' => $stmt->error]);
            }

            // Menutup statement
            $stmt->close();
        } else {
            echo json_encode(['success' => false, 'error' => 'Gagal mempersiapkan query']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Koneksi database gagal']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Data tidak lengkap']);
}
?>
