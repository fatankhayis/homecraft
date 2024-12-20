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
            // Insert ke tabel users dengan role default 'user'
            $insert_query = "INSERT INTO users (username, password, role) VALUES (?, ?, 'user')";
            $stmt = $conn->prepare($insert_query);
            $stmt->bind_param("ss", $username, $hashed_password);

            if ($stmt->execute()) {
                $success = "Akun berhasil didaftarkan!";
                // Redirect ke halaman login setelah alert
                echo "<script type='text/javascript'>alert('$success'); window.location.href='index.php';</script>";
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
    <title>HomeCraft - Daftar</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"/>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
        .animate-fadeIn {
            animation: fadeIn 2.5s ease-in-out;
        }
        @keyframes fadeIn {
            0% { opacity: 0; transform: scale(0.8); }
            100% { opacity: 1; transform: scale(1); }
        }
    </style>
</head>
<body class="bg-white flex items-center justify-center min-h-screen">
    <div class="flex flex-col md:flex-row items-center md:items-start w-full max-w-4xl p-4">
        <!-- Logo Section -->
        <div class="w-full md:w-1/2 flex justify-center items-center bg-white p-6">
            <img src="./assets/logohomecraft.jpg" alt="HomeCraft Logo"
                 class="animate-fadeIn" width="700" height="700"/>
        </div>

        <!-- Form Register Section -->
        <div class="w-full md:w-1/2 bg-[#b26a3d] p-6 rounded-lg shadow-lg">
            <h2 class="text-center text-2xl font-bold text-white mb-4">Daftar Akun</h2>
            <form method="POST" action="">
                <div class="mb-3">
                    <label class="block text-white mb-1" for="username">Username</label>
                    <input class="w-full p-2 rounded-lg border border-gray-300" id="username" name="username" type="text" placeholder="Masukkan username" required/>
                </div>
                <div class="mb-3">
                    <label class="block text-white mb-1" for="password">Password</label>
                    <input class="w-full p-2 rounded-lg border border-gray-300" id="password" name="password" type="password" placeholder="Masukkan password" required/>
                </div>
                <div class="mb-4">
                    <label class="block text-white mb-1" for="confirm_password">Konfirmasi Password</label>
                    <input class="w-full p-2 rounded-lg border border-gray-300" id="confirm_password" name="confirm_password" type="password" placeholder="Konfirmasi password" required/>
                </div>
                <div class="mb-4">
                    <button class="w-full bg-[#f0c27b] text-[#6b4226] p-2 rounded-lg font-bold" type="submit">Daftar</button>
                </div>
                <div class="text-center text-white mb-4">
                    atau daftar dengan
                </div>
                <!-- Google and Facebook Buttons -->
                <div class="mb-4 flex justify-between space-x-4">
                    <button class="w-1/2 bg-white text-[#6b4226] p-2 rounded-lg font-bold flex items-center justify-center shadow-md">
                        <i class="fab fa-google text-red-500 mr-2"></i> Google
                    </button>
                    <button class="w-1/2 bg-white text-[#6b4226] p-2 rounded-lg font-bold flex items-center justify-center shadow-md">
                        <i class="fab fa-facebook text-blue-600 mr-2"></i> Facebook
                    </button>
                </div>
                <p class="text-center text-white text-sm">
                    Sudah punya akun? <a href="index.php" class="underline">Login di sini</a>.
                </p>
                <?php if (!empty($error)): ?>
                    <div class="text-red-500 text-center mt-4"><?php echo $error; ?></div>
                <?php endif; ?>
            </form>
        </div>
    </div>
</body>
</html>
