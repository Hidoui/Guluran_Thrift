<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "guluran_thrift");

// Periksa koneksi
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Koneksi ke database gagal: ' . $conn->connect_error]);
    exit;
}

// Ambil data dari request
$name = $_POST['name'] ?? null;
$category = $_POST['category'] ?? null;
$price = $_POST['price'] ?? null;
$stock = $_POST['stock'] ?? null;
$size = $_POST['size'] ?? null;
$image = $_FILES['image'] ?? null;

// Validasi input
if (!$name || !$category || !$price || !$stock || !$size || !$image) {
    echo json_encode(['success' => false, 'message' => 'Semua input harus diisi, termasuk ukuran dan gambar.']);
    exit;
}

// Validasi dan simpan gambar
$uploadDir = 'uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true); // Buat direktori jika belum ada
}
$imageName = time() . '_' . basename($image['name']);
$targetFile = $uploadDir . $imageName;

// Periksa jenis file gambar
$allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
if (!in_array($image['type'], $allowedTypes)) {
    echo json_encode(['success' => false, 'message' => 'Jenis file gambar tidak valid.']);
    exit;
}

// Pindahkan gambar ke folder target
if (!move_uploaded_file($image['tmp_name'], $targetFile)) {
    echo json_encode(['success' => false, 'message' => 'Gagal mengunggah gambar.']);
    exit;
}

// Query SQL untuk mendapatkan ID kategori
$category_id = null;
$stmt = $conn->prepare("SELECT category_id FROM categories WHERE category_name = ?");
if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Gagal mempersiapkan query kategori: ' . $conn->error]);
    exit;
}
$stmt->bind_param('s', $category);
$stmt->execute();
$stmt->bind_result($category_id);
$stmt->fetch();
$stmt->close();

if (!$category_id) {
    echo json_encode(['success' => false, 'message' => 'Kategori tidak ditemukan.']);
    exit;
}

// Query untuk menyimpan produk
$stmt = $conn->prepare("INSERT INTO products (name, category_id, price, stock, size, image) VALUES (?, ?, ?, ?, ?, ?)");
if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Gagal mempersiapkan query produk: ' . $conn->error]);
    exit;
}
$stmt->bind_param('sidiss', $name, $category_id, $price, $stock, $size, $imageName);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Produk berhasil disimpan.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Gagal menyimpan produk: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
