<?php
// Gantilah dengan koneksi database sesuai kebutuhan Anda
include '../config.php';


$sql = "SELECT * FROM minuman ";

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
