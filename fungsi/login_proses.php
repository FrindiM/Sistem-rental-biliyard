<?php
session_start();
include '../config.php';
// Letakkan koneksi database atau fungsi lainnya di sini
// Pastikan untuk menggunakan metode keamanan seperti prepared statements

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kolom = "nama";
    $sql = "SELECT * FROM waktu_meja WHERE $kolom = ''";

    $hasil = $db->query($sql);

    if ($hasil->num_rows > 0) {
        // Loop melalui hasil query dan hapus baris yang memiliki data kosong
        while ($row = $hasil->fetch_assoc()) {
            $id = $row['id']; // Ganti 'id' dengan nama kolom kunci utama tabel Anda
            $sql_delete = "DELETE FROM waktu_meja WHERE id = $id"; // Ganti 'id' dengan nama kolom kunci utama tabel Anda
            if ($db->query($sql_delete) === TRUE) {
                echo "Baris dengan ID $id berhasil dihapus.<br>";
            } else {
                echo "Error: " . $sql_delete . "<br>" . $db->error;
            }
        }
    } else {
        echo "Tidak ada data kosong dalam kolom $kolom.";
    }



    // Ambil data dari formulir login
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Implementasikan kueri SQL untuk mengambil data pengguna berdasarkan username dan password
    // Gantilah dengan logika database yang sesuai


    $query = "SELECT * FROM user WHERE username = '$username' AND password = '$password'";
    $result = $db->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nama = $row["username"];
        $level = $row["level"];

        // Set session untuk nama dan level
        $_SESSION["nama"] = $nama;
        $_SESSION["level"] = $level;

        // Set session berdasarkan level dan redirect ke halaman yang sesuai

        if ($level === "admin") {
            header("Location: ../admin.php");
            exit();
        } elseif ($level === "kasir") {
            header("Location: ../main.php");
            exit();
        }
    } else {
        // Jika login gagal, kembali ke halaman login
        header("Location: ../index.php");
        exit();
    }

    $conn->close();
}
