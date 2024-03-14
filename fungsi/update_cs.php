<?php
include '../config.php';

$id = $_POST['id'];
$total = $_POST['total'];
$stat = "sudah";
$sql = "UPDATE waktu_meja SET bayar = '$stat', total_bayar = '$total'  WHERE id = '$id'";
$hasil = $db->query($sql);

if ($hasil) {
    // Jika pembaruan berhasil
    echo json_encode(array('success' => true, 'message' => 'Pembaruan berhasil'));
} else {
    // Jika ada kesalahan dalam pembaruan
    echo json_encode(array('success' => false, 'message' => 'Gagal melakukan pembaruan'));
}

$db->close();
