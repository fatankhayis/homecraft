<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title>SPACEWOOD Seller Centre</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&amp;display=swap" rel="stylesheet"/>
  <style>
    body {
      font-family: 'Roboto', sans-serif;
    }
    .hover-bisque:hover {
      background-color: bisque;
    }
  </style>
</head>
<body class="bg-gray-100">
  <header class="bg-brown-600 text-white p-4 flex justify-between items-center" style="background-color: #8B4513;">
    <div class="text-lg font-semibold">SPACEWOOD Seller Centre</div>
    <div class="flex items-center space-x-4">
      <div class="flex items-center space-x-2">
        <img src="https://storage.googleapis.com/a1aa/image/ZS0OniuKrjofFqHZzqoIx50gWB7j7ZHyOU9a2K4JyDIF637JA.jpg" alt="User profile picture" class="rounded-full w-10 h-10" height="40" width="40"/>
        <span>nama.id</span>
      </div>
      <i class="fas fa-th-large"></i>
      <i class="fas fa-bell"></i>
      <button class="px-4 py-2 rounded text-white hover-bisque" style="background-color: #8B4513;">Kembali ke Akun Pembeli</button>
    </div>
  </header>

  <div class="flex">
    <aside class="bg-white w-64 p-4">
      <nav class="space-y-4">
        <div>
          <h2 class="font-semibold mb-2 text-brown-600">
            <i class="fas fa-shopping-cart mr-2 text-brown-600"></i>Pesanan
          </h2>
          <ul class="space-y-1">
            <li><a href="#" class="block hover-bisque p-2 rounded">Pesanan Saya</a></li>
            <li><a href="#" class="block hover-bisque p-2 rounded">Kirimkan Pesanan</a></li>
          </ul>
        </div>
        <div>
          <h2 class="font-semibold mb-2 text-brown-600">
            <i class="fas fa-box mr-2 text-brown-600"></i>Produk
          </h2>
          <ul class="space-y-1">
            <li><a href="produkseller.php" class="block hover-bisque p-2 rounded">Produk Saya</a></li>
            <li><a href="add_product.php" class="block hover-bisque p-2 rounded">Tambah Produk Baru</a></li>
            <li><a href="#" class="block hover-bisque p-2 rounded">Pelanggaran Saya</a></li>
          </ul>
        </div>
        <div>
          <h2 class="font-semibold mb-2 text-brown-600">
            <i class="fas fa-wallet mr-2 text-brown-600"></i>Keuangan
          </h2>
          <ul class="space-y-1">
            <li><a href="#" class="block hover-bisque p-2 rounded">Penghasilan Saya</a></li>
            <li><a href="#" class="block hover-bisque p-2 rounded">Saldo Saya</a></li>
            <li><a href="#" class="block hover-bisque p-2 rounded">Rekening Saya</a></li>
          </ul>
        </div>
        <div>
          <h2 class="font-semibold mb-2 text-brown-600">
            <i class="fas fa-store mr-2 text-brown-600"></i>Data Toko Saya
          </h2>
          <ul class="space-y-1">
            <li><a href="#" class="block hover-bisque p-2 rounded">Data Toko Saya</a></li>
          </ul>
        </div>
        <div>
          <h2 class="font-semibold mb-2 text-brown-600">
            <i class="fas fa-tools mr-2 text-brown-600"></i>Toko
          </h2>
          <ul class="space-y-1">
            <li><a href="#" class="block hover-bisque p-2 rounded">Dekorasi Toko</a></li>
            <li><a href="#" class="block hover-bisque p-2 rounded">Pengaturan Toko</a></li>
          </ul>
        </div>
      </nav>
    </aside>

    <div class="w-3/4 p-4 space-y-4">
      <div class="grid grid-cols-2 gap-4">
        <div class="bg-white p-4 shadow rounded">
          <h3 class="font-bold">Data Toko Saya <span class="text-gray-500">(waktu terakhir update 15:20)</span></h3>
          <p class="text-gray-500">Lihat tinjauan perkembangan toko</p>
          <div class="mt-4">
            <p class="font-bold text-xl">Penjualan</p>
            <p class="text-2xl">Rp 12.560.877,99</p>
            <img alt="Graph showing sales data" class="mt-4" height="150" src="https://storage.googleapis.com/a1aa/image/68gAG7sv6EqeWalJayRwrglNj42OaojN3349HVLbExIQoY6JA.jpg" width="300"/>
          </div>
          <div class="grid grid-cols-2 gap-4 mt-4">
            <div>
              <p class="font-bold text-xl">Total Pengunjung</p>
              <p class="text-2xl">4454</p>
            </div>
            <div>
              <p class="font-bold text-xl">Produk Dilihat</p>
              <p class="text-2xl">18565</p>
            </div>
            <div>
              <p class="font-bold text-xl">Pesanan</p>
              <p class="text-2xl">2000</p>
            </div>
            <div>
              <p class="font-bold text-xl">Tingkat Keuntungan</p>
              <p class="text-2xl">50.7%</p>
            </div>
          </div>
        </div>
        <div class="bg-white p-4 shadow rounded ml-6">
          <h3 class="font-bold">Yang Perlu Dilakukan</h3>
          <p class="text-gray-500">Hal-Hal Yang Harus Kamu Dilakukan</p>
          <div class="grid grid-cols-2 gap-4 mt-4">
            <div>
              <p class="font-bold text-2xl">596</p>
              <p class="text-gray-500">Perlu Dikirim</p>
            </div>
            <div>
              <p class="font-bold text-2xl">596</p>
              <p class="text-gray-500">Menunggu Konfirmasi Pembayaran</p>
            </div>
            <div>
              <p class="font-bold text-2xl">5</p>
              <p class="text-gray-500">Menunggu Pesan Diterima</p>
            </div>
            <div>
              <p class="font-bold text-2xl">3</p>
              <p class="text-gray-500">Produk Stok Habis</p>
            </div>
          </div>
        </div>

      <div class="grid grid-cols-2 gap-4">
        <div class="bg-white p-4 shadow rounded">
          <h3 class="font-bold">Produk Saya</h3>
          <p class="text-gray-500">Lihat tinjauan perkembangan toko</p>
          <div class="grid grid-cols-3 gap-4 mt-4">
            <img alt="Product image 1" height="100" src="./assets/mejapendek.jpg" width="100"/>
            <img alt="Product image 2" height="100" src="./assets/lemari-1.jpg" width="100"/>
            <img alt="Product image 3" height="100" src="./assets/lampu.jpg" width="100"/>
          </div>
        </div>
        <div class="bg-white p-4 shadow rounded">
          <h3 class="font-bold">Pesan</h3>
          <p class="text-gray-500">Notifikasi penjual</p>
          <p class="mt-4 text-gray-700">
            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Recusandae sit sequi quas obcaecati autem aut nulla adipisci aperiam molestiae distinctio perspiciatis corporis, quod iusto, impedit dolore, maiores illo nisi unde.
          </p>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
