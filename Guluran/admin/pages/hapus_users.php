<?php
include "../../config/db.php";
header('Content-Type: application/json');

// Cek apakah parameter 'id' ada
if (isset($_GET['id'])) {
    $user_id = (int) $_GET['id']; // Mendapatkan ID pengguna

    // Query untuk menghapus pengguna berdasarkan ID
    $query = "DELETE FROM users WHERE user_id = ?";

    if ($stmt = mysqli_prepare($conn, $query)) {
        // Bind parameter dan eksekusi query
        mysqli_stmt_bind_param($stmt, "i", $user_id);

        if (mysqli_stmt_execute($stmt)) {
            // Jika penghapusan berhasil
            echo json_encode(['success' => true, 'message' => 'Pengguna berhasil dihapus.']);
        } else {
            // Jika terjadi kesalahan saat penghapusan
            echo json_encode(['success' => false, 'message' => 'Terjadi kesalahan saat menghapus pengguna.']);
        }

        // Tutup statement
        mysqli_stmt_close($stmt);
    } else {
        // Jika query tidak dapat dipersiapkan
        echo json_encode(['success' => false, 'message' => 'Terjadi kesalahan saat mempersiapkan query.']);
    }
} else {
    // Jika ID tidak ada
    echo json_encode(['success' => false, 'message' => 'ID pengguna tidak ditemukan.']);
}

// Tutup koneksi database
mysqli_close($conn);
