<?php
// Koneksi ke database
include 'db_connection.php';
session_start();

// Mengatur nilai default variabel untuk menghindari undefined variable warning
$user_id = $_SESSION['user_id'] ?? null; // Pastikan session memiliki user_id
$kurir = 'reguler'; // Default kurir
$total_price = 0;
$shipping_cost = 0;
$total_amount = 0;

// Mengambil data pengguna
$query_user = "SELECT * FROM users WHERE id = '$user_id'";
$result_user = $conn->query($query_user);
$user = $result_user->fetch_assoc();

// Fungsi untuk menghitung total harga
function calculate_total($conn, $user_id, $kurir = 'reguler') {
    $total_price = 0;
    $query_cart = "
        SELECT cart.*, items.price
        FROM cart
        JOIN items ON cart.product_id = items.id
        WHERE cart.user_id = '$user_id'
    ";
    $result_cart = $conn->query($query_cart);
    while ($item = $result_cart->fetch_assoc()) {
        $total_price += $item['price'] * $item['quantity'];
    }

    // Menghitung ongkos kirim berdasarkan kurir
    $shipping_cost = 0;
    if ($kurir == 'instan') {
        $shipping_cost = 70000;
    } elseif ($kurir == 'cargo') {
        $shipping_cost = 100000;
    } elseif ($kurir == 'reguler') {
        $shipping_cost = 25000;
    }

    // Menghitung total tagihan
    $total_amount = $total_price + $shipping_cost + 5000; // Termasuk asuransi pengiriman

    return [
        'total_price' => $total_price,
        'shipping_cost' => $shipping_cost,
        'total_amount' => $total_amount
    ];
}

// Ambil total default saat halaman pertama kali dimuat
$calculated_totals = calculate_total($conn, $user_id, $kurir);
$total_price = $calculated_totals['total_price'];
$shipping_cost = $calculated_totals['shipping_cost'];
$total_amount = $calculated_totals['total_amount'];

// Simpan total_amount dalam session
$_SESSION['total_amount'] = $total_amount;

// Ambil data barang dari keranjang
$query_cart = "
    SELECT cart.*, items.name, items.price, items.image
    FROM cart
    JOIN items ON cart.product_id = items.id
    WHERE cart.user_id = '$user_id'
";
$result_cart = $conn->query($query_cart);
?>

<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Checkout Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&amp;display=swap" rel="stylesheet"/>
    <style>
      body {
        font-family: 'Roboto', sans-serif;
      }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
      $(document).ready(function() {
        function recalculateTotals() {
          let totalPrice = 0;
          let shippingCost = parseInt($("#kurir").val());

          $(".item-total").each(function() {
            totalPrice += parseInt($(this).data("item-total"));
          });

          let totalAmount = totalPrice + shippingCost + 5000; // Tambah asuransi

          $("#total_price").text("Rp " + totalPrice.toLocaleString());
          $("#shipping_cost").text("Rp " + shippingCost.toLocaleString());
          $("#total_amount").text("Rp " + totalAmount.toLocaleString());

          // Simpan total_amount ke sesi menggunakan AJAX
          $.post("update_total.php", { total_amount: totalAmount }, function(response) {
            console.log(response);
          });
        }

        $(".quantity").on("change", function() {
          let $row = $(this).closest(".cart-item");
          let price = parseInt($row.data("item-price"));
          let quantity = parseInt($(this).val());

          let itemTotal = price * quantity;
          $row.find(".item-total").data("item-total", itemTotal).text("Rp " + itemTotal.toLocaleString());

          recalculateTotals();
        });

        $("#kurir").on("change", function() {
          recalculateTotals();
        });
      });
    </script>
  </head>
  <body class="bg-gray-100">
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
    <main class="max-w-4xl mx-auto p-4">
      <h2 class="text-xl font-bold mb-4">
        <i class="fas fa-lock"></i> Checkout
      </h2>

      <!-- Alamat Pengiriman -->
      <section class="bg-white p-4 rounded-lg shadow mb-4">
        <div class="flex justify-between items-center">
          <div>
            <h3 class="font-bold">Alamat Pengiriman</h3>
            <p><?php echo $user['username']; ?> (<?php echo $user['phone']; ?>)</p>
            <p><?php echo $user['location']; ?></p>
          </div>
          <form action="edit_address.php" method="POST">
            <button class="text-blue-500">Ubah</button>
          </form>
        </div>
      </section>

      <!-- Daftar Barang di Keranjang -->
      <section class="bg-white p-4 rounded-lg shadow mb-4">
        <?php while ($item = $result_cart->fetch_assoc()) { 
            $image_path = 'assets/' . htmlspecialchars($item['image']);
        ?>
        <div class="cart-item flex justify-between items-center mb-4" data-item-price="<?php echo $item['price']; ?>">
            <div class="flex items-center">
                <img alt="Product Image" class="w-20 h-20 rounded-lg mr-4" src="<?php echo $image_path; ?>" />
                <div>
                    <h4 class="font-bold"><?php echo htmlspecialchars($item['name']); ?></h4>
                    <p>Rp <?php echo number_format($item['price'], 0, ',', '.'); ?></p>
                </div>
            </div>
            <div class="flex items-center">
                <!-- Kuantitas Barang Tetap -->
                <p class="quantity font-medium">Jumlah: <?php echo $item['quantity']; ?></p>
                <p class="item-total text-red-500 ml-4" data-item-total="<?php echo $item['price'] * $item['quantity']; ?>">
                    Rp <?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?>
                </p>
            </div>
        </div>
        <?php } ?>
      </section>

      <!-- Pilih Kurir -->
      <section class="bg-white p-4 rounded-lg shadow mb-4">
        <h3 class="font-bold mb-2">Pilih Kurir</h3>
        <select id="kurir" class="w-full p-2 border rounded">
          <option value="25000">Reguler (Rp 25.000)</option>
          <option value="70000">Instan (Rp 70.000)</option>
          <option value="100000">Cargo (Rp 100.000)</option>
        </select>
      </section>

      <!-- Ringkasan Belanja -->
      <section class="bg-white p-4 rounded-lg shadow">
        <h3 class="font-bold mb-2">Ringkasan Belanja</h3>
        <div class="flex justify-between mb-2">
            <p>Total Belanja</p>
            <p id="total_price">Rp <?php echo number_format($total_price, 0, ',', '.'); ?></p>
        </div>
        <div class="flex justify-between mb-2">
            <p>Ongkos Kirim</p>
            <p id="shipping_cost">Rp <?php echo number_format($shipping_cost, 0, ',', '.'); ?></p>
        </div>
        <div class="flex justify-between font-bold mb-4">
            <p>Total Tagihan</p>
            <p id="total_amount">Rp <?php echo number_format($total_amount, 0, ',', '.'); ?></p>
        </div>
        <form action="metodepembayaran.php" method="POST">
            <button type="submit" class="w-full bg-amber-800 text-white font-bold py-2 rounded-lg hover:bg-amber-700">
                Bayar Sekarang
            </button>
            <input type="hidden" name="total_amount" value="<?php echo $total_amount; ?>" />
        </form>
      </section>
    </main>
  </body>
</html>
