<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Include Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Include Custom CSS -->
    <link rel="stylesheet" href="produk.css">
</head>
<body class="bg-light">

<!-- Navbar -->
<header class="bg-brown text-white p-3">
    <div class="container d-flex justify-content-between align-items-center">
        <!-- Logo -->
        <div class="fs-3 fw-bold">SPACEWOOD</div>
        <!-- Search Bar -->
        <div class="flex-grow-1 mx-4">
            <input type="text" placeholder="Pencarian" class="form-control">
        </div>
        <!-- Profile -->
        <div class="d-flex align-items-center">
            <img src="./assets/profile.jpg" alt="Profile" class="rounded-circle" width="40" height="40">
            <span class="ms-2">Aldorandy</span>
        </div>
    </div>
</header>

<!-- Detail Produk Title Section -->
<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center">
        <!-- Title -->
        <h1 class="fs-4 fw-bold">Detail Produk</h1>
        <!-- Profile Info -->
        <div class="d-flex align-items-center">
            <img src="./assets/lampu.jpg" alt="Profile" class="rounded-circle" width="40" height="40">
            <span class="fw-semibold ms-2">Toko Jaya Abadi</span>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="container">
    <div class="row g-4">
        <!-- Product Image -->
        <div class="col-lg-8">
            <img src="./assets/mejapendek.jpg" alt="Meja Tamu Pendek" class="img-fluid rounded">
        </div>

        <!-- Product Info -->
        <div class="col-lg-4">
            <h2 class="fs-4 fw-bold">Meja Tamu Pendek</h2>
            <div class="text-muted mb-3">
                <div>
                    <span class="text-warning">★★★★☆</span>
                    <span class="ms-2">4.9 | Terjual</span>
                </div>
                <div class="d-flex align-items-center mt-2">
                    <i class="bi bi-geo-alt text-warning"></i>
                    <span class="ms-2">Kota Bandung</span>
                </div>
                <p class="text-brown fs-5 fw-bold mt-3">Rp 5.000.000</p>
                <p class="text-decoration-line-through text-muted">Rp 6.000.000</p>
            </div>

            <h3 class="fs-5 fw-bold mt-4">Penjelasan produk</h3>
            <p class="text-muted">
                Meja yang didesain dengan kaki yang pendek dan panjang pada bagian atas, serta terdapat beberapa laci kecil untuk barang.
            </p>

            <h3 class="fs-5 fw-bold mt-4">Ulasan produk</h3>
            <div class="d-flex align-items-center mt-2">
                <img src="./assets/profile.jpg" alt="Aldorandy Septian" class="rounded-circle" width="30" height="30">
                <span class="ms-2 fw-semibold">Aldorandy Septian</span>
            </div>
            <p class="text-muted mt-1 mb-3"><i class="bi bi-star-fill text-warning"></i> 4.7 | 10 Terjual</p>

            <!-- Additional Images -->
            <div class="row g-2">
                <div class="col-6">
                    <img src="./assets/mejapendek.jpg" alt="Meja Tamu Pendek" class="img-fluid rounded">
                </div>
                <div class="col-6">
                    <img src="./assets/mejapendek.jpg" alt="Meja Tamu Pendek" class="img-fluid rounded">
                </div>
            </div>

            <!-- Actions -->
            <div class="d-flex mt-4 gap-3">
                <button class="btn btn-outline-primary d-flex align-items-center">
                    <i class="bi bi-chat-dots me-2"></i> Chat Penjual
                </button>
                <button class="btn btn-outline-success d-flex align-items-center">
                    <i class="bi bi-cart2 me-2"></i> Masukkan Keranjang
                </button>
                <button class="btn btn-outline-warning d-flex align-items-center">
                    <i class="bi bi-share me-2"></i> Bagikan
                </button>
            </div>
        </div>
    </div>
</div>

</body>
</html>

