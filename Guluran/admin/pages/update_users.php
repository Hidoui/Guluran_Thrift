<?php
include '../../config/db.php'; // Pastikan file koneksi sudah ada

// Memeriksa apakah data POST sudah diterima dengan lengkap
if (isset($_POST['user_id'], $_POST['username'], $_POST['email'])) {
    $userId = intval($_POST['user_id']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);

    // Validasi data
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'error' => 'Format email tidak valid']);
        exit;
    }

    if (empty($username)) {
        echo json_encode(['success' => false, 'error' => 'Username tidak boleh kosong']);
        exit;
    }

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
                error_log("Error updating user: " . $stmt->error); // Log error di server
                echo json_encode(['success' => false, 'error' => 'Gagal memperbarui data']);
            }

            // Menutup statement
            $stmt->close();
        } else {
            error_log("Prepare failed: " . $conn->error); // Log error di server
            echo json_encode(['success' => false, 'error' => 'Gagal mempersiapkan query']);
        }
    } else {
        error_log("Database connection failed"); // Log error di server
        echo json_encode(['success' => false, 'error' => 'Koneksi database gagal']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Data tidak lengkap']);
}
