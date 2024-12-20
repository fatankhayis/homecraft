<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SpaceWood - Keranjang Belanja</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
    </style>
    <script>
        let quantity = 1;
        let pricePerItem = 400000;
        let shippingCost = 25000;
        let insuranceCost = 5000;

        // Update total price based on quantity, shipping, and insurance
        function updateSummary() {
            const subtotal = quantity * pricePerItem;
            const total = subtotal + shippingCost + insuranceCost;

            document.getElementById('quantity-display').innerText = quantity;
            document.getElementById('subtotal-display').innerText = `Rp ${subtotal.toLocaleString()}`;
            document.getElementById('shipping-cost-display').innerText = `Rp ${shippingCost.toLocaleString()}`;
            document.getElementById('total-display').innerText = `Rp ${total.toLocaleString()}`;
        }

        // Increment quantity
        function incrementQuantity() {
            quantity += 1;
            updateSummary();
        }

        // Decrement quantity (minimum 1)
        function decrementQuantity() {
            if (quantity > 1) {
                quantity -= 1;
                updateSummary();
            }
        }

        // Update shipping cost based on selected courier
        function updateShippingCost() {
            const courier = document.getElementById('kurir').value;
            if (courier === 'reguler') {
                shippingCost = 25000;
            } else if (courier === 'instant') {
                shippingCost = 70000;
            } else if (courier === 'cargo') {
                shippingCost = 100000;
            }
            updateSummary();
        }

        // Function to confirm item removal
        function confirmDelete() {
            const confirmAction = confirm("Apakah Anda yakin ingin menghapus barang dari keranjang?");
            if (confirmAction) {
                window.location.href = "beranda.php"; // Redirect to homepage
            }
        }

        // Initialize the summary on page load
        window.onload = updateSummary;
    </script>
</head>
<body class="bg-white">
    <!-- Header -->
    <header class="bg-[#b4693d] p-4 flex justify-between items-center">
        <div class="text-white text-2xl font-bold">SPACEWOOD</div>
        <div class="flex items-center">
            <input type="text" class="p-2 rounded border border-gray-300" placeholder="Pencarian" />
            <i class="fas fa-search text-white ml-2"></i>
        </div>
        <div class="flex items-center">
            <i class="fas fa-user-circle text-white text-3xl"></i>
            <span class="text-white ml-2">Nama</span>
        </div>
    </header>

    <!-- Main Content -->
    <main class="p-8">
        <!-- Section: Keranjang Belanja -->
        <div class="flex items-center mb-4">
            <i class="fas fa-shopping-cart text-2xl"></i>
            <h1 class="text-2xl font-bold ml-2">Keranjang Belanja</h1>
        </div>

        <div class="flex">
            <!-- Product Image -->
            <div class="w-1/2">
                <img
                    src="https://storage.googleapis.com/a1aa/image/EoKdw8gB8eydRamk2AdZCpkFL6BnJ42FrQ1u0E6sdFfOFy0TA.jpg"
                    alt="Aesthetic table with a stool in a well-lit room"
                    class="w-full"
                    width="600"
                    height="400"
                />
            </div>

            <!-- Product Details -->
            <div class="w-1/2 pl-8">
                <h2 class="text-2xl font-bold">Meja Estetik 1945</h2>
                <p class="text-gray-500">Terjual 10+</p>
                <p class="text-3xl font-bold text-black">Rp 400.000</p>
                <p class="text-gray-500 line-through">Rp 640.000</p>

                <!-- Quantity Section -->
                <div class="flex items-center mt-4">
                    <button class="bg-gray-200 px-2 py-1" onclick="decrementQuantity()">-</button>
                    <span id="quantity-display" class="mx-2">1</span>
                    <button class="bg-gray-200 px-2 py-1" onclick="incrementQuantity()">+</button>
                    <span class="ml-4">
                        Stok total:
                        <span class="text-red-500">SISA 5</span>
                    </span>
                </div>

                <!-- Delete Button -->
                <div class="mt-4">
                    <button 
                        class="bg-red-500 text-white px-4 py-2 rounded"
                        onclick="confirmDelete()">
                        Hapus
                    </button>
                </div>

                <!-- Shipping & Payment -->
                <h3 class="mt-8 font-bold">Pengiriman dan Pembayaran</h3>
                <p>Rumah - Aldo (628287361839)</p>
                <p>Jl. Pasir Kaliki No.10, Pasir Kaliki, Kec. Cicendo, Kota Bandung, Jawa Barat 1975</p>

                <div class="mt-4">
                    <label for="kurir" class="block font-bold mb-2">Pilih Kurir</label>
                    <select id="kurir" class="border border-gray-300 p-2 rounded w-full" onchange="updateShippingCost()">
                        <option value="reguler">Reguler (Rp 25.000)</option>
                        <option value="instant">Instant (Rp 70.000)</option>
                        <option value="cargo">Cargo (Rp 100.000)</option>
                    </select>
                </div>
            </div>

            <!-- Shopping Summary -->
            <div class="w-1/3 mt-8 mb-10 border p-4">
    <h3 class="font-bold">Ringkasan Belanja</h3>
    <div class="flex justify-between mt-4">
        <span>Total belanja</span>
        <span id="subtotal-display">Rp 400.000</span>
    </div>
    <div class="flex justify-between mt-2 text-gray-500">
        <span>Total harga (1 barang)</span>
        <span id="subtotal-display">Rp 400.000</span>
    </div>
    <div class="flex justify-between mt-2 text-gray-500">
        <span>Total Ongkos Kirim</span>
        <span id="shipping-cost-display">Rp 25.000</span>
    </div>
    <div class="flex justify-between mt-2 text-gray-500">
        <span>Asuransi Pengiriman</span>
        <span>Rp 5.000</span>
    </div>
    <hr />
    <div class="flex justify-between mt-10 mb-10 font-bold">
        <span>Total Tagihan</span>
        <span id="total-display">Rp 430.000</span>
    </div>
    <!-- Tombol Pembayaran -->
    <button 
        class="bg-[#b4693d] text-white w-full py-2 mt-4 mb-10 rounded"
        onclick="window.location.href='pembayaran.php';">
        Bayar Sekarang
    </button>
</div>
    </div>

        <!-- Back Button -->
        <button class="bg-[#b4693d] text-white py-2 px-4 mt-8 rounded">Kembali</button>
    </main>
    <script>
    function updateServerTotal() {
        const subtotal = quantity * pricePerItem;
        const total = subtotal + shippingCost + insuranceCost;

        // Kirim total ke server menggunakan AJAX
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "update_cart.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send(`total=${total}`);
    }

    // Panggil updateServerTotal setiap kali ringkasan berubah
    function updateSummary() {
        const subtotal = quantity * pricePerItem;
        const total = subtotal + shippingCost + insuranceCost;

        document.getElementById('quantity-display').innerText = quantity;
        document.getElementById('subtotal-display').innerText = `Rp ${subtotal.toLocaleString()}`;
        document.getElementById('shipping-cost-display').innerText = `Rp ${shippingCost.toLocaleString()}`;
        document.getElementById('total-display').innerText = `Rp ${total.toLocaleString()}`;

        updateServerTotal(); // Update server
    }
</script>
</body>
</html>
