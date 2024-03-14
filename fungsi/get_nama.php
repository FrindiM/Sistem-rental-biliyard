<?php
include '../config.php';

// Periksa apakah variabel $_POST['nomormeja'] telah diset
if(isset($_POST['nomormeja'])){
    $nomor = $_POST['nomormeja'];

    // Periksa apakah variabel $nomor tidak kosong
    if(!empty($nomor)){
        $sql = "SELECT * FROM waktu_meja WHERE nomor_meja = '$nomor' AND bayar = 'belum'";

        $result = $db->query($sql);

        if ($result !== false) {
            $response = array();

            while ($row = $result->fetch_assoc()) {
                $response[] = array('id' => $row['id'], 'nama' => $row['nama']);
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
    } else {
        $response = array('error' => 'Nomor meja tidak boleh kosong');
        echo json_encode($response);
    }
} else if(isset($_POST['selectednama'])){
    $nomor = $_POST['selectednama'];

    // Periksa apakah variabel $nomor tidak kosong
    if(!empty($nomor)){
        $sql = "SELECT * FROM waktu_meja WHERE nama = '$nomor' AND bayar = 'belum'";

        $result = $db->query($sql);

        if ($result !== false) {
            $response = array();

            while ($row = $result->fetch_assoc()) {
                $response[] = array('id' => $row['id'], 'nama' => $row['nama']);
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
    } else {
        $response = array('error' => 'Nomor meja tidak boleh kosong');
        echo json_encode($response);
    }
}

$db->close();
?>
