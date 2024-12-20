<?php
// Mulai sesi untuk mengakses data sesi
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    // Jika belum login, arahkan kembali ke halaman login
    header("Location: index.php");
    exit();
}

// Sertakan file koneksi database
require_once 'db_connection.php';

// Ambil ID pengguna dari sesi
$user_id = $_SESSION['username'];

// Ambil data pengguna dari database
$sql = "SELECT username, location, phone, email, tanggallahir, jeniskelamin FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Data pengguna ditemukan
    $user_data = $result->fetch_assoc();
} else {
    // Data pengguna tidak ditemukan
    echo "Pengguna tidak ditemukan!";
    exit();
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SpaceWood - Identitas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Gaya CSS seperti yang ada di kode sebelumnya */
        body {
            font-family: 'times new roman';
            background-color: #f5f5f5;
            background-image: url('./assets/background1.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            margin: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            display: flex;
            justify-content: flex-end;
            align-items: flex-start;
            max-width: 1800px;
            padding: 20px;
            width: 100%;
            flex-wrap: wrap;
            margin-left: 100px;
        }
        .logo {
            margin-right: 30px;
            text-align: left;
            flex-shrink: 0;
            margin-left: 100px;
        }
        .logo img {
            width: 400px;
            max-width: 100%;
            border-radius: 5px;
        }
        .profile-card {
            width: 600px;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            flex-shrink: 0;
            position: relative;
            margin-right: 90px;
        }
        .profile-card img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 15px;
        }
        .profile-card h2 {
            margin-bottom: 10px;
            font-size: 20px;
            font-weight: bold;
            margin-left: 10px;
        }
        .profile-card .profile-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #ddd; /* Garis pembatas */
        }
        .profile-card .profile-item:last-child {
            border-bottom: none; /* Hapus garis terakhir */
        }
        .profile-card .profile-item label {
            font-weight: bold;
            color: #555;
        }
        .profile-card .profile-item span {
            color: #333;
        }
        .profile-card .back-button {
            background-color: bisque;
            border: none;
            border-radius: 20px;
            padding: 5px 10px;
            font-size: 14px;
            cursor: pointer;
            position: absolute;
            top: 20px;
            right: 20px;
            width: 100px;
        }
        .profile-card .back-button:hover {
            background-color: #8B4513;
            color: white;
        }
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                align-items: center;
                padding: 10px;
            }
            .logo {
                margin-bottom: 20px;
                margin-left: 0;
            }
            .profile-card {
                width: 100%;
                margin-top: 20px;
            }
        }
    </style>
</head>
<body>

    <div class="logo">
        <img alt="SpaceWood logo with a tree ring and a house" src="./assets/logohomecraft.jpg" />
    </div>

    <div class="container">
    <div class="profile-card">
    <div>
        <h2 style="font-size: 24px; margin-bottom: 20px;">Profil Saya</h2>
    </div>
    <div style="display: flex; align-items: center; justify-content: flex-start;">
        <img src="./assets/profile.jpg" alt="<?php echo htmlspecialchars($user_data['username']); ?>">
        <h2><?php echo htmlspecialchars($user_data['username']); ?></h2>
    </div>
    <div style="display: flex; justify-content: flex-end; gap: 10px;">
        <button class="edit-button" onclick="window.location.href='editprofile.php';">Edit Profile</button>
        <button class="back-button" onclick="window.location.href='beranda.php';">Kembali</button>
    </div>

    <!-- Informasi Profil -->
    <div class="profile-item">
        <label>Nama:</label>
        <span><?php echo htmlspecialchars($user_data['username']); ?></span>
    </div>
    <div class="profile-item">
        <label>Alamat:</label>
        <span><?php echo htmlspecialchars($user_data['location']); ?></span>
    </div>
    <div class="profile-item">
        <label>Nomor Handphone:</label>
        <span><?php echo htmlspecialchars($user_data['phone']); ?></span>
    </div>
    <div class="profile-item">
        <label>Email:</label>
        <span><?php echo htmlspecialchars($user_data['email']); ?></span>
    </div>
    <div class="profile-item">
        <label>Tanggal Lahir:</label>
        <span><?php echo htmlspecialchars($user_data['tanggallahir']); ?></span>
    </div>
    <div class="profile-item">
        <label>Jenis Kelamin:</label>
        <span>
            <?php
            if (isset($user_data['jeniskelamin'])) {
                echo $user_data['jeniskelamin'] == 'L' ? 'Laki-Laki' : 'Perempuan';
            } else {
                echo '';
            }
            ?>
        </span>
    </div>
</div>