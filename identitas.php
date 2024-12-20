<?php
// Mulai sesi untuk menyimpan data
session_start();

// Inisialisasi variabel
$name = $address = $phone = $email = $tanggallahir = $jeniskelamin = "";

// Cek jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitasi dan validasi input
    $name = htmlspecialchars($_POST['name']);
    $address = htmlspecialchars($_POST['address']);
    $phone = htmlspecialchars($_POST['phone']);
    $email = htmlspecialchars($_POST['email']);
    $tanggallahir = $_POST['tanggallahir'];
    $jeniskelamin = $_POST['jeniskelamin'];

    // Simpan data ke sesi
    $_SESSION['name'] = $name;
    $_SESSION['address'] = $address;
    $_SESSION['phone'] = $phone;
    $_SESSION['email'] = $email;
    $_SESSION['tanggallahir'] = $tanggallahir;
    $_SESSION['jeniskelamin'] = $jeniskelamin;

    echo "Data berhasil disimpan dalam sesi!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SpaceWood - Identitas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
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
            margin-right:90px;
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
        .profile-card p {
            color: #888;
            font-size: 16px;
            margin-bottom: 20px;
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
        .profile-card .form-group {
            margin-bottom: 15px;
        }
        .profile-card input {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
            background-color: #f8f8f8;
        }
        .profile-card button {
            width: 100%;
            background-color: bisque;
            border: none;
            padding: 12px;
            font-size: 16px;
            border-radius: 20px;
            cursor: pointer;
        }
        .profile-card button:hover {
            background-color: #8B4513;
            color: white;
        }
        /* Gender radio button styles */
        .profile-card .gender-radio input {
            appearance: none;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: 2px solid #ccc;
            background-color: #fff;
            position: relative;
            cursor: pointer;
            margin-right: 10px;
        }
        .profile-card .gender-radio input:checked {
            background-color: #f0d9b5;
            border-color: #8B4513;
        }
        .profile-card .gender-radio input:checked::after {
            content: "";
            position: absolute;
            top: 5px;
            left: 5px;
            width: 10px;
            height: 10px;
            background-color: #6F4F37;
            border-radius: 50%;
        }
        /* Responsive styling */
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
            <div style="display: flex; align-items: center; justify-content: flex-start;">
                <img src="./assets/profile.jpg" alt="Aldorandy Septian">
                <h2>Aldorandy Septian</h2>
            </div>
            <button class="back-button" onclick="window.location.href='index.php';">Kembali</button>    
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-group">
                    <label for="name">Nama</label>
                    <input type="text" id="name" name="name" placeholder="Masukkan Nama" value="<?php echo isset($_SESSION['name']) ? $_SESSION['name'] : ''; ?>" required>
                </div>
                <div class="form-group">
                    <label for="address">Alamat</label>
                    <input type="text" id="address" name="address" placeholder="Masukkan Alamat" value="<?php echo isset($_SESSION['address']) ? $_SESSION['address'] : ''; ?>" required>
                </div>
                <div class="form-group">
                    <label for="phone">Nomor Handphone</label>
                    <input type="text" id="phone" name="phone" placeholder="Masukkan Nomor Handphone" value="<?php echo isset($_SESSION['phone']) ? $_SESSION['phone'] : ''; ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Masukkan Email" value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>" required>
                </div>
                <div class="mb-1 row">
                    <div class="col-2">
                        <label for="tanggallahir" class="col-form-label">Tanggal Lahir</label>
                    </div>
                    <div class="col-auto">
                        <input type="date" class="form-control" id="tanggallahir" name="tanggallahir" value="<?php echo isset($_SESSION['tanggallahir']) ? $_SESSION['tanggallahir'] : ''; ?>" required>
                    </div>
                </div>
                <div class="mb-1 row">
                    <div class="col-2">
                        <label for="jeniskelamin" class="col-form-label">Jenis Kelamin</label>
                    </div>
                    <div class="col-auto gender-radio">
                        <input class="form-check-input" type="radio" name="jeniskelamin" id="jeniskelaminL" value="L" <?php echo (isset($_SESSION['jeniskelamin']) && $_SESSION['jeniskelamin'] == 'L') ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="jeniskelaminL">Laki-Laki</label>
                        <input class="form-check-input" type="radio" name="jeniskelamin" id="jeniskelaminP" value="P" <?php echo (isset($_SESSION['jeniskelamin']) && $_SESSION['jeniskelamin'] == 'P') ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="jeniskelaminP">Perempuan</label>
                    </div>
                </div>
                <button type="submit">Simpan Pembaruan</button>
            </form>
        </div>
    </div>

</body>
</html>
