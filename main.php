<?php
session_start();

// Periksa apakah sesi "nama" dan "level" telah diatur
if (!isset($_SESSION["level"]) || $_SESSION["level"] !== "kasir") {
    // Jika tidak, redirect ke halaman login
    header("Location: index.php");
    exit();
}
date_default_timezone_set('Asia/Makassar');
?>

<!DOCTYPE html>
<html>

<head>
    <title>Kasir</title>
    <link href="css/style.css" rel="stylesheet">
    <link href="sb-admin/css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="sb-admin/vendor/datatables/dataTables.bootstrap4.css" />
    <!-- Bootstrap core JavaScript-->
    <script src="js/jquery-3.7.1.min.js"></script>
    <script src="sb-admin/vendor/jquery/jquery.min.js"></script>
    <script src="sb-admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>

</head>

<body>
    <header class="bg-dark text-white">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h1>Kasir : <?php echo $_SESSION["nama"]; ?></h1>
                </div>
                <div class="col-md-6 text-right">
                    <nav>
                        <ul class="list-inline">
                            <!-- <li class="list-inline-item">
                                <button id="pauseAllButton" class="btn btn-warning mt-3">Pause All</button>
                            </li> -->

                            <li class="list-inline-item"><button id="connectButton" class="conect btn btn-outline-success mt-3">Sambungkan</button></li>
                            <li class="list-inline-item"><button class="btnLaporan btn btn-outline-primary mt-3" id="btnLaporan" data-toggle="modal" data-target="#laporanModal" data-user="<?php echo $_SESSION["nama"]; ?>">Laporan</button></li>
                            <li class="list-inline-item"><a class="btn btn-outline-danger mt-3" href="fungsi/logout.php">Logout</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <?php
    include "config.php";

    // Dapatkan daftar opsi lampu yang tersedia
    $lampu_query = mysqli_query($db, "SELECT * FROM paket");
    $lampu_options = [];

    while ($lampu_row = mysqli_fetch_assoc($lampu_query)) {
        $lampu_id = $lampu_row['id'];
        $lampu_nama = $lampu_row['nama'];
        $lampu_options[] = "<option value='$lampu_id'>$lampu_nama</option>";
    }

    $jumlah_meja = 10; // Jumlah meja
    $kasir = $_SESSION["nama"];
    for ($i = 1; $i <= $jumlah_meja; $i++) {
        echo "<div class='table1'>";
        echo "<h2 class='font-weight-bold'>Meja $i</h2>";
        echo "<form class='start-form' action='control_lampu.php' method='post'>";
        echo "<input type='text' name='nama_$i' id='nama_$i' class='nama-input' placeholder='Nama Pemain'> ";
        echo "<select name='lampu_$i' class='lampu-select ' data-nomor-meja='$i'>";
        echo "<option value='#'>Pilih Paket</option>";
        echo implode('', $lampu_options);
        echo "</select><br>";
        echo "<input type='number' readonly name='waktu_$i' id='waktu_$i' class='waktu-input ' placeholder='Waktu bermain(menit)'> ";
        echo "<div class='timer' id='timer_$i' data-time='-1'>00:00:00</div>";
        echo "<input type='hidden' name='nomor_meja' value='$i'>";
        echo "<input type='hidden' name='harga_$i' id='harga_$i'>";
        echo "<input type='submit' id='mulai_$i' value='Mulai'>";
        echo "<button id='free_$i' type='button' class='start-forward-btn'>Free</button>";
        echo "<button id='frees_$i' class='stop-forward-btn'>Stop</button>";
        echo "<button class='fnb-btn' id='fnb_$i' type='button' data-nama-meja='Meja $i' data-nomor-meja='$i' data-toggle='modal' data-target='#fnb-modal'>F&B</button>";
        echo "</form>";
        echo "<button id='pause_$i' class='pause-btn btn btn-success btn-md mr-2 mt-2' data-nomor-meja='$i'>Pause</button>";
        echo "<button id='stop_$i' class='stop-btn btn btn-danger btn-md mr-2 mt-2' data-nomor-meja='$i'>Stop</button>";
        echo "<button id='transaksi_$i' type='button' class='btn btn-primary btn-md mr-2 mt-2 btn-open-modal' data-toggle='modal' data-target='#myModal' data-nama-meja='Meja $i' data-nomor-meja='$i'>
        <i class='fa fa-plus'></i> Transaksi</button>";
        echo "</div>";
    }
    ?>


    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content" style=" border-radius:0px;">
                <div class="modal-header" style="background:#285c64;color:#fff;">
                    <h5 class="modal-title"><i class="fa fa-plus"></i> Transaksi - <span id="modal-nama-meja"></span></h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <form id="myForm" action="" method="POST">
                    <input type="hidden" name="action" value="addPaket">
                    <div class="modal-body">
                        <table class="table table-striped bordered">
                            <tr>
                                <td>Nomor Meja</td>
                                <td><input readonly id="nomor" type="number" class="nomor form-control" name="nomor"></td>
                                <td>Nama</td>
                                <td><select class="nama-select form-control" id="nomorMeja" name="nama"></select></td>
                            </tr>
                            <tr>
                                <td>Paket</td>
                                <td><input type="text" id="paketbill" readonly class="form-control" name="paket"></td>
                                <td>Jumlah Waktu (Menit)</td>
                                <td><input type="number" readonly id="waktubill" class="waktubill form-control" name="waktu"></td>
                            </tr>
                            <tr>
                                <td>Harga Paket</td>
                                <td><input type="text" id="hargabill" readonly class="form-control" name="harga"></td>

                            </tr>
                            <tr>
                                <td>Menu Tambahan</td>
                                <td><input type="text" id="menutambahan" readonly class="form-control" name="menutambahan"></td>
                                <td>Harga Tambahan</td>
                                <td><input type="text" id="totalmenu" required readonly="readonly" class="form-control" name="totalmenu"></td>
                            </tr>
                            <tr>
                                <td>Total Bayar</td>
                                <td><input type="text" id="totalharga" readonly class="form-control" name="totalharga"></td>
                            </tr>
                            <input type="hidden" id="idhidden" name="idhidden">
                        </table>
                    </div>
                </form>
                <p class="ml-3">Menu Tambahan:</p>
                <div id="keranjangTable2"></div>
                <div class="modal-footer">
                    <button id="checkoutBtn" class="btn btn-primary"><i class="fa fa-plus"></i>Checkout Menu Tambahan</button>
                    <a href="#" id="printButton">
                        <button class="btn btn-secondary">
                            <i class="fa fa-print"></i> Print Untuk Bukti Pembayaran
                        </button>
                    </a>
                    <button id="selesai" class="btn btn-primary"><i class="fa fa-plus"></i>Selesai</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div id="fnb-modal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content" style=" border-radius:0px;">
                <div class="modal-header" style="background:#285c64;color:#fff;">
                    <h5 class="modal-title"><i class="fa fa-plus"></i> Tambah Menu - <span id="modal-nama-meja-fnb"></span></h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <input type="hidden" name="action" value="addPaket">
                <div class="modal-body">
                    <table class="table table-striped bordered">
                        <tr>
                            <td>Nomor Meja</td>
                            <td><input readonly id="nomorminuman" type="number" class="nomorminuman form-control" name="nomor"></td>
                        </tr>
                        <tr>
                            <td>Nama</td>
                            <td><input readonly id="namapemainmenu" type="text" class="namapemainmenu form-control" name="namapemain"></td>
                        </tr>
                        <tr>
                            <td>Nama Menu</td>
                            <td><select class="minuman-select form-control" id="minuman" name="nama"></select></td>
                        </tr>
                        <tr>
                            <td>Harga</td>
                            <td><input type="text" id="hargabillminuman" readonly class="form-control" name="harga"></td>
                        </tr>
                        <tr>
                            <td>Jumlah</td>
                            <td><input type="number" id="jumlahbillminuman" class="form-control" name="jumlah"></td>
                        </tr>
                        <input type="hidden" id="idhidden" name="idhidden">
                    </table>
                    <button id="tambahKeranjangBtn" class="btn btn-primary"><i class="fa fa-plus"></i>Tambahkan</button>
                    <div id="keranjangTable"></div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="laporanModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Laporan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="container ">
                    <div class="row">
                        <div class="col col-5">
                            <label for="selectMeja">Pilih Meja:</label>
                            <select id="selectMeja" class="form-control selectMeja">
                                <option value="all" selected>All</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                            </select>
                        </div>
                        <div class="col col-5">
                            <label for="tanggalInput">Pilih Tanggal:</label>
                            <input type="date" id="tanggalInput" name="tanggalInput" class="form-control">
                        </div>
                        <div class="col col-2">
                            <br><button class="btn btn-success mt-1" id="cariLaporan">Lihat</button>
                        </div>
                        <input type="hidden" id="namaUser" name="namaUser">
                    </div>
                </div>
                <div class="modal-body body-laporan">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary btnPrintLaporan" id="btnPrintLaporan">Print</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>