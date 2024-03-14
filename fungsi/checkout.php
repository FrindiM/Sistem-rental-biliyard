<?php

session_start();


date_default_timezone_set('Asia/Makassar');

// Sambungkan ke database
include '../config.php';
$namakasir = $_SESSION["nama"];
$nomor = $_POST['nomor'];
$namapemain = $_POST['namapemain'];
$id = $_POST['id'];

try {
    // Mulai transaksi
    $db->begin_transaction();

    // Ambil data dari keranjang
    $sql = "SELECT * FROM keranjang WHERE meja = '$nomor'";
    $result = $db->query($sql);

    $nama_item = "";
    $total_harga = 0;
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $id_barang = $row['id_barang'];
            $jumlah = $row['jumlah'];

            // Ambil data barang
            $barang = $db->query("SELECT * FROM minuman WHERE nama = '$id_barang'")->fetch_assoc();

            $nama_item .= $barang['nama'] . " *" . $jumlah . ", ";
            $total_harga += $barang['harga'] * $jumlah;

            // Tambahkan ke tabel rekap_tambahan
            $db->query("INSERT INTO rekap_tambahan (nama, jumlah, nama_pemain, nama_kasir, nomor_meja) VALUES ('$id_barang', $jumlah, '$namapemain', '$namakasir', '$nomor')");

            // Hapus barang dari keranjang setelah checkout
            $db->query("DELETE FROM keranjang WHERE id_barang = '$id_barang' AND meja = '$nomor'");
        }

        // Hapus koma terakhir dari nama_item
        $nama_item = rtrim($nama_item, ", ");

        // Tambahkan ke tabel rekap
        $db->query("UPDATE waktu_meja SET total_harga = $total_harga, nama_item = '$nama_item' WHERE nama='$namapemain' AND nomor_meja='$nomor' AND id='$id'");

        // Commit transaksi
        $db->commit();
        echo "success";
    } else {
        echo "eror";
    }
    // Loop through keranjang
} catch (Exception $e) {
    // Rollback transaksi jika terjadi kesalahan
    $db->rollback();
    echo "Error: " . $e->getMessage();
}

// Tutup koneksi
$db->close();
