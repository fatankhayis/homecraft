<?php

// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$database = "homecraft";

$conn = new mysqli($servername, $username, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Default variabel
$produk = null;

// Cek apakah id_produk ada di URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_produk = intval($_GET['id']); // Pastikan ID berupa angka

    // Query untuk mendapatkan data produk dengan prepared statement
    $query = "SELECT * FROM items WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_produk);
    $stmt->execute();
    $result = $stmt->get_result();

    // Cek apakah produk ditemukan
    if ($result && $result->num_rows > 0) {
        $produk = $result->fetch_assoc(); // Ambil data produk
    }
    $stmt->close();
}

// Tutup koneksi
$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        body { background-color: #f3f4f6; }
        .bg-brown { background-color: #8B4513; }
        .text-brown { color: #4B2F19; }
        .icon-brown { color: #8B4513; }
        .line-through { text-decoration: line-through; }
        .img-thumbnail { border-radius: 10px; }
        .product-image, .product-details { background-color: bisque; padding: 20px; border-radius: 10px; }
        .custom-button { background-color: #8B4513; color: white; padding: 10px 20px; border-radius: 8px; }
        .custom-button:hover { background-color: bisque; color: #8B4513; }
    </style>
</head>
<body>
    <header class="bg-brown text-white py-3">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="fs-3 fw-bold">HOMECRAFT</div>
            <input type="text" placeholder="Pencarian" class="form-control w-50 mx-4">
            <div class="d-flex align-items-center">
                <img src="./assets/profile.jpg" class="rounded-circle me-2" style="width: 40px; height: 40px;">
                <span>Aldorandy</span>
            </div>
        </div>
    </header>

    <div class="container my-4">
        <?php if ($produk): ?>
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="product-image">
                    <!-- Menampilkan gambar produk dari database -->
                    <img src="foto_produk/<?= htmlspecialchars($produk['image']); ?>" alt="<?= htmlspecialchars($produk['name']); ?>" class="img-fluid rounded">
                </div>
            </div>
            <div class="col-lg-4">
                <div class="product-details">
                    <h2 class="fs-4 fw-semibold mb-2"><?php echo htmlspecialchars($produk['name']); ?></h2>
                    <p class="text-muted">
    <i class="bi bi-star-fill icon-brown"></i> 
    <?php echo htmlspecialchars($produk['rating']); ?> | Terjual
</p>
<p class="text-brown fw-bold fs-5">
    <i class="bi bi-currency-dollar icon-brown"></i> 
    Rp <?php echo number_format($produk['price'], 0, ',', '.'); ?>
</p>
<p class="text-muted">
    <i class="bi bi-geo-alt-fill icon-brown"></i> 
    <?php echo htmlspecialchars($produk['location']); ?>
</p>
<p class="text-muted">
    <?php echo htmlspecialchars($produk['description']); ?>
</p>

                    <div class="d-flex gap-2 mt-3">
                        <a href="keranjang.php?id=<?php echo $produk['id']; ?>" class="custom-button">Masukkan Keranjang</a>
                        <a href="beranda.php" class="custom-button">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
        <?php else: ?>
        <div class="alert alert-danger">Produk tidak ditemukan.</div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>