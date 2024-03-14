 <!--sidebar end-->

 <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
 <!--main content start-->
 <?php
	$id = $_GET['id'];
	$sql = "SELECT * FROM user WHERE id = '$id'";
	// Eksekusi kueri
	$hasil = $db->query($sql);
	$baris = $hasil->fetch_assoc();


	// Pastikan ini diawal file edit.php
	if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET['barang']) && $_GET['barang'] == 'edit') {

		// Mengambil nilai dari formulir
		$id = $_POST['id'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		$level = $_POST['level'];
		$tgl = $_POST['tgl'];

		// Kueri SQL UPDATE
		$sql = "UPDATE user SET 
            username = '$username',
            password = '$password',
            level = '$level'
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
		echo '<script>window.location="admin.php?page=pengaturan/edit&id=' . $id . '&success=edit-data"</script>';
		exit();
	}
	?>


 <a href="admin.php?page=pengaturan" class="btn btn-primary mb-3"><i class="fa fa-angle-left"></i> Balik </a>
 <h4>Edit User</h4>
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
 			<form action="admin.php?page=pengaturan/edit&barang=edit&id=<?php echo $baris['id']; ?>" method="POST">
 				<tr>
 					<td>ID User</td>
 					<td><input type="text" readonly="readonly" class="form-control" value="<?php echo $baris['id']; ?>" name="id"></td>
 				</tr>
 				<tr>
 					<td>Username</td>
 					<td><input type="text" class="form-control" value="<?php echo $baris['username']; ?>" name="username"></td>
 				</tr>
 				<tr>
 					<td>Password</td>
 					<td><input type="text" class="form-control" value="<?php echo $baris['password']; ?>" name="password"></td>
 				</tr>
 				<tr>
 					<td>Level</td>
 					<td>
 						<select class="form-control" name="level">
 							<option value="admin" <?php echo ($baris['level'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
 							<option value="kasir" <?php echo ($baris['level'] == 'kasir') ? 'selected' : ''; ?>>Kasir</option>
 						</select>
 					</td>
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