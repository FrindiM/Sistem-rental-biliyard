<?php
// Gantilah dengan koneksi database sesuai kebutuhan Anda
include '../config.php';

$user = isset($_POST['user']) ? $_POST['user'] : null;
$date = isset($_POST['date']) ? $_POST['date'] : null;
$tabel = isset($_POST['tabel']) ? $_POST['tabel'] : null;

$sql = "SELECT * FROM waktu_meja WHERE DATE(tanggal) = '$date' AND kasir = '$user' AND nomor_meja = '$tabel'";

$result = $db->query($sql);

if ($result !== false) {
    $response = array();

    while ($row = $result->fetch_assoc()) {
        $response[] = $row;
    }

    if (!empty($response)) {
        echo json_encode($response);
    } else {
        // Mengirimkan respons JSON dengan informasi "kosong"
        $response = array('info' => 'kosong');
        echo json_encode($response);
    }
} else {
    $response = array('error' => $db->error);
    echo json_encode($response);
}

$db->close();
