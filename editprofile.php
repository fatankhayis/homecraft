<?php
// Mulai sesi
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// Sertakan file koneksi database
require_once 'db_connection.php';

// Ambil ID pengguna dari sesi
$user_id = $_SESSION['username'];

// Jika formulir disubmit, proses pembaruan data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $address = $_POST['location'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $tanggallahir = $_POST['tanggallahir'];
    $jeniskelamin = $_POST['jeniskelamin'];

    // Validasi username unik
    $sql_check = "SELECT username FROM users WHERE username = ? AND username != ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("ss", $username, $user_id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        $error_message = "Username sudah digunakan oleh pengguna lain!";
    } else {
        // Update data di database
        $sql = "UPDATE users SET username = ?, location = ?, phone = ?, email = ?, tanggallahir = ?, jeniskelamin = ? WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssss", $username, $address, $phone, $email, $tanggallahir, $jeniskelamin, $user_id);

        if ($stmt->execute()) {
            // Perbarui sesi dengan username baru
            $_SESSION['username'] = $username;
            header("Location: profilesaya.php");
            exit();
        } else {
            $error_message = "Gagal memperbarui data. Silakan coba lagi.";
        }
        $stmt->close();
    }
    $stmt_check->close();
}

// Ambil data pengguna dari database untuk ditampilkan di formulir
$sql = "SELECT username, location, phone, email, tanggallahir, jeniskelamin FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user_data = $result->fetch_assoc();
} else {
    echo "Data pengguna tidak ditemukan!";
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
    <title>Edit Profil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Times New Roman', serif;
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
        .form-container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
        }
        .form-container h2 {
            margin-bottom: 20px;
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            font-weight: bold;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        .btn-submit {
            background-color: #4682B4;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }
        .btn-submit:hover {
            background-color: #2C6A94;
        }
        .btn-back {
            margin-top: 10px;
            background-color: bisque;
            color: black;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }
        .btn-back:hover {
            background-color: #8B4513;
            color: white;
        }
        .error-message {
            color: red;
            font-size: 14px;
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Edit Profil</h2>
        <?php if (isset($error_message)): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <form action="editprofile.php" method="POST">
            <div class="form-group">
                <label for="username">Nama</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user_data['username']); ?>" required>
            </div>
            <div class="form-group">
                <label for="address">Alamat</label>
                <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($user_data['location']); ?>" required>
            </div>
            <div class="form-group">
                <label for="phone">Nomor Handphone</label>
                <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($user_data['phone']); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user_data['email']); ?>" required>
            </div>
            <div class="form-group">
                <label for="tanggallahir">Tanggal Lahir</label>
                <input type="date" id="tanggallahir" name="tanggallahir" value="<?php echo htmlspecialchars($user_data['tanggallahir']); ?>" required>
            </div>
            <div class="form-group">
                <label for="jeniskelamin">Jenis Kelamin</label>
                <select id="jeniskelamin" name="jeniskelamin" required>
                    <option value="L" <?php echo $user_data['jeniskelamin'] == 'L' ? 'selected' : ''; ?>>Laki-Laki</option>
                    <option value="P" <?php echo $user_data['jeniskelamin'] == 'P' ? 'selected' : ''; ?>>Perempuan</option>
                </select>
            </div>
            <button type="submit" class="btn-submit">Simpan Perubahan</button>
            <button type="button" class="btn-back" onclick="window.location.href='profilesaya.php';">Kembali</button>
        </form>
    </div>
</body>
</html>
