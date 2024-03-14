<?php
// Gantilah dengan koneksi database sesuai kebutuhan Anda
include '../config.php';

$nama = $_POST['selectednama'];
$nomor = $_POST['nilainomor'];


$sql = "SELECT * FROM waktu_meja WHERE nomor_meja = '$nomor' AND nama = '$nama' AND bayar = 'belum'";
$result = $db->query($sql);

if ($result !== false) {
    $response = array();

    while ($row = $result->fetch_assoc()) {
        $response[] = $row;
    }

    if (!empty($response)) {
        echo json_encode($response);
    } else {
        $response = array('info' => 'Tidak ada hasil');
        echo json_encode($response);
    }
} else {
    $response = array('error' => $db->error);
    echo json_encode($response);
}

$db->close();
