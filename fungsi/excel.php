<?php
@ob_start();
header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=data-laporan-" . date('Y-m-d') . ".xls");  //File name extension was wrong
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private", false);

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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <!-- view barang -->
    <!-- view barang -->
    <div class="modal-view">
        <h3 style="text-align:center;">
            <?php if (!empty($_GET['cari'])) { ?>
                Data Laporan Penjualan <?= $bulan_tes[$_GET['bln']]; ?> <?= $_GET['thn']; ?>
            <?php } elseif (!empty($_GET['hari'])) { ?>
                Data Laporan Penjualan <?= $_GET['tgl']; ?>
            <?php } else { ?>
                Data Laporan Penjualan <?= $bulan_tes[date('m')]; ?> <?= date('Y'); ?>
            <?php } ?>
        </h3>
        <table border="1" width="100%" cellpadding="3" cellspacing="4">
            <thead>
                <tr bgcolor="yellow">
                    <th> No</th>
                    <th> Nomor Meja</th>
                    <th> Nama</th>
                    <th> Paket</th>
                    <th style="width:10%;"> Waktu</th>
                    <th style="width:10%;"> Harga</th>
                    <th> Item Tambahan</th>
                    <th> Harga</th>
                    <th> Total Harga</th>
                    <th> Kasir</th>
                    <th> Tanggal Input</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                if (!empty($_GET['cari'])) {
                    $bulanTahunForm = $_GET['bln'] . '-' . $_GET['thn'];
                    $periode = date('Y-m-d', strtotime('01-' . $bulanTahunForm));
                    // Kueri SQL SELECT dengan kondisi tanggal
                    $sql = "SELECT * FROM waktu_meja WHERE DATE(tanggal) >= '$periode' AND DATE(tanggal) < LAST_DAY('$periode') + INTERVAL 1 DAY";
                    $hasil = $db->query($sql);
                } elseif (!empty($_GET['hari'])) {
                    $hari = $_GET['tgl'];
                    $sql = "SELECT * FROM waktu_meja WHERE DATE(tanggal) = '$hari'";
                    $hasil = $db->query($sql);
                } else {
                    $sql = "SELECT * FROM waktu_meja";
                    // Eksekusi kueri
                    $hasil = $db->query($sql);
                }
                ?>

                <?php
                $bayar = 0;
                $jumlah = 0;
                $waktu = 0;
                foreach ($hasil as $isi) {

                    $waktu += $isi['waktu'];
                    $idpaket = $isi['id_paket'];
                    $bayar += $isi['harga'];
                ?>
                    <tr>
                        <td><?php echo $no; ?></td>
                        <td><?php echo $isi['nomor_meja']; ?></td>
                        <td><?php echo $isi['nama']; ?></td>
                        <td><?php echo $isi['id_paket']; ?> </td>
                        <td><?php echo $isi['waktu']; ?> menit</td>
                        <td>Rp.<?php echo number_format($isi['harga']); ?>,-</td>
                        <td><?php echo $isi['nama_item']; ?></td>
                        <td>Rp.<?php echo number_format($isi['total_harga']); ?>,-</td>
                        <td>Rp.<?php echo number_format($isi['total_bayar']); ?>,-</td>
                        <td><?php echo $isi['kasir']; ?></td>
                        <td><?php echo $isi['tanggal']; ?></td>
                    </tr>
                <?php $no++;
                } ?>
                <tr>
                    <td>-</td>
                    <td>-</td>
                    <td><b>Total</b></td>
                    <td>-</td>
                    <td><b><?php echo $waktu; ?> Menit</b></td>
                    <td><b>Rp.<?php echo number_format($bayar); ?>,-</b></td>
                    <td>-</td>
                    <td>-</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>