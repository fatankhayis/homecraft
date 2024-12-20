<?php
session_start();

// Simpan total pembayaran di session
if (isset($_POST['total'])) {
    $_SESSION['total_payment'] = $_POST['total'];
    echo "Total updated successfully!";
} else {
    echo "No total received!";
}
?>
