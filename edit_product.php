<?php
require 'db_connection.php';

// Validasi parameter ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID produk tidak diberikan.");
}

$id = $_GET['id'];

// Mendapatkan data produk
$product = $conn->query("SELECT * FROM items WHERE id = '$id'")->fetch_assoc();
if (!$product) {
    die("Produk dengan ID $id tidak ditemukan.");
}

$message = ""; // Variabel untuk pesan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $rating = $_POST['rating'];
    $location = $_POST['location'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $added_by = $_POST['added_by'];

    // Proses upload gambar
    $target_dir = "foto_produk/";
    $image_name = $_FILES['image']['name'] ? basename($_FILES['image']['name']) : $product['image'];
    $target_file = $target_dir . $image_name;
    $upload_ok = 1;
    $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Validasi file gambar jika diunggah
    if ($_FILES['image']['name']) {
        $check = getimagesize($_FILES['image']['tmp_name']);
        if ($check === false) {
            $message = "File bukan gambar.";
            $upload_ok = 0;
        }

        if ($_FILES['image']['size'] > 500000) { // 500 KB
            $message = "Ukuran file terlalu besar.";
            $upload_ok = 0;
        }

        $allowed_types = ["jpg", "jpeg", "png", "gif"];
        if (!in_array($image_file_type, $allowed_types)) {
            $message = "Hanya file JPG, JPEG, PNG, dan GIF yang diperbolehkan.";
            $upload_ok = 0;
        }

        if ($upload_ok == 1 && !move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $message = "Gagal mengunggah gambar.";
            $upload_ok = 0;
        }
    }

    // Jika tidak ada error, perbarui data produk
    if ($upload_ok == 1) {
        $sql = "UPDATE items SET 
                    name = ?, 
                    description = ?, 
                    image = ?, 
                    rating = ?, 
                    location = ?, 
                    price = ?, 
                    stock = ?, 
                    added_by = ? 
                WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssdsisii", $name, $description, $image_name, $rating, $location, $price, $stock, $added_by, $id);

        if ($stmt->execute()) {
            $message = "Produk berhasil diperbarui!";
            header("Location: produkseller.php");
            exit;
        } else {
            $message = "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <script>
        function showAlert(message) {
            if (message) {
                alert(message);
            }
        }
    </script>
</head>
<body class="bg-gray-100" onload="showAlert('<?php echo $message; ?>')">
    <div class="container mx-auto mt-10">
        <h1 class="text-2xl font-bold mb-5">Edit Produk</h1>
        <form method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow-md">
            <div class="mb-4">
                <label class="block text-gray-700">Nama Produk</label>
                <input type="text" name="name" value="<?= isset($product['name']) ? htmlspecialchars($product['name']) : '' ?>" class="w-full border rounded p-2" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Deskripsi</label>
                <textarea name="description" class="w-full border rounded p-2" required><?= isset($product['description']) ? htmlspecialchars($product['description']) : '' ?></textarea>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Gambar Produk</label>
                <input type="file" name="image" class="w-full border rounded p-2">
                <p class="text-sm text-gray-500 mt-1">Gambar saat ini: <?= isset($product['image']) ? htmlspecialchars($product['image']) : '' ?></p>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Rating</label>
                <input type="number" name="rating" value="<?= isset($product['rating']) ? htmlspecialchars($product['rating']) : '' ?>" step="0.1" class="w-full border rounded p-2" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Lokasi</label>
                <input type="text" name="location" value="<?= isset($product['location']) ? htmlspecialchars($product['location']) : '' ?>" class="w-full border rounded p-2" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Harga</label>
                <input type="number" name="price" value="<?= isset($product['price']) ? htmlspecialchars($product['price']) : '' ?>" class="w-full border rounded p-2" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Stok</label>
                <input type="number" name="stock" value="<?= isset($product['stock']) ? htmlspecialchars($product['stock']) : '' ?>" class="w-full border rounded p-2" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">ID Penambah Produk</label>
                <input type="number" name="added_by" value="<?= isset($product['added_by']) ? htmlspecialchars($product['added_by']) : '' ?>" class="w-full border rounded p-2" required>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Perbarui Produk</button>
        </form>
    </div>
</body>
</html>
