<?php
include '../config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nomorMeja = $_POST['nomorMeja'];
    $sql = "SELECT * FROM waktu_meja WHERE nomor_meja = '$nomorMeja' AND bayar = 'belum'";
    $hasil = $db->query($sql);

    if ($hasil->num_rows > 0) {
        $response = array('status' => 'success');
    } else {
        $response = array('status' => 'eror');
    }
}
header('Content-Type: application/json');

// Mengirimkan respons JSON
echo json_encode($response);
