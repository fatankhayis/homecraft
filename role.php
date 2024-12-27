<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Role HomeCraft</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        /* General Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            line-height: 1.6;
            background-color: #fdfdfd;
            color: #333;
        }

        /* Header */
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #a0522d;
            color: white;
            padding: 1rem 2rem;
            font-family: Arial, Helvetica, sans-serif;
        }

        header .logo {
            font-size: 1.5rem;
            font-weight: bold;
        }

        header nav ul {
            list-style: none;
            display: flex;
            gap: 1.5rem;
        }

        header nav ul li a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        header nav ul li a:hover {
            color: #ffd8c0;
        }

        .auth-buttons button {
            background-color: white;
            color: #a0522d;
            border: none;
            border-radius: 5px;
            padding: 0.5rem 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .auth-buttons button:hover {
            background-color: #ffd8c0;
            color: #333;
        }

        /* Hero Section */
        .hero {
            text-align: center;
            padding: 3rem 1rem;
            background: linear-gradient(to bottom right, #A0522D, bisque);
            color: white;
        }

        .hero h1 {
            font-size: 2.5rem;
        }

        .hero p {
            margin: 1rem auto 2rem;
            max-width: 600px;
            color: black;
        }

        .role-cards {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 2rem;
            margin-top: 2rem;
        }

        .role-card {
            background: white;
            border: 1px solid #ddd;
            border-radius: 10px;
            text-align: center;
            padding: 1.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            width: 100%;
            max-width: 300px;
        }

        .role-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
        }

        .role-card .icon {
            font-size: 4rem;
            color: #a0522d;
            margin-bottom: 1.5rem;
        }

        .role-card button {
            background-color: #a0522d;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 0.7rem 1.5rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .role-card button:hover {
            background-color: bisque;
            color: #333;
        }

        /* Footer */
        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 1.5rem 0;
        }

        footer nav ul {
            display: flex;
            justify-content: center;
            list-style: none;
            gap: 1.5rem;
        }

        footer nav ul li a {
            color: white;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .social-media a {
            color: white;
            margin: 0 0.5rem;
            transition: color 0.3s ease;
        }

        .social-media a:hover {
            color: #ffbb93;
        }

        /* Responsive */
        @media (max-width: 768px) {
            header {
                flex-direction: column;
                gap: 1rem;
            }

            .role-cards {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="logo">HOMECRAFT</div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <h1>Selamat Datang di Aplikasi HomeCraft</h1>
        <p>Anda bisa memilih ingin menjadi apa didalam aplikasi ini!!!</p>
        <div class="role-cards">
            <div class="role-card">
                <div class="icon"><i class="bi bi-cart4"></i></div>
                <h2>Saya Ingin Menjual</h2>
                <p>Mulai menjual furniture anda dan jangkau lebih banyak pelanggan lagi!!.</p>
                <button onclick="window.location.href='daftarseller.php'">Mulai Menjual</button>
            </div>
            <div class="role-card">
                <div class="icon"><i class="bi bi-bag-fill"></i></div>
                <h2>Saya Ingin Membeli</h2>
                <p>Temukan furniture yang anda inginkan di aplikasi ini, Selamat Berbelanja!!</p>
                <button onclick="window.location.href='daftar.php'">Mulai Berbelanja</button>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <nav>
            <ul>
                <li><a href="#">Kebijakan Privasi</a></li>
                <li><a href="#">Syarat dan Ketentuan</a></li>
                <li><a href="#">Blog</a></li>
            </ul>
        </nav>
        <div class="social-media">
            <a href="#">Facebook</a>
            <a href="#">Twitter</a>
            <a href="#">Instagram</a>
        </div>
    </footer>
</body>
</html>
