<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include '../../config/db.php'; // Koneksi ke database

    // Ambil data dari POST
    $product_id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $category_id = $_POST['category'];
    $size = $_POST['size'];
    $stock = $_POST['stock'];
    $price = $_POST['price'];

    // Validasi input
    if (empty($name) || empty($description) || empty($category_id) || empty($size) || empty($stock) || empty($price)) {
        echo json_encode(['success' => false, 'message' => 'Semua field harus diisi.']);
        exit;
    }

    // Penanganan upload file gambar
    $image = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../../uploads/'; // Direktori penyimpanan file
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true); // Buat folder jika belum ada
        }

        $fileName = time() . '_' . basename($_FILES['image']['name']); // Tambahkan timestamp untuk nama file unik
        $uploadFile = $uploadDir . $fileName;

        // Validasi file: hanya izinkan gambar (jpg, png, jpeg)
        $fileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
        if (!in_array($fileType, ['jpg', 'jpeg', 'png'])) {
            echo json_encode(['success' => false, 'message' => 'Format file harus JPG, JPEG, atau PNG.']);
            exit;
        }

        // Pindahkan file yang diunggah
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
            echo json_encode(['success' => false, 'message' => 'Gagal mengunggah file.']);
            exit;
        }

        $image = $fileName; // Simpan nama file untuk database
    }

    // Update produk
    $query = "UPDATE products SET name = ?, description = ?, category_id = ?, size = ?, stock = ?, price = ?, updated_at = CURRENT_TIMESTAMP";
    $params = [$name, $description, $category_id, $size, $stock, $price];

    if ($image) {
        $query .= ", image = ?";
        $params[] = $image;
    }

    $query .= " WHERE product_id = ?";
    $params[] = $product_id;

    $stmt = $conn->prepare($query);
    $stmt->bind_param(str_repeat('s', count($params) - 1) . 'i', ...$params);

    // Eksekusi query dan respons
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Data berhasil diperbarui.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal memperbarui data.']);
    }

    // Tutup koneksi
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Metode request tidak valid.']);
}
?>
