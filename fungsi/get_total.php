<?php
// Gantilah dengan koneksi database sesuai kebutuhan Anda
include '../config.php';

$id = $_POST['id'];
$nomor = $_POST['nomor'];
$namapemain = $_POST['namapemain'];

$sql = "SELECT * FROM waktu_meja WHERE nomor_meja = '$nomor' AND nama = '$namapemain' AND bayar = 'belum'";
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
