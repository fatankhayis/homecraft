<?php
session_start();

// Cek apakah total pembayaran ada di session
if (isset($_SESSION['total_payment'])) {
    echo $_SESSION['total_payment'];
} else {
    echo "0";
}
?>
