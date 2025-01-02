<?php
session_start();
include 'db_connection.php';

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    die('Error: Anda harus login terlebih dahulu.');
}
$user_id = $_SESSION['user_id']; // Ambil user_id dari session

// Validasi data POST
if (!isset($_POST['product_id']) || empty($_POST['product_id'])) {
    die('Error: product_id tidak diterima.');
}
$product_id = intval($_POST['product_id']);

// Cek apakah produk ada di tabel items dan ambil gambar produk
$query = "SELECT id, image FROM items WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die('Error: Produk tidak ditemukan.');
}

// Ambil data gambar produk
$row = $result->fetch_assoc();
$item = $row['image']; // Gambar produk

// Cek apakah produk sudah ada di keranjang
$query = "SELECT * FROM cart WHERE user_id = ? AND product_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $user_id, $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Jika produk sudah ada, tambahkan jumlah
    $query = "UPDATE cart SET quantity = quantity + 1 WHERE user_id = ? AND product_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $user_id, $product_id);
} else {
    // Jika produk belum ada, tambahkan ke keranjang dengan gambar
    $query = "INSERT INTO cart (user_id, product_id, quantity, image) VALUES (?, ?, 1, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iis", $user_id, $product_id, $image);
}

if ($stmt->execute()) {
    header("Location: keranjang2.php");
    exit();
} else {
    echo "Error: " . $conn->error;
}
?>
