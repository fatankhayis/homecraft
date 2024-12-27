<?php
require 'db_connection.php';
session_start();

if (!isset($_SESSION['seller_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $image = $_POST['image']; // Ganti dengan mekanisme upload file jika diperlukan
    $seller_id = $_SESSION['seller_id'];

    // Query untuk menyimpan produk
    $stmt = $conn->prepare("INSERT INTO items (name, price, stock, image, seller_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sdisi", $name, $price, $stock, $image, $seller_id);

    if ($stmt->execute()) {
        header("Location: produkseller.php");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <script>
        // Fungsi untuk menampilkan alert jika ada pesan dari PHP
        function showAlert(message) {
            if (message) {
                alert(message);
            }
        }
    </script>
</head>
<body class="bg-gray-100" onload="showAlert('<?php echo $message; ?>')">
    <div class="container mx-auto mt-10">
        <h1 class="text-2xl font-bold mb-5">Tambah Produk</h1>
        <form action="add_product.php" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow-md">
            <div class="mb-4">
                <label for="name" class="block text-gray-700">Nama Produk</label>
                <input type="text" name="name" id="name" class="w-full border rounded p-2" required>
            </div>
            <div class="mb-4">
                <label for="description" class="block text-gray-700">Deskripsi</label>
                <textarea name="description" id="description" class="w-full border rounded p-2" required></textarea>
            </div>
            <div class="mb-4">
                <label for="image" class="block text-gray-700">Gambar Produk</label>
                <input type="file" name="image" id="image" class="w-full border rounded p-2" required>
            </div>
            <div class="mb-4">
                <label for="rating" class="block text-gray-700">Rating</label>
                <input type="number" name="rating" id="rating" step="0.1" class="w-full border rounded p-2" required>
            </div>
            <div class="mb-4">
                <label for="location" class="block text-gray-700">Lokasi</label>
                <input type="text" name="location" id="location" class="w-full border rounded p-2" required>
            </div>
            <div class="mb-4">
                <label for="price" class="block text-gray-700">Harga</label>
                <input type="number" name="price" id="price" class="w-full border rounded p-2" required>
            </div>
            <div class="mb-4">
                <label for="stock" class="block text-gray-700">Stok</label>
                <input type="number" name="stock" id="stock" class="w-full border rounded p-2" required>
            </div>
            <div class="mb-4">
                <label for="added_by" class="block text-gray-700">ID Penambah Produk</label>
                <input type="number" name="added_by" id="added_by" class="w-full border rounded p-2" required>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Tambah Produk</button>
        </form>
    </div>
</body>
</html>
