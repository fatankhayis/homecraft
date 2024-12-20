<?php
session_start();

// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$database = "homecraft";
$conn = new mysqli($servername, $username, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Variabel untuk pesan error
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil username dan password dari form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query untuk mencari username dalam database
    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Cek apakah username ditemukan
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            // Jika login berhasil, set session
            $_SESSION['seller_id'] = $user['id']; // Simpan ID user untuk digunakan di halaman lain
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Periksa role
            if ($user['role'] === 'seller') {
                // Jika role adalah seller, redirect ke halaman produkseller.php
                header("Location: berandaseller.php");
                exit();
            } else {
                // Jika bukan seller, tampilkan error
                $error = "Akses ditolak! Anda bukan seller.";
            }
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Username tidak ditemukan!";
    }
}

// Tutup koneksi
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SpaceWood Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"/>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }

        /* Keyframes for fadeIn animation */
        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: scale(0.8);
            }
            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* Adding animation to the logo */
        .animate-fadeIn {
            animation: fadeIn 2.5s ease-in-out;
        }
    </style>
</head>
<body class="bg-white flex items-center justify-center min-h-screen">
    <div class="flex flex-col md:flex-row items-center md:items-start w-full max-w-5xl">
        <!-- Logo Section -->
        <div class="w-full md:w-1/2 flex justify-center items-center bg-white p-6">
            <img src="./assets/logohomecraft.jpg" alt="SpaceWood logo with a tree ring and house" 
                 class="animate-fadeIn" width="500" height="500"/>
        </div>

        <!-- Form Login -->
        <div class="bg-[#b26a3d] p-8 rounded-lg shadow-lg">
            <h2 class="text-center text-2xl font-bold text-white mb-6">WELCOME TO HOMECRAFT</h2>
            <form method="POST" action="">
                <div class="mb-4">
                    <label class="block text-white mb-2" for="username">Username</label>
                    <input class="w-full p-3 rounded-lg border border-gray-300" id="username" name="username" type="text" required/>
                </div>
                <div class="mb-6">
                    <label class="block text-white mb-2" for="password">Password</label>
                    <input class="w-full p-3 rounded-lg border border-gray-300" id="password" name="password" type="password" required/>
                </div>
                <div class="mb-4">
                    <button class="w-full bg-[#f0c27b] text-[#6b4226] p-3 rounded-lg font-bold" type="submit">Login</button>
                </div>
                <?php if ($error): ?>
                    <div class="text-red-500 text-center mt-4"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>
            </form>
        </div>
    </div>
</body>
</html>
