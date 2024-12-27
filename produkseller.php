<?php
require 'db_connection.php';
session_start();

// Pastikan user login
if (!isset($_SESSION['seller_id'])) {
    header("Location: indexseller.php");
    exit;
}

// Ambil ID seller dari sesi
$seller_id = $_SESSION['seller_id'];

// Ambil produk yang sesuai dengan seller yang login
$sql = "SELECT items.* FROM items 
        INNER JOIN users ON items.seller_id = users.id 
        WHERE users.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['seller_id']);
$stmt->execute();
$result = $stmt->get_result();


// Fungsi untuk menghapus produk
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_sql = "DELETE FROM items WHERE id = ? AND seller_id = ?";
    $delete_stmt = $conn->prepare($delete_sql);
    $delete_stmt->bind_param("ss", $delete_id, $seller_id);
    if ($delete_stmt->execute()) {
        header("Location: produkseller.php");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPACEWOOD Seller Centre</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <style>
        .hover-bisque:hover {
            background-color: bisque !important;
        }
        .active {
            background-color: bisque !important;
            font-weight: bold;
            color: #8B4513 !important;
            border-left: 4px solid #8B4513;
            padding-left: 1rem;
        }
    </style>
</head>
<body class="bg-gray-100">
<div class="flex flex-col min-h-screen">
    <!-- Header -->
    <header class="bg-brown-600 text-white p-4 flex justify-between items-center" style="background-color: #8B4513;">
        <div class="text-lg font-semibold">SPACEWOOD Seller Centre</div>
        <div class="flex items-center space-x-4">
            <div class="flex items-center space-x-2">
                <img src="https://storage.googleapis.com/a1aa/image/ZS0OniuKrjofFqHZzqoIx50gWB7j7ZHyOU9a2K4JyDIF637JA.jpg" 
                     alt="User profile picture" 
                     class="rounded-full w-10 h-10" 
                     height="40" 
                     width="40"/>
                <span>nama.id</span>
            </div>
            <i class="fas fa-th-large"></i>
            <i class="fas fa-bell"></i>
            <button class="px-4 py-2 rounded text-white hover-bisque" style="background-color: #8B4513;">Kembali ke Akun Pembeli</button>
        </div>
    </header>
    <div class="flex flex-1">
        <!-- Sidebar -->
        <aside class="bg-white w-64 p-4">
            <nav class="space-y-4">
                <div>
                    <h2 class="font-semibold mb-2 text-brown-600"><i class="fas fa-shopping-cart mr-2 text-brown-600"></i>Pesanan</h2>
                    <ul class="space-y-1">
                        <li class="hover-bisque p-2 rounded">Pesanan Saya</li>
                        <li class="hover-bisque p-2 rounded">Kirimkan Pesanan</li>
                    </ul>
                </div>
                <div>
                    <h2 class="font-semibold mb-2 text-brown-600"><i class="fas fa-box mr-2 text-brown-600"></i>Produk</h2>
                    <ul class="space-y-1">
                        <!-- Elemen aktif di-highlight -->
                        <li class="active">Produk Saya</li>
                        <!-- Perbaikan untuk tombol "Tambah Produk Baru" -->
                        <li class="hover-bisque p-2 rounded">
                            <a href="add_product.php" class="block">Tambah Produk Baru</a>
                        </li>
                        <li class="hover-bisque p-2 rounded">Pelanggaran Saya</li>
                    </ul>
                </div>
                <div>
                    <h2 class="font-semibold mb-2 text-brown-600"><i class="fas fa-wallet mr-2 text-brown-600"></i>Keuangan</h2>
                    <ul class="space-y-1">
                        <li class="hover-bisque p-2 rounded">Penghasilan Saya</li>
                        <li class="hover-bisque p-2 rounded">Saldo Saya</li>
                        <li class="hover-bisque p-2 rounded">Rekening Saya</li>
                    </ul>
                </div>
                <div>
                    <h2 class="font-semibold mb-2 text-brown-600"><i class="fas fa-store mr-2 text-brown-600"></i>Data Toko Saya</h2>
                    <ul class="space-y-1">
                        <li class="hover-bisque p-2 rounded">Data Toko Saya</li>
                    </ul>
                </div>
                <div>
                    <h2 class="font-semibold mb-2 text-brown-600"><i class="fas fa-tools mr-2 text-brown-600"></i>Toko</h2>
                    <ul class="space-y-1">
                        <li class="hover-bisque p-2 rounded">Dekorasi Toko</li>
                        <li class="hover-bisque p-2 rounded">Pengaturan Toko</li>
                    </ul>
                </div>
            </nav>
        </aside>
        <!-- Main Content -->
        <main class="flex-1 p-6">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-semibold text-brown-600">Produk Saya</h1>
                <a href="add_product.php" class="px-4 py-2 rounded text-white hover-bisque" style="background-color: #8B4513;">+ Tambah Produk Baru</a>
            </div>
            <div class="bg-white p-4 rounded shadow">
                <div class="mb-4 text-brown-600"><?= $result->num_rows ?> Produk</div>
                <table class="w-full border">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border p-2">Produk</th>
                            <th class="border p-2">Harga</th>
                            <th class="border p-2">Stok</th>
                            <th class="border p-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td class="border p-2 flex items-center">
                                        <img src="./foto_produk/<?= $row['image'] ?>" alt="<?= $row['name'] ?>" class="w-12 h-12 mr-2"/>
                                        <?= $row['name'] ?>
                                    </td>
                                    <td class="border p-2 text-center">Rp<?= number_format($row['price'], 0, ',', '.') ?></td>
                                    <td class="border p-2 text-center"><?= $row['stock'] ?></td>
                                    <td class="border p-2 text-center space-x-2">
                                        <a href="edit_product.php?id=<?= $row['id'] ?>" class="hover-bisque">Edit</a>
                                        <a href="?delete_id=<?= $row['id'] ?>" class="hover-bisque" onclick="return confirm('Yakin ingin menghapus produk ini?')">Hapus</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center p-4">Tidak ada produk.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>
</body>
</html>
