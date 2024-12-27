<html>
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
<body class="bg-white">
  <header class="bg-[#b46932] p-4 flex justify-between items-center">
    <div class="text-white font-bold text-lg">SPACEWOOD</div>
    <div class="relative">
      <input class="p-2 rounded-full" placeholder="Pencarian" type="text" />
      <i class="fas fa-search absolute right-3 top-3 text-gray-500"></i>
    </div>
    <div class="flex items-center">
      <div class="w-8 h-8 rounded-full bg-gray-300"></div>
      <span class="ml-2 text-white">Nama</span>
    </div>
  </header>

  <main class="p-8">
    <div class="text-gray-700 mb-4">
      <i class="fas fa-lock"></i>
      <span class="ml-2">Selesaikan Pembayaran</span>
    </div>
    <div class="text-center mb-8">
      <h2 class="text-lg font-medium">Selesaikan Pembayaran Dalam</h2>
      <div class="text-red-600 text-2xl font-bold my-2">21:58:31</div>
      <div class="text-gray-500">Batas Akhir Pembayaran</div>
      <div class="text-gray-700 font-medium">Senin, 28 Februari 2025 19:51</div>
    </div>
    <div class="border rounded-lg p-4 mb-8">
      <!-- Bagian Bank Dipilih -->
      <div id="selectedBank" class="flex justify-between items-center mb-4">
        <!-- Bank name and logo will be populated here dynamically -->
      </div>
      <hr />
      <div class="mb-4">
        <div class="text-gray-500">Nomor Rekening Pembayaran</div>
        <div class="text-gray-700 text-lg font-medium" id="bankAccount">-</div>
        <button class="text-[#b46932] font-medium" onclick="copyAccount()">Salin</button>
      </div>
      <div>
        <div class="text-gray-500">Total Tagihan</div>
        <div class="text-gray-700 text-lg font-medium" id="totalBill">Rp 431.500</div>
        <button class="text-[#b46932] font-medium">Lihat Detail</button>
      </div>
    </div>
    <div class="flex justify-between">
      <button class="bg-[#b46932] text-white py-2 px-8 rounded" onclick="goBack()">Kembali</button>
      <button class="bg-[#b46932] text-white py-2 px-8 rounded">Belanja Lagi</button>
    </div>
  </main>

  <script>
    // Function to parse query parameters
    function getQueryParams() {
      const params = new URLSearchParams(window.location.search);
      return {
        bank: params.get('bank') || 'Tidak ada bank yang dipilih',
        logo: params.get('logo') || ''
      };
    }

    // Function to dynamically update selected bank
    function updateBankDetails() {
      const { bank, logo } = getQueryParams();

      // Update bank name and logo
      const selectedBankDiv = document.getElementById('selectedBank');
      selectedBankDiv.innerHTML = `
        <div class="text-gray-700 font-medium">${bank}</div>
        <img alt="${bank} logo" height="50" src="${logo}" width="100" />
      `;

      // Example: Update account number and total dynamically (optional)
      const bankAccount = document.getElementById('bankAccount');
      bankAccount.innerText = '5794795721776'; // Customize based on bank

      const totalBill = document.getElementById('totalBill');
      totalBill.innerText = 'Rp 431.500'; // Customize dynamically if needed
    }

    // Function to copy account number
    function copyAccount() {
      const accountNumber = document.getElementById('bankAccount').innerText;
      navigator.clipboard.writeText(accountNumber).then(() => {
        alert('Nomor rekening berhasil disalin!');
      });
    }

    // Function to go back to previous page
    function goBack() {
      window.history.back();
    }

    // Initialize page with bank details
    window.onload = updateBankDetails;
  </script>
</body>
</html>
