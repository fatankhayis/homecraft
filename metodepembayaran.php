<?php
session_start();
$total_amount = $_SESSION['total_amount'] ?? 0; // Ambil nilai total_amount dari session
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Metode Pembayaran</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Header -->
    <header class="bg-amber-800 p-4 flex items-center justify-between">
        <h1 class="text-white text-2xl font-bold">HOMECRAFT</h1>
        <div class="flex items-center space-x-4">
            <div class="relative">
                <input type="text" placeholder="Pencarian" class="p-2 rounded-md focus:outline-none focus:ring-2 focus:ring-white">
                <i class="fas fa-search absolute top-3 right-3 text-gray-400"></i>
            </div>
            <img 
                src="./assets/profile.jpg" 
                alt="User profile picture" 
                class="rounded-full border-2 border-white" 
                width="40" 
                height="40">
            <span class="text-white">Aldorandy</span>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto p-4">
        <h2 class="text-xl font-bold mb-4">
            <i class="fas fa-money-check-alt"></i> Metode Pembayaran
        </h2>

        <!-- Pilihan Pembayaran -->
        <section class="bg-white p-4 rounded-lg shadow">
            <div class="mb-4">
                <button class="w-full text-left p-3 bg-gray-100 rounded-lg flex justify-between items-center" onclick="toggleBankList()">
                    <span><i class="fas fa-university"></i> Transfer Bank</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <ul class="bank-list hidden mt-2 space-y-2">
                    <li class="flex items-center p-2 bg-gray-50 rounded-lg cursor-pointer hover:bg-gray-100" onclick="selectBank('Bank Mandiri')">
                        <img src="./assets/MANDIRI.jpg" alt="Mandiri logo" class="w-10 h-10 rounded mr-4">
                        <span>Bank Mandiri</span>
                    </li>
                    <li class="flex items-center p-2 bg-gray-50 rounded-lg cursor-pointer hover:bg-gray-100" onclick="selectBank('Bank BRI')">
                        <img src="./assets/BRI.png" alt="BRI logo" class="w-10 h-10 rounded mr-4">
                        <span>Bank Rakyat Indonesia</span>
                    </li>
                    <li class="flex items-center p-2 bg-gray-50 rounded-lg cursor-pointer hover:bg-gray-100" onclick="selectBank('Bank BCA')">
                        <img src="./assets/BCA.png" alt="BCA logo" class="w-10 h-10 rounded mr-4">
                        <span>Bank Central Asia</span>
                    </li>
                    <li class="flex items-center p-2 bg-gray-50 rounded-lg cursor-pointer hover:bg-gray-100" onclick="selectBank('Bank BNI')">
                        <img src="./assets/BNI.png" alt="BNI logo" class="w-10 h-10 rounded mr-4">
                        <span>Bank BNI</span>
                    </li>
                </ul>
            </div>

            <!-- Konfirmasi Bank Terpilih -->
            <p id="selected-bank" class="mt-3 text-gray-700 font-semibold"></p>
            <button class="w-full bg-amber-800 text-white font-bold py-2 rounded-lg hover:bg-amber-700" onclick="redirectToPaymentPage()">
                Konfirmasi Metode Pembayaran
            </button>
        </section>
    </main>

    <!-- Scripts -->
    <script>
        let selectedBank = '';

        function toggleBankList() {
            const bankList = document.querySelector('.bank-list');
            bankList.classList.toggle('hidden');
        }

        function selectBank(bankName) {
            selectedBank = bankName;
            document.getElementById('selected-bank').textContent = `Bank yang dipilih: ${bankName}`;
        }

        function redirectToPaymentPage() {
            if (!selectedBank) {
                alert('Silakan pilih bank terlebih dahulu!');
                return;
            }

            // Ambil totalAmount dari PHP yang sudah disimpan di session
            const totalAmount = <?php echo json_encode($total_amount); ?>;
            console.log(totalAmount); // Cek di console apakah totalAmount benar
            const url = `halamanpembayaran.php?bank=${encodeURIComponent(selectedBank)}&total=${totalAmount}`;
            window.location.href = url;
        }
    </script>
</body>
</html>
