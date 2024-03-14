<?php
include "../config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];

    // Fungsi untuk menambahkan paket
    if ($action == "addPaket") {
        $nama = $_POST['nama'];
        $waktu = $_POST['waktu'];
        $harga = $_POST['harga'];
        $tgl = $_POST['tgl'];

        // Lakukan validasi atau operasi lain sesuai kebutuhan

        // Siapkan dan jalankan pernyataan yang disiapkan
        $stmt = $db->prepare("INSERT INTO paket (nama, waktu, harga, tgl) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("siis", $nama, $waktu, $harga, $tgl);
        $stmt->execute();

        // Tambahkan log atau tindakan lainnya jika diperlukan

        // Redirect atau keluar atau tampilkan pesan sukses
        header("Location: ../admin.php?page=barang");
        exit();
    } else if ($action == "adduser") {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $level = $_POST['level'];
        $tgl = $_POST['tgl'];
        $lev = 'level';
        $pass = 'password';

        // Lakukan validasi atau operasi lain sesuai kebutuhan

        // Siapkan dan jalankan pernyataan yang disiapkan
        $stmt = $db->prepare("INSERT INTO user (username, $pass, $lev) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $password, $level);
        $stmt->execute();

        // Tambahkan log atau tindakan lainnya jika diperlukan

        // Redirect atau keluar atau tampilkan pesan sukses
        header("Location: ../admin.php?page=pengaturan");
        exit();
    } else if ($action == "addMinuman") {
        $nama = $_POST['nama'];
        $harga = $_POST['harga'];
        $tgl = $_POST['tgl'];

        // Lakukan validasi atau operasi lain sesuai kebutuhan

        // Siapkan dan jalankan pernyataan yang disiapkan
        $stmt = $db->prepare("INSERT INTO minuman (nama, harga) VALUES (?, ?)");
        $stmt->bind_param("si", $nama, $harga);
        $stmt->execute();

        // Tambahkan log atau tindakan lainnya jika diperlukan

        // Redirect atau keluar atau tampilkan pesan sukses
        header("Location: ../admin.php?page=minuman");
        exit();
    }

    // Fungsi lainnya bisa ditambahkan di sini sesuai kebutuhan
}
