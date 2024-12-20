<?php
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

// Inisialisasi error dan success message
$error = "";
$success = "";

// Proses jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validasi input
    if (empty($username) || empty($password) || empty($confirm_password)) {
        $error = "Semua kolom harus diisi!";
    } elseif ($password !== $confirm_password) {
        $error = "Password dan konfirmasi password tidak cocok!";
    } else {
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Cek apakah username sudah ada
        $check_query = "SELECT * FROM users WHERE username = ?";
        $stmt = $conn->prepare($check_query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = "Username sudah terdaftar.";
        } else {
            // Insert ke tabel users dengan role 'seller'
            $insert_query = "INSERT INTO users (username, password, role) VALUES (?, ?, 'seller')";
            $stmt = $conn->prepare($insert_query);
            $stmt->bind_param("ss", $username, $hashed_password);

            if ($stmt->execute()) {
                $success = "Akun berhasil didaftarkan sebagai seller!";
                // Redirect ke halaman login setelah alert
                echo "<script type='text/javascript'>alert('$success'); window.location.href='indexseller.php';</script>";
                exit();
            } else {
                $error = "Terjadi kesalahan. Coba lagi.";
            }
        }
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
    <title>Daftar Seller - HomeCraft</title>
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
            <img src="./assets/logohomecraft.jpg" alt="HomeCraft Logo" 
                 class="animate-fadeIn" width="500" height="500"/>
        </div>

        <!-- Form Pendaftaran -->
        <div class="bg-[#b26a3d] p-8 rounded-lg shadow-lg w-[90%] md:w-[400px]">
            <h2 class="text-center text-2xl font-bold text-white mb-6">Daftar sebagai Seller</h2>
            <form method="POST" action="">
                <div class="mb-4">
                    <label class="block text-white mb-2" for="username">Username</label>
                    <input class="w-full p-3 rounded-lg border border-gray-300" id="username" name="username" type="text" required/>
                </div>
                <div class="mb-4">
                    <label class="block text-white mb-2" for="password">Password</label>
                    <input class="w-full p-3 rounded-lg border border-gray-300" id="password" name="password" type="password" required/>
                </div>
                <div class="mb-4">
                    <label class="block text-white mb-2" for="confirm_password">Konfirmasi Password</label>
                    <input class="w-full p-3 rounded-lg border border-gray-300" id="confirm_password" name="confirm_password" type="password" required/>
                </div>
                <div class="mb-4">
                    <button class="w-full bg-[#f0c27b] text-[#6b4226] p-3 rounded-lg font-bold" type="submit">Daftar</button>
                </div>
                <div class="text-white text-center">
                    Sudah punya akun? <a href="indexseller.php" class="underline">Login di sini</a>.
                </div>
                <?php if ($error): ?>
                    <div class="text-red-500 text-center mt-4"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>
                <?php if ($success): ?>
                    <div class="text-green-500 text-center mt-4"><?= htmlspecialchars($success) ?></div>
                <?php endif; ?>
            </form>
        </div>
    </div>
</body>
</html>
