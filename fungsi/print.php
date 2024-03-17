<?php
session_start();
require '../config.php';
date_default_timezone_set('Asia/Makassar'); // Ganti dengan zona waktu yang sesuai
$nomor = isset($_GET['nomor']) ? $_GET['nomor'] : '';
$nama = isset($_GET['nama']) ? $_GET['nama'] : '';
$paket = isset($_GET['paket']) ? $_GET['paket'] : '';
$waktu = isset($_GET['waktu']) ? $_GET['waktu'] : '';
$harga = isset($_GET['harga']) ? $_GET['harga'] : '';
$tambahan = isset($_GET['tambahan']) ? $_GET['tambahan'] : '';
$tambahanharga = isset($_GET['tambahanharga']) ? $_GET['tambahanharga'] : '';
$totalharga = isset($_GET['totalharga']) ? $_GET['totalharga'] : '';
?>
<html>

<head>
	<title>print</title>
	<link rel="stylesheet" href="assets/css/bootstrap.css">
</head>

<body>
	<script>
		window.print();
	</script>
	<div class="container">
		<div class="row">
			<div class="col-sm-4"></div>
			<div class="col-sm-4">
				<center>
					<p><?php echo 'R&B'; ?></p>
					<p><?php echo 'Kawasan Megamas'; ?></p>
					<p>Tanggal : <?php echo date("j F Y, G:i"); ?></p>
					<p>Kasir : <?php echo $_SESSION["nama"]; ?></p>
					<p>Customer : <?php echo $nama; ?></p>
					<br>
				</center>
				<table class="table table-bordered" style="width:100%;">
					<tr>
						<td>Meja</td>
						<td>Paket</td>
						<td>Waktu</td>
						<td>Harga</td>
					</tr>
					<tr>
						<td><?php echo $nomor; ?></td>
						<td><?php echo $paket ?></td>
						<td><?php echo $waktu ?></td>
						<td><?php echo $harga ?></td>
					</tr>
				</table>
				<br>
				<table>
					<tr>
						<td>Tambahan</td>
						<td>harga</td>
					</tr>
					<tr>
						<td><?php echo $tambahan ?></td>
						<td><?php echo $tambahanharga ?></td>
					</tr>
				</table>
				<br>
				<div class="pull-right">
					Total : Rp.<?php echo number_format($totalharga); ?>,-
					<br />
					Bayar : Rp.<?php echo number_format(htmlentities($_GET['totalharga'])); ?>,-
					<br />
					Kembali : Rp.<?php echo number_format(htmlentities($_GET['totalharga'])); ?>,-
				</div>
				<div class="clearfix"></div>
				<center>
					<p>Terima Kasih Telah Datang !</p>
				</center>
			</div>
			<div class="col-sm-4"></div>
		</div>
	</div>
</body>

</html>