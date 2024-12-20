<?php
// Tentukan folder untuk menyimpan gambar
$targetDir = "foto produk/";
$targetFile = $targetDir . basename($_FILES["file"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

// Cek apakah file adalah gambar
if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["file"]["tmp_name"]);
    if ($check !== false) {
        echo "File adalah gambar - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File bukan gambar.";
        $uploadOk = 0;
    }
}

// Cek jika file sudah ada
if (file_exists($targetFile)) {
    echo "Maaf, file sudah ada.";
    $uploadOk = 0;
}

// Cek ukuran file
if ($_FILES["file"]["size"] > 500000) { // 500 KB batas maksimum
    echo "Maaf, ukuran file terlalu besar.";
    $uploadOk = 0;
}

// Izinkan jenis file tertentu
if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
    echo "Maaf, hanya file JPG, JPEG, PNG & GIF yang diizinkan.";
    $uploadOk = 0;
}

// Cek jika $uploadOk diatur ke 0 oleh kesalahan
if ($uploadOk == 0) {
    echo "Maaf, file tidak diunggah.";
// Jika semuanya baik-baik saja, coba unggah file
} else {
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
        echo "File ". htmlspecialchars(basename($_FILES["file"]["name"])) . " telah diunggah.";
    } else {
        echo "Maaf, terjadi kesalahan saat mengunggah file.";
    }
}
?>