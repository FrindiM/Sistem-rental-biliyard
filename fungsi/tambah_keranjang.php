<?php
// Sambungkan ke database
include '../config.php';

// Ambil data dari AJAX
$id_barang = $_POST['id_barang'];
$jumlah = $_POST['jumlah'];
$meja = $_POST['meja'];
$namapemain = $_POST['namapemain'];

// Tambahkan barang ke keranjang
$sql = "INSERT INTO keranjang (id_barang, jumlah, meja, player) VALUES ('$id_barang', $jumlah, $meja, '$namapemain')";
$db->query($sql);

$db->close();
?>
