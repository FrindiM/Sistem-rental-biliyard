 <?php
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
 <div class="row">
 	<div class="col-md-12">
 		<h4>
 			<!--<a  style="padding-left:2pc;" href="fungsi/hapus/hapus.php?laporan=jual" onclick="javascript:return confirm('Data Laporan akan di Hapus ?');">
						<button class="btn btn-danger">RESET</button>
					</a>-->
 			<?php if (!empty($_GET['cari'])) { ?>
 				Data Laporan Penjualan Tambahan <?= $bulan_tes[$_POST['bln']]; ?> <?= $_POST['thn']; ?>
 			<?php } elseif (!empty($_GET['hari'])) { ?>
 				Data Laporan Penjualan Tambahan <?= $_POST['hari']; ?>
 			<?php } else { ?>
 				Data Laporan Penjualan Tambahan <?= $bulan_tes[date('m')]; ?> <?= date('Y'); ?>
 			<?php } ?>
 		</h4>
 		<br />
 		<div class="card">
 			<div class="card-header">
 				<h5 class="card-title mt-2">Cari Laporan Per Bulan</h5>
 			</div>
 			<div class="card-body p-0">
 				<form method="post" action="admin.php?page=tambahan&cari=ok">
 					<table class="table table-striped">
 						<tr>
 							<th>
 								Pilih Bulan
 							</th>
 							<th>
 								Pilih Tahun
 							</th>
 							<th>
 								Aksi
 							</th>
 						</tr>
 						<tr>
 							<td>
 								<select name="bln" class="form-control">
 									<option selected="selected">Bulan</option>
 									<?php
										$bulan = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
										$jlh_bln = count($bulan);
										$bln1 = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
										$no = 1;
										for ($c = 0; $c < $jlh_bln; $c += 1) {
											echo "<option value='$bln1[$c]'> $bulan[$c] </option>";
											$no++;
										}
										?>
 								</select>
 							</td>
 							<td>
 								<?php
									$now = date('Y');
									echo "<select name='thn' class='form-control'>";
									echo '
								<option selected="selected">Tahun</option>';
									for ($a = 2017; $a <= $now; $a++) {
										echo "<option value='$a'>$a</option>";
									}
									echo "</select>";
									?>
 							</td>
 							<td>
 								<input type="hidden" name="periode" value="ya">
 								<button class="btn btn-primary">
 									<i class="fa fa-search"></i> Cari
 								</button>
 								<a href="admin.php?page=tambahan" class="btn btn-success">
 									<i class="fa fa-refresh"></i> Refresh</a>

 								<?php if (!empty($_GET['cari'])) { ?>
 									<a href="fungsi/excel2.php?cari=yes&bln=<?= $_POST['bln']; ?>&thn=<?= $_POST['thn']; ?>" class="btn btn-info"><i class="fa fa-download"></i>
 										Excel</a>
 								<?php } else { ?>
 									<a href="fungsi/excel2.php" class="btn btn-info"><i class="fa fa-download"></i>
 										Excel</a>
 								<?php } ?>
 							</td>
 						</tr>
 					</table>
 				</form>
 				<form method="post" action="admin.php?page=tambahan&hari=cek">
 					<table class="table table-striped">
 						<tr>
 							<th>
 								Pilih Hari
 							</th>
 							<th>
 								Aksi
 							</th>
 						</tr>
 						<tr>
 							<td>
 								<input type="date" value="<?= date('Y-m-d'); ?>" class="form-control" name="hari">
 							</td>
 							<td>
 								<input type="hidden" name="periode" value="ya">
 								<button class="btn btn-primary">
 									<i class="fa fa-search"></i> Cari
 								</button>
 								<a href="admin.php?page=laporan" class="btn btn-success">
 									<i class="fa fa-refresh"></i> Refresh</a>

 								<?php if (!empty($_GET['hari'])) { ?>
 									<a href="fungsi/excel2.php?hari=cek&tgl=<?= $_POST['hari']; ?>" class="btn btn-info"><i class="fa fa-download"></i>
 										Excel</a>
 								<?php } else { ?>
 									<a href="fungsi/excel2.php" class="btn btn-info"><i class="fa fa-download"></i>
 										Excel</a>
 								<?php } ?>
 							</td>
 						</tr>
 					</table>
 				</form>
 			</div>
 		</div>
 		<br />
 		<br />
 		<!-- view barang -->
 		<div class="card">
 			<div class="card-body">
 				<div class="table-responsive">
 					<table class="table table-bordered w-100 table-sm" id="example1">
 						<thead>
 							<tr style="background:#DFF0D8;color:#333;">
 								<th> No</th>
 								<th style="width:10%;"> Nomor Meja</th>
 								<th> Nama Item</th>
 								<th> Jumlah</th>
 								<th> Nama Pemain</th>
 								<th> Nama Kasir</th>
 								<th> Tanggal Input</th>
 								<th> Opsi</th>
 							</tr>
 						</thead>
 						<tbody>
 							<?php
								$no = 1;
								if (!empty($_GET['cari'])) {
									$bulanTahunForm = $_POST['bln'] . '-' . $_POST['thn'];
									$no = 1;
									// Konversi nilai bulan dan tahun ke dalam format yang sesuai dengan kolom datetime
									$periode = date('Y-m-d', strtotime('01-' . $bulanTahunForm));

									// Kueri SQL SELECT dengan kondisi tanggal
									$sql = "SELECT * FROM rekap_tambahan WHERE DATE(tgl) >= '$periode' AND DATE(tgl) < LAST_DAY('$periode') + INTERVAL 1 DAY";
									$hasil = $db->query($sql);
								} elseif (!empty($_GET['hari'])) {
									$hari = $_POST['hari'];
									$no = 1;
									$sql = "SELECT * FROM rekap_tambahan WHERE DATE(tgl) = '$hari'";
									$hasil = $db->query($sql);
								} else {
									$no = 1;
									$sql = "SELECT * FROM rekap_tambahan";

									// Eksekusi kueri
									$hasil = $db->query($sql);
								}
								?>
 							<?php
								$bayar = 0;
								$jumlah = 0;
								$waktu = 0;
								foreach ($hasil as $isi) {

								?>
 								<tr>
 									<td><?php echo $no; ?></td>
 									<td><?php echo $isi['nomor_meja']; ?></td>
 									<td><?php echo $isi['nama']; ?></td>
 									<td><?php echo $isi['jumlah']; ?> </td>
 									<td><?php echo $isi['nama_pemain']; ?></td>
 									<td><?php echo $isi['nama_kasir']; ?></td>
 									<td><?php echo $isi['tgl']; ?></td>
 									<td>
 										<a href="fungsi/hapus.php?tambahan=hapus&id=<?php echo $isi['id']; ?>" onclick="javascript:return confirm('Hapus Data Laporan ?');"><button class="btn btn-danger btn-xs">Hapus</button></a>
 									</td>
 								</tr>
 							<?php $no++;
								} ?>
 						</tbody>
 					</table>
 				</div>
 			</div>
 		</div>
 	</div>
 </div>