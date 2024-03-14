<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nomor_meja = isset($_POST['nomor_meja']) ? $_POST['nomor_meja'] : null;
    $waktu = isset($_POST['waktu_' . $nomor_meja]) ? $_POST['waktu_' . $nomor_meja] : null;

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

        $stat = "off";
        // Siapkan dan jalankan pernyataan yang disiapkan
        $stmt = $conn->prepare("INSERT INTO waktu_meja (nomor_meja, waktu, stat) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $nomor_meja, $waktu, $stat);
        $stmt->execute();

        $stmt->close();
        $conn->close();
    }
}
