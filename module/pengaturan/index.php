        <h4>Daftar Paket</h4>
        <br />
        <?php if (isset($_GET['success-stok'])) { ?>
            <div class="alert alert-success">
                <p>Tambah data Berhasil !</p>
            </div>
        <?php } ?>
        <?php if (isset($_GET['success'])) { ?>
            <div class="alert alert-success">
                <p>Tambah Data Berhasil !</p>
            </div>
        <?php } ?>
        <?php if (isset($_GET['remove'])) { ?>
            <div class="alert alert-danger">
                <p>Hapus Data Berhasil !</p>
            </div>
        <?php } ?>

        <!-- Trigger the modal with a button -->
        <button type="button" class="btn btn-primary btn-md mr-2" data-toggle="modal" data-target="#myModal">
            <i class="fa fa-plus"></i> Tambah User</button>
        <a href="index.php?page=barang" class="btn btn-success btn-md">
            <i class="fa fa-refresh"></i> Refresh Data</a>
        <div class="clearfix"></div>
        <br />
        <!-- view barang -->
        <div class="card card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-sm" id="example1">
                    <thead>
                        <tr style="background:#DFF0D8;color:#333;">
                            <th>No.</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th>Level</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $host = "localhost";
                        $user = "root";
                        $password = "";
                        $database = "mydb";

                        // Membuat koneksi ke database
                        $conn = new mysqli($host, $user, $password, $database);

                        // Memeriksa koneksi
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }
                        $query = "SELECT * FROM user";
                        $result = $conn->query($query);
                        $no = 1;
                        // Menampilkan data dari hasil query
                        while ($row = $result->fetch_assoc()) {
                        ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $row['username']; ?></td>
                                <td><?= $row['password']; ?></td>
                                <td><?= $row['level']; ?></td>
                                <td>
                                    <a href="admin.php?page=pengaturan/edit&id=<?php echo $row['id']; ?>" class="btn btn-warning btn-xs">ubah</a>
                                    <a href="fungsi/hapus.php?user=hapus&id=<?php echo $row['id']; ?>" onclick="javascript:return confirm('Hapus Data User ?');"><button class="btn btn-danger btn-xs">Hapus</button></a>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>

                </table>
            </div>
        </div>
        <!-- end view barang -->
        <!-- tambah barang MODALS-->
        <!-- Modal -->

        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content" style=" border-radius:0px;">
                    <div class="modal-header" style="background:#285c64;color:#fff;">
                        <h5 class="modal-title"><i class="fa fa-plus"></i> Tambah User</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <form action="fungsi/add.php" method="POST">
                        <input type="hidden" name="action" value="adduser">
                        <div class="modal-body">
                            <table class="table table-striped bordered">
                                <tr>
                                    <td>Username</td>
                                    <td><input type="text" placeholder="Username" required class="form-control" name="username"></td>
                                </tr>
                                <tr>
                                    <td>Password</td>
                                    <td><input type="text" placeholder="Password" required class="form-control" name="password"></td>
                                </tr>
                                <tr>
                                    <td>Level</td>
                                    <td>
                                        <select class="form-control" name="level" required>
                                            <option value="admin">Admin</option>
                                            <option value="kasir">Kasir</option>
                                        </select>
                                    </td>
                                </tr>
                                <td>Tanggal Input</td>
                                <td><input type="text" required readonly="readonly" class="form-control" value="<?php echo  date("j F Y, G:i"); ?>" name="tgl"></td>
                                </tr>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Insert
                                Data</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>