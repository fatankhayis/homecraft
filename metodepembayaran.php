<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Metode Pembayaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
    <style>
        /* Styling sama seperti sebelumnya */
        body { font-family: Arial, sans-serif; background-color: #fff; margin: 0; padding: 0; }
        .header { background-color: #b87333; padding: 10px 20px; display: flex; justify-content: space-between; align-items: center; }
        .header .logo { font-size: 24px; font-weight: bold; color: #fff; }
        .header .search-bar { display: flex; align-items: center; flex-grow: 1; margin: 0 20px; }
        .header .search-bar input { flex-grow: 1; padding: 5px; font-size: 16px; border: 1px solid #ccc; border-radius: 4px; }
        .header .search-bar button { background: none; border: none; cursor: pointer; margin-left: 5px; }
        .header .profile { display: flex; align-items: center; }
        .header .profile img { border-radius: 50%; width: 40px; height: 40px; margin-right: 10px; }
        .header .profile span { color: #fff; }
        .container { padding: 20px; }
        .payment-method { border: 1px solid #000; padding: 20px; border-radius: 4px; }
        .payment-option { margin-bottom: 20px; }
        .bank-list { list-style: none; padding: 0; margin: 0; display: none; }
        .bank-list li { display: flex; align-items: center; margin-bottom: 10px; cursor: pointer; }
        .bank-list li img { width: 50px; height: auto; margin-right: 10px; border-radius: 4px; }
        .confirm-button { background-color: #b87333; color: #fff; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; width: 100%; text-align: center; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">HOMECRAFT</div>
        <div class="search-bar">
            <input type="text" placeholder="Pencarian" />
            <button>
                <i class="bi bi-house-door"></i>
            </button>
        </div>
        <div class="profile">
            <img src="./assets/profile.jpg" alt="Profile picture" />
            <span>Aldorandy</span>
        </div>
    </div>

    <div class="container">
        <h1>Metode Pembayaran</h1>
        <div class="payment-method">
            <div class="payment-option">
                <div class="dropdown" onclick="toggleBankList()">
                    <span><i class="bi bi-bank"></i> Transfer Bank</span>
                    <i class="bi bi-chevron-down"></i>
                </div>
                <ul class="bank-list">
                    <li onclick="selectBank('Bank Mandiri')">
                        <img src="./assets/MANDIRI.jpg" alt="Mandiri logo" />
                        <span>Bank Mandiri</span>
                    </li>
                    <li onclick="selectBank('Bank BRI')">
                        <img src="./assets/BRI.jpg" alt="BRI logo" />
                        <span>Bank Rakyat Indonesia</span>
                    </li>
                    <li onclick="selectBank('Bank BCA')">
                        <img src="./assets/BCA.jpg" alt="BCA logo" />
                        <span>Bank Central Asia</span>
                    </li>
                    <li onclick="selectBank('Bank BNI')">
                        <img src="./assets/BNI.jpg" alt="BNI logo" />
                        <span>Bank BNI</span>
                    </li>
                </ul>
            </div>
            <p id="selected-bank" class="mt-3"></p>
            <button class="confirm-button" onclick="redirectToPaymentPage()">Konfirmasi Metode Pembayaran</button>
        </div>
    </div>

    <script>
        let selectedBank = '';

        function toggleBankList() {
            const bankList = document.querySelector('.bank-list');
            bankList.style.display = (bankList.style.display === 'none' || bankList.style.display === '') 
                ? 'block' 
                : 'none';
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
            const url = `halamanpembayaran.php?bank=${encodeURIComponent(selectedBank)}`;
            window.location.href = url;
        }
    </script>
</body>
</html>
