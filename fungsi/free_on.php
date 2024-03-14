<?php
session_start();
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

$sql = "SELECT harga FROM free LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Mengambil nilai harga dari baris pertama
    $row = $result->fetch_assoc();
    $hargadb = $row["harga"];

    // Menghitung harga per menit
    $menitHarga = $hargadb / 60;

    // Mengambil nilai waktu dari input atau variabel waktu yang sudah ada
    $waktu = isset($_POST['totalMinutes']) ? $_POST['totalMinutes'] : null;
    $waktu2 = isset($_POST['totalMinutes']) ? $_POST['totalMinutes'] : null;

    // Membulatkan waktu sesuai dengan kondisi yang diberikan
    if ($waktu < 60) {
        $waktu = 60;
    } else {
        $waktu = ceil($waktu / 10) * 10;
    }

    // Menghitung total harga
    $harga = ceil($waktu * $menitHarga);
} else {
    echo "Tidak ada data harga dalam tabel free.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nomor_meja = isset($_POST['datameja']) ? $_POST['datameja'] : null;
    $nama = isset($_POST['nama']) ? $_POST['nama'] : null;
    $paket = "0";
    $stat = "on";
    $kasir = $_SESSION["nama"];
    $bayar = "belum";

    if ($nomor_meja && $waktu) {

        // Kirim perintah ke perangkat mikrokontroler untuk menghidupkan lampu sesuai nomor meja
        // ... (kode untuk mengirim perintah ke mikrokontroler) ...

        // Simpan nomor meja dan waktu ke database

        // Siapkan dan jalankan pernyataan yang disiapkan
        $stmt = $conn->prepare("INSERT INTO waktu_meja (nomor_meja, nama, waktu, stat, id_paket, harga, kasir, bayar) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isisssss", $nomor_meja, $nama, $waktu2, $stat, $paket, $harga, $kasir, $bayar);
        $stmt->execute();

        $stmt->close();
        $conn->close();
    }
}
