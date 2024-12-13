<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengambil data dari form
    $category_name = $_POST['category_name'];

    // Periksa apakah kategori tidak kosong
    if (empty($category_name)) {
        echo json_encode(['success' => false, 'message' => 'Nama category tidak boleh kosong']);
        exit;
    }

    // Masukkan kategori ke database (Pastikan untuk sanitasi input terlebih dahulu)
    include "../../config/db.php";
    $sql = "INSERT INTO categories (category_name) VALUES ('$category_name')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Terjadi kesalahan saat menyimpan kategori']);
    }
}
?>
