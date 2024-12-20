<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <!-- Header -->
    <header class="bg-[#b46932] p-4 flex justify-between items-center">
        <div class="text-white font-bold text-lg">HomeCraft</div>
        <div class="relative">
            <input type="text" placeholder="Pencarian" class="p-2 rounded-full" />
            <i class="fas fa-search absolute right-3 top-3 text-gray-500"></i>
        </div>
        <div class="flex items-center">
            <div class="w-8 h-8 rounded-full bg-gray-300"></div>
            <span class="ml-2 text-white">nama</span>
        </div>
    </header>

    <!-- Main Content -->
    <main class="p-8">
        <!-- Payment Title -->
        <div class="text-gray-700 mb-4">
            <i class="fas fa-lock"></i>
            <span class="ml-2">Selesaikan Pembayaran</span>
        </div>

        <!-- Payment Timer -->
        <div class="text-center mb-8">
            <h2 class="text-lg font-medium">Selesaikan Pembayaran Dalam</h2>
            <div id="countdown-timer" class="text-red-600 text-2xl font-bold my-2">21:58:31</div>
            <div class="text-gray-500">Batas Akhir Pembayaran</div>
            <div id="payment-deadline" class="text-gray-700 font-medium"></div>
        </div>

        <!-- Payment Details -->
        <div class="border rounded-lg p-4 mb-8">
            <div class="flex justify-between items-center mb-4">
                <div class="text-gray-700 font-medium">Mandiri account</div>
                <img src="./assets/mandiri.jpeg" alt="Mandiri logo" width="100" height="50" />
            </div>
            <hr>
            <div class="mb-4">
                <div class="text-gray-500">Nomor Rekening Pembayaran</div>
                <div class="text-gray-700 text-lg font-medium">5794795721776</div>
                <button class="text-[#b46932] font-medium">Salin</button>
            </div>
            <div>
    <div class="text-gray-500">Total Tagihan</div>
    <div id="total-payment" class="text-gray-700 text-lg font-medium">Rp 0</div>
</div>
                <button class="text-[#b46932] font-medium">Lihat Detail</button>
            </div>
        </div>

        <!-- Buttons -->
        <div class="flex justify-between">
            <button class="bg-[#b46932] text-white py-2 px-8 rounded">Kembali</button>
            <button class="bg-[#b46932] text-white py-2 px-8 rounded">Belanja Lagi</button>
        </div>
    </main>

    <!-- JavaScript for Real-Time Countdown -->
    <script>
        // Set the payment deadline (24 hours from now)
        const paymentDeadline = new Date();
        paymentDeadline.setHours(paymentDeadline.getHours() + 24);

        // Format deadline date and display it
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' };
        document.getElementById('payment-deadline').textContent = paymentDeadline.toLocaleDateString('id-ID', options);

        function updateCountdown() {
            const now = new Date();
            const timeRemaining = paymentDeadline - now;

            if (timeRemaining < 0) {
                document.getElementById('countdown-timer').textContent = "Waktu Habis";
                return;
            }

            const hours = String(Math.floor((timeRemaining / (1000 * 60 * 60)) % 24)).padStart(2, '0');
            const minutes = String(Math.floor((timeRemaining / (1000 * 60)) % 60)).padStart(2, '0');
            const seconds = String(Math.floor((timeRemaining / 1000) % 60)).padStart(2, '0');

            document.getElementById('countdown-timer').textContent = `${hours}:${minutes}:${seconds}`;
        }

        // Update the countdown every second
        setInterval(updateCountdown, 1000);

        // Initial call to display the countdown immediately
        updateCountdown();

        // Ambil total pembayaran dari server saat halaman dimuat
    function fetchTotalFromServer() {
        const xhr = new XMLHttpRequest();
        xhr.open("GET", "fetch_total.php", true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                const total = xhr.responseText; // Total dari server
                document.getElementById('total-payment').innerText = `Rp ${parseInt(total).toLocaleString()}`;
            }
        };
        xhr.send();
    }

    // Panggil fungsi saat halaman dimuat
    fetchTotalFromServer();
    </script>
</body>
</html>
