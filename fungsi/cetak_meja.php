<?php
require '../config.php';

$bulan_tes = array(
    '01' => "Januari",
    '02' => "Februari",
    '03' => "Maret",
    '04' => "April",
    '05' => "Mei",
    '06' => "Juni",
    '07' => "Juli",
    '08' => "Agustus",
    '09' => "September",
    '10' => "Oktober",
    '11' => "November",
    '12' => "Desember"
);

echo "<h3 >";

if (!empty($_GET['cari'])) {
    echo "Data Laporan Penjualan " . $bulan_tes[$_GET['bln']] . " " . $_GET['thn'];
    $bulanTahunForm = $_GET['bln'] . '-' . $_GET['thn'];
    $periode = date('Y-m-d', strtotime('01-' . $bulanTahunForm));
    $sql = "SELECT * FROM waktu_meja WHERE DATE(tanggal) >= '$periode' AND DATE(tanggal) < LAST_DAY('$periode') + INTERVAL 1 DAY";
} elseif (!empty($_GET['hari'])) {
    echo "Data Laporan Penjualan " . $_GET['tgl'];
    echo "<br>Meja: " . $_GET['meja'];
    echo "<br>Nama Kasir: " . $_GET['kasir'];
    $hari = $_GET['tgl'];
    $meja = $_GET['meja'];
    $kasir = $_GET['kasir'];
    $sql = "SELECT * FROM waktu_meja WHERE DATE(tanggal) = '$hari' AND kasir = '$kasir' AND nomor_meja = '$meja'";
    $sql2 = "SELECT * FROM rekap_tambahan WHERE DATE(tgl) = '$hari' AND nama_kasir = '$kasir' AND nomor_meja = '$meja'";
} else {
    echo "Data Laporan Penjualan " . $bulan_tes[date('m')] . " " . date('Y');
    $sql = "SELECT * FROM waktu_meja";
}


echo "</h3>";
$no = 1;
$bayar = 0;
$jumlah = 0;
$waktu = 0;
$total = 0;
$semua = 0;

$hasil = $db->query($sql);
$hasil2 = $db->query($sql2);

$columnValues = array_column($hasil->fetch_all(MYSQLI_ASSOC), "id_paket");
$counts = array_count_values($columnValues);

// Menampilkan hasil perhitungan
echo "<table><tr><th>Nama paket</th><th>Total</th></tr>";
foreach ($counts as $value => $count) {
    echo "<tr><td>" . $value . "</td><td>" . $count . "</td></tr>";
}
echo "</table>";
echo "<br>";

if ($hasil2->num_rows > 0) {
    // Menyiapkan array untuk menyimpan jumlah minuman berdasarkan nama minuman
    $jumlah_minuman = array();

    // Mengambil data dan menyimpannya dalam array
    foreach ($hasil2 as $brs) {
        // Ambil data nama_minuman dan jumlah dari setiap baris
        $nama_minuman = $brs["nama"];
        $jumlah = $brs["jumlah"];

        // Menambahkan jumlah minuman ke dalam array asosiatif
        if (!isset($jumlah_minuman[$nama_minuman])) {
            $jumlah_minuman[$nama_minuman] = 0;
        }
        $jumlah_minuman[$nama_minuman] += $jumlah;
    }

    // Menampilkan hasil perhitungan
    echo "<table><tr><th>Nama Tambahan</th><th>Total</th></tr>";
    foreach ($jumlah_minuman as $nama_minuman => $total_jumlah) {
        echo "<tr><td>" . $nama_minuman . "</td><td>" . $total_jumlah . "</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 hasil";
}

echo "<table border='0' width='30%' cellpadding='3' cellspacing='4'>";
foreach ($hasil as $isi) {
    $waktu += $isi['waktu'];
    $idpaket = $isi['id_paket'];
    $bayar += $isi['harga'];
    $total += $isi['total_harga'];
    $semua += $isi['total_bayar'];
}
echo "<tbody>";
echo "<tr>
            <td style='width:30%'><b>Total Bermain</b></td>
            <td><b>Rp." . number_format($bayar) . ",-</b></td>
          </tr>";
echo "<tr>
            <td style='width:30%'><b>Total Tambahan</b></td>
            <td><b>Rp." . number_format($total) . ",-</b></td>
          </tr>";
echo "<tr>
            <td style='width:30%'><b>Total Seluruhnya</b></td>
            <td><b>Rp." . number_format($semua) . ",-</b></td>
          </tr>";

echo "</tbody>";
echo "</table>";

$waktuTotal = array();
foreach ($hasil as $row) {
    $waktu = $row["waktu"];
    $jam = floor($waktu / 60);
    $menit = $waktu % 60;
    $waktuTotal[] = array(
        "jam" => $jam,
        "menit" => $menit
    );
}

$jamTotal = 0;
$menitTotal = 0;
foreach ($waktuTotal as $waktu) {
    $jamTotal += $waktu["jam"];
    $menitTotal += $waktu["menit"];
}

$jamTambahan = floor($menitTotal / 60);
$menitAkhir = $menitTotal % 60;

echo "Total waktu: " . $jamTotal . " jam " . $menitAkhir . " menit";

echo "<script>
    window.onload = function() {
        window.print();
    };
</script>";
