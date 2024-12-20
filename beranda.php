<?php
include 'db_connection.php';

// Query untuk mengambil data produk dari tabel `items`
$sql = "SELECT * FROM items";
$result = $conn->query($sql);

// Ambil semua data produk terlebih dahulu
$produk = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $produk[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>HomeCraft</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />

    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }

        .dropdown {
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            z-index: 10;
            background: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 0.25rem;
            overflow: hidden;
        }

        .dropdown.active {
            display: block;
        }

        .dropdown a {
            display: block;
            padding: 0.5rem 1rem;
            text-decoration: none;
            color: black;
            transition: background 0.2s;
        }

        .dropdown a:hover {
            background: #f3f3f3;
        }

        .product-image {
            width: 150px;
            height: 150px;
            object-fit: cover;
            margin: auto;
            border-radius: 8px;
        }
    </style>

    <script>
        function addToCart(itemId) {
            const userId = 1; // Misalnya, user_id 1

            fetch('add_to_cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ item_id: itemId, user_id: userId, quantity: 1 }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    window.location.href = 'keranjang.php';
                } else {
                    alert('Gagal menambahkan barang ke keranjang: ' + data.message);
                }
            })
            .catch((error) => {
                console.error('Error:', error);
            });
        }

        function toggleDropdown() {
            const dropdown = document.getElementById("profileDropdown");
            dropdown.classList.toggle("active");
        }

        document.addEventListener("click", function (event) {
            const dropdown = document.getElementById("profileDropdown");
            const profileIcon = document.getElementById("profileIcon");
            if (!dropdown.contains(event.target) && !profileIcon.contains(event.target)) {
                dropdown.classList.remove("active");
            }
        });
    </script>
