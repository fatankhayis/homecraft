<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "homecraft";

$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Proses formulir saat disubmit
$message = ""; // Variabel untuk menyimpan pesan alert
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $rating = $_POST['rating'];
    $location = $_POST['location'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $added_by = $_POST['added_by'];

    // Proses upload gambar
    $target_dir = "foto_produk/";
    $image_name = basename($_FILES["image"]["name"]);
    $target_file = $target_dir . $image_name;
    $upload_ok = 1;
    $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Validasi file gambar
    if (isset($_FILES["image"])) {
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check === false) {
            $message = "File bukan gambar.";
            $upload_ok = 0;
        }
    }

    // Periksa ukuran file
    if ($_FILES["image"]["size"] > 500000) { // 500 KB
        $message = "Ukuran file terlalu besar.";
        $upload_ok = 0;
    }

    // Periksa format file
    $allowed_types = ["jpg", "jpeg", "png", "gif"];
    if (!in_array($image_file_type, $allowed_types)) {
        $message = "Hanya file JPG, JPEG, PNG, dan GIF yang diperbolehkan.";
        $upload_ok = 0;
    }

    // Jika validasi berhasil, pindahkan file ke server
    if ($upload_ok == 1) {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // Simpan data ke database
            $sql = "INSERT INTO items (name, description, image, rating, location, price, stock, added_by) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssdsisi", $name, $description, $image_name, $rating, $location, $price, $stock, $added_by);

            if ($stmt->execute()) {
                $message = "Produk berhasil ditambahkan!";
            } else {
                $message = "Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            $message = "Gagal mengunggah gambar.";
        }
    }
}

$conn->close();
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
