<?php
// Ambil data bank dan total_amount dari URL atau session
$bank = isset($_GET['bank']) ? $_GET['bank'] : 'Bank BCA'; // Bank yang dipilih
$logo = ''; // Logo bisa ditentukan berdasarkan bank yang dipilih
$total = isset($_GET['total']) ? $_GET['total'] : 0; // Total tagihan yang diteruskan dari metodepembayaran.php

// Tentukan logo bank yang dipilih
switch ($bank) {
    case 'Bank BCA':
        $logo = 'assets/BCA.png';
        break;
    case 'Bank Mandiri':
        $logo = 'assets/MANDIRI.jpg';
        break;
    case 'Bank BRI':
        $logo = 'assets/BRI.png';
        break;
    case 'Bank BNI':
        $logo = 'assets/BNI.png';
        break;
    default:
        $logo = 'https://linkke/logo/default.png'; // Ganti dengan logo default jika perlu
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Spacewood - Selesaikan Pembayaran</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet" />
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

  <main class="p-8">
    <div class="text-gray-700 mb-4">
      <i class="fas fa-lock"></i>
      <span class="ml-2">Selesaikan Pembayaran</span>
    </div>
    <div class="text-center mb-8">
      <h2 class="text-lg font-medium">Selesaikan Pembayaran Dalam</h2>
      <div id="countdown" class="text-red-600 text-2xl font-bold my-2">00:00:00</div>
      <div class="text-gray-500">Batas Akhir Pembayaran</div>
      <div id="payment-deadline" class="text-gray-700 font-medium"></div>
    </div>
    <div class="border rounded-lg p-4 mb-8">
      <div id="selectedBank" class="flex justify-between items-center mb-4">
        <!-- Bank name and logo will be populated here dynamically -->
      </div>
      <hr />
      <div class="mb-4">
        <div class="text-gray-500">Nomor Rekening Pembayaran</div>
        <div class="text-gray-700 text-lg font-medium" id="bankAccount">-</div>
        <button class="text-amber-800 font-medium" onclick="copyAccount()">Salin</button>
      </div>
      <div>
        <div class="text-gray-500">Total Tagihan</div>
        <div class="text-gray-700 text-lg font-medium" id="totalBill">Rp <?php echo number_format($total, 0, ',', '.'); ?></div>
        <button class="text-amber-800 font-medium">Lihat Detail</button>
      </div>
    </div>
    <div class="flex justify-between">
      <button class="bg-amber-800 text-white py-2 px-8 rounded" onclick="goBack()">Kembali</button>
      <button class="bg-amber-800 text-white py-2 px-8 rounded">Belanja Lagi</button>
    </div>
  </main>

  <script>
    // Data yang telah diproses di server
    const bank = '<?php echo $bank; ?>';  // Nama bank yang dipilih
    const logo = '<?php echo $logo; ?>';  // URL logo bank yang dipilih
    const total = '<?php echo $total; ?>';  // Total tagihan

    // Update bank details and total payment
    function updateBankDetails() {
      const selectedBankDiv = document.getElementById('selectedBank');
      selectedBankDiv.innerHTML = `
        <div class="text-gray-700 font-medium">${bank}</div>
        <img alt="${bank} logo" height="50" src="${logo}" width="100" />
      `;

      const totalBill = document.getElementById('totalBill');
      totalBill.innerText = `Rp ${parseInt(total).toLocaleString()}`;

      const bankAccount = document.getElementById('bankAccount');
      switch (bank) {  // Pastikan nama bank yang dipilih sesuai dengan yang ada pada URL atau session
        case 'Bank BCA':
          bankAccount.innerText = '8798648646851';
          break;
        case 'Bank Mandiri':
          bankAccount.innerText = '4645184688';
          break;
        case 'Bank BRI':
          bankAccount.innerText = '315684864';
          break;
        case 'Bank BNI':
          bankAccount.innerText = '64168516884';
          break;
        default:
          bankAccount.innerText = 'Nomor rekening tidak ditemukan';
      }
    }

    // Countdown Timer
    function startCountdown() {
      const now = new Date();
      const deadline = new Date(now.getTime() + 2 * 24 * 60 * 60 * 1000); // 2 days from now

      document.getElementById('payment-deadline').innerText = deadline.toLocaleString();

      const countdown = document.getElementById('countdown');
      const timer = setInterval(() => {
        const currentTime = new Date();
        const timeRemaining = deadline - currentTime;

        if (timeRemaining <= 0) {
          clearInterval(timer);
          countdown.innerText = '00:00:00';
          alert('Batas waktu pembayaran telah habis!');
          return;
        }

        const hours = Math.floor((timeRemaining / (1000 * 60 * 60)) % 24);
        const minutes = Math.floor((timeRemaining / (1000 * 60)) % 60);
        const seconds = Math.floor((timeRemaining / 1000) % 60);

        countdown.innerText = `${hours.toString().padStart(2, '0')}:${minutes
          .toString()
          .padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
      }, 1000);
    }

    // Copy Account Number
    function copyAccount() {
      const accountNumber = document.getElementById('bankAccount').innerText;
      navigator.clipboard.writeText(accountNumber).then(() => {
        alert('Nomor rekening berhasil disalin!');
      });
    }

    // Go Back
    function goBack() {
      window.history.back();
    }

    // Initialize page
    window.onload = () => {
      updateBankDetails();
      startCountdown();
    };
  </script>
</body>
</html>
