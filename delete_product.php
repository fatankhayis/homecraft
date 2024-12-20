<?php
require 'db_connection.php';

$id = $_GET['id'];
$sql = "DELETE FROM products WHERE id = '$id'";
if ($conn->query($sql) === TRUE) {
    header("Location: produkseller.php");
    exit;
} else {
    echo "Error: " . $conn->error;
}
?>
