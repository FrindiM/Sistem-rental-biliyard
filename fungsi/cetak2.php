<?php
require 'config.php';

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
    $hari = $_GET['tgl'];
    $sql = "SELECT * FROM waktu_meja WHERE DATE(tanggal) = '$hari'";
} else {
    echo "Data Laporan Penjualan " . $bulan_tes[date('m')] . " " . date('Y');
    $sql = "SELECT * FROM waktu_meja";
}

echo "</h3>";

echo "<table border='1' width='100%' cellpadding='3' cellspacing='4'>";
echo "<thead>";
echo "<tr>
            <th> No</th>
            <th> Meja</th>
            <th> Nama</th>
            <th> Waktu</th>
            <th> Harga</th>
            <th> Item</th>
            <th> Harga</th>
            <th> Total</th>
            <th> Kasir</th>
            
        </tr>";
echo "</thead>";
echo "<tbody>";

$no = 1;
$bayar = 0;
$jumlah = 0;
$waktu = 0;
$total = 0;
$semua = 0;

$hasil = $db->query($sql);

foreach ($hasil as $isi) {
    $waktu += $isi['waktu'];
    $idpaket = $isi['id_paket'];
    $bayar += $isi['harga'];
    $total += $isi['total_harga'];
    $semua += $isi['total_bayar'];

    echo "<tr>
                <td>{$no}</td>
                <td>{$isi['nomor_meja']}</td>
                <td>{$isi['nama']}</td>
                
                <td>{$isi['waktu']} menit</td>
                <td>Rp." . number_format($isi['harga']) . ",-</td>
                <td>{$isi['nama_item']}</td>
                <td>Rp." . number_format($isi['total_harga']) . ",-</td>
                <td>Rp." . number_format($isi['total_bayar']) . ",-</td>
                <td>{$isi['kasir']}</td>
                
              </tr>";
    $no++;
}

echo "<tr>
            <td><b>Total</b></td>
            <td>-</td>
            <td>-</td>
            
            <td><b>{$waktu} Menit</b></td>
            <td><b>Rp." . number_format($bayar) . ",-</b></td>
            <td>-</td>
            <td><b>Rp." . number_format($total) . ",-</b></td>
            <td><b>Rp." . number_format($semua) . ",-</b></td>
          </tr>";

echo "</tbody>";
echo "</table>";


echo "<script>
    window.onload = function() {
        window.print();
    };
</script>";
