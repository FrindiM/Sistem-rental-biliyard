 <!--sidebar end-->

 <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
 <!--main content start-->
 <?php
	$id = $_GET['id'];
	$sql = "SELECT * FROM paket WHERE id = '$id'";
	// Eksekusi kueri
	$hasil = $db->query($sql);
	$baris = $hasil->fetch_assoc();


	// Pastikan ini diawal file edit.php
	if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET['barang']) && $_GET['barang'] == 'edit') {

		// Mengambil nilai dari formulir
		$id = $_POST['id'];
		$nama = $_POST['nama'];
		$waktu = $_POST['waktu'];
		$harga = $_POST['harga'];
		$tgl = $_POST['tgl'];

		// Kueri SQL UPDATE
		$sql = "UPDATE paket SET 
            nama = '$nama',
            waktu = '$waktu',
            harga = '$harga',
            tgl = '$tgl'
            WHERE id = '$id'";

		// Eksekusi kueri
		$hasil = $db->query($sql);

		// Memeriksa apakah kueri berhasil dieksekusi
		if ($hasil === false) {
			die("Kesalahan eksekusi kueri: " . $db->error);
		}

		// Menutup koneksi database
		$db->close();

		// Redirect ke halaman setelah update
		echo '<script>window.location="admin.php?page=barang/edit&id=' . $id . '&success=edit-data"</script>';
		exit();
	}
	?>


 <a href="admin.php?page=barang" class="btn btn-primary mb-3"><i class="fa fa-angle-left"></i> Balik </a>
 <h4>Edit Paket</h4>
 <?php if (isset($_GET['success'])) { ?>
 	<div class="alert alert-success">
 		<p>Edit Data Berhasil !</p>
 	</div>
 <?php } ?>
 <?php if (isset($_GET['remove'])) { ?>
 	<div class="alert alert-danger">
 		<p>Hapus Data Berhasil !</p>
 	</div>
 <?php } ?>
 <div class="card card-body">
 	<div class="table-responsive">
 		<table class="table table-striped">
 			<form action="admin.php?page=barang/edit&barang=edit&id=<?php echo $baris['id']; ?>" method="POST">
 				<tr>
 					<td>ID Barang</td>
 					<td><input type="text" readonly="readonly" class="form-control" value="<?php echo $baris['id']; ?>" name="id"></td>
 				</tr>
 				<tr>
 					<td>Nama Paket</td>
 					<td><input type="text" class="form-control" value="<?php echo $baris['nama']; ?>" name="nama"></td>
 				</tr>
 				<tr>
 					<td>Jumlah Waktu(menit)</td>
 					<td><input type="number" class="form-control" value="<?php echo $baris['waktu']; ?>" name="waktu"></td>
 				</tr>
 				<tr>
 					<td>Harga Paket</td>
 					<td><input type="number" class="form-control" value="<?php echo $baris['harga']; ?>" name="harga"></td>
 				</tr>
 				<tr>
 					<td>Tanggal Update</td>
 					<td><input type="text" readonly="readonly" class="form-control" value="<?php echo  date("j F Y, G:i"); ?>" name="tgl"></td>
 				</tr>
 				<tr>
 					<td></td>
 					<td><button class="btn btn-primary"><i class="fa fa-edit"></i> Update Data</button></td>
 				</tr>
 			</form>
 		</table>
 	</div>
 </div>