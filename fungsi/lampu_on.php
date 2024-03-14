<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nomor_meja = isset($_POST['nomor_meja']) ? $_POST['nomor_meja'] : null;
    $waktu = isset($_POST['waktu_' . $nomor_meja]) ? $_POST['waktu_' . $nomor_meja] : null;
    $paket = isset($_POST['lampu_' . $nomor_meja]) ? $_POST['lampu_' . $nomor_meja] : null;
    $nama = isset($_POST['nama_' . $nomor_meja]) ? $_POST['nama_' . $nomor_meja] : null;
    $harga = isset($_POST['harga_' . $nomor_meja]) ? $_POST['harga_' . $nomor_meja] : null;
    $kasir = $_SESSION["nama"];

    if ($nomor_meja && $waktu) {

        // Kirim perintah ke perangkat mikrokontroler untuk menghidupkan lampu sesuai nomor meja
        // ... (kode untuk mengirim perintah ke mikrokontroler) ...

        // Simpan nomor meja dan waktu ke database
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "myDB";

        // Buat koneksi
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Periksa koneksi
        if ($conn->connect_error) {
            die("Koneksi gagal: " . $conn->connect_error);
        }

        $stat = "on";
        $bayar = "belum";
        // Siapkan dan jalankan pernyataan yang disiapkan
        $stmt = $conn->prepare("INSERT INTO waktu_meja (nomor_meja, nama, waktu, stat, id_paket, harga, kasir, bayar) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isisssss", $nomor_meja, $nama, $waktu, $stat, $paket, $harga, $kasir, $bayar);
        $stmt->execute();

        $stmt->close();
        $conn->close();
    }
}
