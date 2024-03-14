<?php

$sql1 = "SELECT COUNT(*) as total FROM waktu_meja";
$result1 = $db->query($sql1);
$row1 = $result1->fetch_assoc();

$sql2 = "SELECT COUNT(*) as total FROM paket";
$result2 = $db->query($sql2);
$row2 = $result2->fetch_assoc();

$sql3 = "SELECT COUNT(*) as total FROM user";
$result3 = $db->query($sql3);
$row3 = $result3->fetch_assoc();
?>
<h3>Dashboard</h3>
<br />
<div class="row">
    <!--STATUS cardS -->
    <div class="col-md-3 mb-3">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h6 class="pt-2"><i class="fas fa-box"></i> Paket</h6>
            </div>
            <div class="card-body">
                <center>
                    <h1>
                        <?php echo $row2['total']; ?>
                    </h1>
                </center>
            </div>
        </div>
        <!--/grey-card -->
    </div><!-- /col-md-3-->

    <!-- STATUS cardS -->
    <div class="col-md-3 mb-3">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h6 class="pt-2"><i class="fas fa-table"></i> Meja</h6>
            </div>
            <div class="card-body">
                <center>
                    <h1>10</h1>
                </center>
            </div>
        </div>
        <!--/grey-card -->
    </div><!-- /col-md-3-->
    <!-- STATUS cardS -->
    <div class="col-md-3 mb-3">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h6 class="pt-2"><i class="fas fa-dice"></i> Permainan</h6>
            </div>
            <div class="card-body">
                <center>
                    <h1><?php echo $row1['total']; ?></h1>
                </center>
            </div>
        </div>
        <!--/grey-card -->
    </div><!-- /col-md-3-->
    <div class="col-md-3 mb-3">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h6 class="pt-2"><i class="fa fa-users"></i> Karyawan</h6>
            </div>
            <div class="card-body">
                <center>
                    <h1><?php echo $row3['total']; ?></h1>
                </center>
            </div>
        </div>
        <!--/grey-card -->
    </div><!-- /col-md-3-->
</div>