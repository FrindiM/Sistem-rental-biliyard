<?php
// Gantilah dengan koneksi database sesuai kebutuhan Anda
include '../config.php';

$nama = $_POST['lampu'];

$sql = "SELECT waktu, harga FROM paket WHERE nama = '$nama'";
$result = $db->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $response = array('waktu' => $row['waktu'], 'harga' => $row['harga']);
    echo json_encode($response);
} else {
    echo "0 results";
}

$db->close();
