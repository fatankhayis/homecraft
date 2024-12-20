<?php
// add_to_cart.php
header('Content-Type: application/json');
include 'db_connection.php'; // Ganti dengan file koneksi database Anda

// Ambil data dari request
$data = json_decode(file_get_contents('php://input'), true);
$user_id = $data['user_id'];
$item_id = $data['item_id'];
$quantity = $data['quantity'];

// Validasi input
if (isset($user_id) && isset($item_id) && isset($quantity)) {
    // Menyimpan data ke dalam tabel cart
    $stmt = $conn->prepare("INSERT INTO cart (user_id, item_id, quantity) VALUES (?, ?, ?)");
    $stmt->bind_param("iii", $user_id, $item_id, $quantity);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Barang berhasil ditambahkan ke keranjang.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal menambahkan barang.']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Data tidak lengkap.']);
}

$conn->close();
?>