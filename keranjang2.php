<?php
session_start();
include 'db_connection.php';

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    die('Error: Anda harus login terlebih dahulu.');
}
$user_id = $_SESSION['user_id']; // Ambil user_id dari session

// Mengambil data dari tabel cart berdasarkan user_id, dan gabungkan dengan tabel items
$query = "SELECT c.product_id, c.quantity, i.name, i.price, i.image
          FROM cart c
          JOIN items i ON c.product_id = i.id
          WHERE c.user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Update quantity jika tombol + atau - ditekan
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_quantity'])) {
    $product_id = $_POST['product_id'];
    $current_quantity = $_POST['current_quantity'];
    
    // Tentukan apakah tombol yang ditekan adalah untuk mengurangi atau menambah kuantitas
    if ($_POST['update_quantity'] == 'decrease' && $current_quantity > 1) {
        $new_quantity = $current_quantity - 1;  // Kurangi kuantitas
    } elseif ($_POST['update_quantity'] == 'increase') {
        $new_quantity = $current_quantity + 1;  // Tambah kuantitas
    }

    if (isset($new_quantity)) {
        // Update kuantitas dalam database
        $update_query = "UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bind_param("iii", $new_quantity, $user_id, $product_id);
        $update_stmt->execute();
    }
    
    header("Location: ".$_SERVER['PHP_SELF']); // Redirect untuk me-refresh halaman
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Homecraft Shopping Cart</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-white">
  <!-- Header -->
  <header class="bg-amber-800 p-4 flex items-center justify-between">
    <h1 class="text-white text-2xl font-bold">HOMECRAFT</h1>
    <div class="flex items-center space-x-4">
      <div class="relative">
        <input type="text" placeholder="Search..." class="p-2 rounded-md focus:outline-none focus:ring-2 focus:ring-white">
        <i class="fas fa-search absolute top-3 right-3 text-gray-400"></i>
      </div>
      <img 
        src="https://storage.googleapis.com/a1aa/image/afzsl4qARpR5Dii684hdWyOnVHXN8CvK5pew3OlVzxm8TsenA.jpg" 
        alt="User profile picture" 
        class="rounded-full border-2 border-white" 
        width="40" 
        height="40">
    </div>
  </header>

  <!-- Main Content -->
  <main class="p-4">
    <h2 class="text-xl font-bold mb-4 flex items-center space-x-2">
      <i class="fas fa-shopping-cart"></i>
      <span>Keranjang Belanja</span>
    </h2>

    <div class="overflow-x-auto">
      <table class="min-w-full border-collapse border border-gray-200">
        <thead class="bg-gray-100">
          <tr>
            <th class="p-4 border border-gray-200 text-left"><input type="checkbox"></th>
            <th class="p-4 border border-gray-200 text-left">Produk</th>
            <th class="p-4 border border-gray-200 text-left">Harga Satuan</th>
            <th class="p-4 border border-gray-200 text-left">Kuantitas</th>
            <th class="p-4 border border-gray-200 text-left">Total Harga</th>
            <th class="p-4 border border-gray-200 text-left">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($result->num_rows > 0): ?>
            <?php
            $total = 0;
            while ($row = $result->fetch_assoc()):
              $subtotal = $row['price'] * $row['quantity'];
              $total += $subtotal;
              // Tambahkan path ke folder "asset" di depan nama file gambar
              $image_path = 'assets/' . htmlspecialchars($row['image']);
            ?>
              <tr class="border-b">
                <td class="p-4 border border-gray-200"><input type="checkbox"></td>
                <td class="p-4 border border-gray-200 flex items-center space-x-4">
                  <img 
                    src="<?= $image_path ?>" 
                    alt="<?= htmlspecialchars($row['name']) ?>" 
                    class="w-20 h-20 rounded-md border" 
                    width="100" 
                    height="100">
                  <span><?= htmlspecialchars($row['name']) ?></span>
                </td>
                <td class="p-4 border border-gray-200">Rp<?= number_format($row['price'], 0, ',', '.') ?></td>
                <td class="p-4 border border-gray-200">
                  <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">
                    <input type="hidden" name="product_id" value="<?= $row['product_id'] ?>">
                    <input type="hidden" name="current_quantity" value="<?= $row['quantity'] ?>">
                    <div class="flex items-center space-x-2">
                      <button type="submit" name="update_quantity" value="decrease" class="border px-2 rounded">-</button>
                      <input type="text" value="<?= $row['quantity'] ?>" class="w-12 text-center border rounded" disabled>
                      <button type="submit" name="update_quantity" value="increase" class="border px-2 rounded">+</button>
                    </div>
                  </form>
                </td>
                <td class="p-4 border border-gray-200 text-red-500">Rp<?= number_format($subtotal, 0, ',', '.') ?></td>
                <td class="p-4 border border-gray-200">
                <a href="hapus_keranjang.php?product_id=<?= $row['product_id'] ?>" class="text-red-500 hover:underline">Hapus</a>
                </td>
              </tr>
            <?php endwhile; ?>
            <tr class="bg-gray-200">
              <td colspan="4" class="p-4 text-right font-bold">Total:</td>
              <td class="p-4 text-red-500 font-bold">Rp<?= number_format($total, 0, ',', '.') ?></td>
              <td class="p-4"></td>
            </tr>
          <?php else: ?>
            <tr>
              <td colspan="6" class="p-4 text-center">Keranjang Anda kosong.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

   <!-- Tombol Checkout -->
<?php if ($result->num_rows > 0): ?>
    <div class="mt-4 text-right">
      <a href="checkout.php" class="bg-amber-800 text-white px-6 py-2 rounded hover:bg-amber-600 transition duration-300">Checkout</a>
    </div>
    <?php endif; ?>
    <div class="mt-1">
      <a href="beranda.php" class="text-amber-800 hover:underline">Lanjutkan Belanja</a>
    </div>
  </main>
</body>
</html>
