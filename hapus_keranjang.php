<?php
session_start();
include 'db_connection.php';

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    die('Error: Anda harus login terlebih dahulu.');
}
$user_id = $_SESSION['user_id']; // Ambil user_id dari session

// Validasi data POST atau GET
if (!isset($_GET['product_id']) || empty($_GET['product_id'])) {
    die('Error: product_id tidak diterima.');
}
$product_id = intval($_GET['product_id']);

// Cek apakah produk ada di keranjang
$query = "SELECT * FROM cart WHERE user_id = ? AND product_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $user_id, $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die('Error: Produk tidak ditemukan di keranjang.');
}

// Hapus produk dari keranjang
$query = "DELETE FROM cart WHERE user_id = ? AND product_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $user_id, $product_id);
if ($stmt->execute()) {
    // Redirect kembali ke halaman keranjang
    header("Location: keranjang2.php");
    exit();
} else {
    echo "Error: " . $conn->error;
}
?>
