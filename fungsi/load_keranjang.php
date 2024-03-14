<?php
// Sambungkan ke database
include '../config.php';
$nomor = $_GET['nomor'];
$namapemain = $_GET['namapemain'];
// Ambil data keranjang
$sql = "SELECT k.id_keranjang, m.nama, m.harga, k.jumlah
        FROM keranjang k
        JOIN minuman m ON k.id_barang = m.nama
        WHERE k.meja = $nomor AND k.player = '$namapemain';";

$result = $db->query($sql);

// Mengonversi hasil query ke dalam format JSON
$rows = array();
while ($row = $result->fetch_assoc()) {
    $rows[] = $row;
}

// Menutup koneksi database
$db->close();

// Mengirim data dalam format JSON
header('Content-Type: application/json');
echo json_encode($rows);
?>