</head>
<body class="bg-gray-100">
    <!-- Header -->
    <header class="bg-[#8B4513] p-4 flex items-center justify-between">
      <div class="flex items-center space-x-4">
          <div class="text-white text-xl font-bold">HOMECRAFT</div>
          <a href="daftarseller.php" class="text-white text-sm underline hover:text-gray-200">Masuk sebagai Penjual</a>
      </div>
      <div class="flex items-center space-x-6 text-white">
          <i class="fas fa-search"></i>
          <div class="relative">
              <i class="fas fa-bell"></i>
              <span class="absolute -top-1 -right-1 flex h-3 w-3">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-sky-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-3 w-3 bg-sky-500"></span>
              </span>
          </div>
          <a href="keranjang.php">
              <i class="fas fa-shopping-cart"></i>
          </a>
          <div class="relative">
              <i
                  id="profileIcon"
                  class="fas fa-user-circle cursor-pointer"
                  onclick="toggleDropdown()"
              ></i>
              <div id="profileDropdown" class="dropdown bg-white text-black rounded-md">
                  <a href="profilesaya.php">profil saya</a>
                  <a href="orders.php">My Orders</a>
                  <a href="logout.php">Logout</a>
              </div>
            </div>
        </div>
    </header>


    <!-- Main Content -->
    <main class="p-4">
        <!-- Banner Section -->
        <div
            class="bg-cover bg-center h-24 mb-4"
            style="background-image: url('./assets/baner1.jpg');"
            role="img"
            aria-label="Banner"
        ></div>

        <!-- Product Grid for First Banner -->
        <div class="grid grid-cols-3 gap-4 mb-4">
            <?php for ($i = 0; $i < 3 && $i < count($produk); $i++): ?>
                <div class="bg-white p-4 rounded shadow">
                    <img
                        src="./foto_produk/<?= htmlspecialchars($produk[$i]['image']) ?>"
                        alt="<?= htmlspecialchars($produk[$i]['name']) ?>"
                        class="product-image mb-4"
                    />
                    <h2 class="text-lg font-bold mb-2"><?= htmlspecialchars($produk[$i]['name']) ?></h2>
                    <p class="text-gray-600 mb-2"><i class="fas fa-star text-yellow-400"></i> <?= htmlspecialchars($produk[$i]['rating']) ?> | <?= htmlspecialchars($produk[$i]['sold']) ?> Terjual</p>
                    <p class="text-gray-600 mb-2"><i class="fas fa-map-marker-alt text-gray-600 mr-2"></i> <?= htmlspecialchars($produk[$i]['location']) ?></p>
                    <p class="text-lg font-bold text-orange-600 mb-2">Rp <?= number_format($produk[$i]['price'], 0, ',', '.') ?></p>
                    <div class="flex flex-col space-y-4">
                        <button
                            class="bg-[#8B4513] text-white px-4 py-2 rounded hover:bg-[#FFE4C4] transition duration-300"
                            onclick="addToCart(<?= htmlspecialchars($produk[$i]['id']) ?>)"
                        >
                            Masukkan ke Keranjang
                        </button>
                        <button
                            class="bg-[#8B4513] text-white px-4 py-2 rounded hover:bg-[#FFE4C4] transition duration-300"
                            onclick="window.location.href='detailproduk.php?id=<?= htmlspecialchars($produk[$i]['id']) ?>'"
                        >
                            Lihat Detail Produk
                        </button>
                    </div>
                </div>
            <?php endfor; ?>
        </div>

        <!-- Second Banner -->
        <div
            class="bg-cover bg-center h-24 mb-4"
            style="background-image: url('./assets/baner2.jpg');"
            role="img"
            aria-label="Banner"
        ></div>

        <!-- Product Grid for Second Banner -->
        <div class="grid grid-cols-3 gap-4">
            <?php for ($i = 3; $i < count($produk); $i++): ?>
                <div class="bg-white p-4 rounded shadow">
                    <img
                        src="./foto_produk/<?= htmlspecialchars($produk[$i]['image']) ?>"
                        alt="<?= htmlspecialchars($produk[$i]['name']) ?>"
                        class="product-image mb-4"
                    />
                    <h2 class="text-lg font-bold mb-2"><?= htmlspecialchars($produk[$i]['name']) ?></h2>
                    <p class="text-gray-600 mb-2"><i class="fas fa-star text-yellow-400"></i> <?= htmlspecialchars($produk[$i]['rating']) ?> | <?= htmlspecialchars($produk[$i]['sold']) ?> Terjual</p>
                    <p class="text-gray-600 mb-2"><i class="fas fa-map-marker-alt text-gray-600 mr-2"></i> <?= htmlspecialchars($produk[$i]['location']) ?></p>
                    <p class="text-lg font-bold text-orange-600 mb-2">Rp <?= number_format($produk[$i]['price'], 0, ',', '.') ?></p>
                    <div class="flex flex-col space-y-4">
                        <button
                            class="bg-[#8B4513] text-white px-4 py-2 rounded hover:bg-[#FFE4C4] transition duration-300"
                            onclick="addToCart(<?= htmlspecialchars($produk[$i]['id']) ?>)"
                        >
                            Masukkan ke Keranjang
                        </button>
                        <button
                            class="bg-[#8B4513] text-white px-4 py-2 rounded hover:bg-[#FFE4C4] transition duration-300"
                            onclick="window.location.href='detailproduk.php?id=<?= htmlspecialchars($produk[$i]['id']) ?>'"
                        >
                            Lihat Detail Produk
                        </button>
                    </div>
                </div>
            <?php endfor; ?>
        </div>
    </main>
    <script>
    //   function addToCart(itemId) {
    //     const userId = 1; // Contoh user_id
    //     fetch('add_to_cart.php', {
    //       method: 'POST',
    //       headers: {
    //         'Content-Type': 'application/json',
    //       },
    //       body: JSON.stringify({ item_id: itemId, user_id: userId, quantity: 1 }),
    //     })
    //       .then(response => response.json())
    //       .then(data => {
    //         if (data.success) {
    //           // Tampilkan alert
    //           alert(data.message);
    //           // Redirect ke halaman keranjang
    //           window.location.href = 'keranjang.php';
    //         } else {
    //           alert('Gagal menambahkan ke keranjang: ' + data.message);
    //         }
    //       })
    //       .catch(error => {
    //         console.error('Error:', error);
    //       });
    //   }
    function addToCart(itemId) {
  alert("Produk berhasil ditambahkan ke keranjang.");
  window.location.href = 'keranjang.php';
}

    </script>

</body>
</html>
