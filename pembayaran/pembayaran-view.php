<?php
include_once("../functions.php");
sessionPetugas();
$_SESSION["current_page"] = "Pembayaran";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Pembayaran | Hotel Transylvania</title>
    <!-- <link rel="icon" type="image/x-icon" href="assets/favicon.ico" /> -->
    <?php include_once('../head.php'); ?>
</head>

<body>
    <div class="d-flex" id="wrapper">
        <?php include_once("../sidebar-petugas.php"); ?>

        <!-- Page content wrapper-->
        <div id="page-content-wrapper">
            <!-- Top navigation-->
            <nav class="navbar navbar-expand-lg navbar-light bg-primary border-bottom">
                <div class="container-fluid justify-content-center">
                    <a class="navbar-brand text-light" href="#">Selamat Datang di Hotel Transylvania</a>
                </div>
            </nav>
            <!-- Page content-->
            <div class="container-fluid">
                <h6 class="mt-4">
                    <span id="Day"></span>, <span id="Date"></span> - <span id="Time"></span> WIB
                </h6>
                <!-- data table siswa -->
                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Pembayaran</h6>
                    </div>
                    <div class="card-body">
                        <?php
                        $db = dbConnect();
                        if ($db->connect_errno == 0) {
                            $sql = "SELECT * FROM tpembayaran";
                            $res = $db->query($sql);
                            if ($res) {
                                if ($_SESSION["jabatan"] == "Petugas Bagian Keuangan") {
                                    ?>
                                    <a href="pembayaran-tambah.php"><button type="button" class="btn btn-outline-primary rounded btn-sm mb-3">Tambah</button></a>
                                    <?php
                                }
                                ?>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" id="example" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th class="dt-center">No Pembayaran</th>
                                                <th class="dt-center">Opsi Bayar</th>
                                                <th class="dt-center">Nilai Bayar</th>
                                                <th class="dt-center">No Pemesanan</th>
                                                <!-- <th class="dt-center">Aksi</th> -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $data = $res->fetch_all(MYSQLI_ASSOC);
                                            foreach ($data as $row) {
                                            ?>
                                                <tr>
                                                    <td class="text-center"><?= $row['no_pembayaran']; ?></td>
                                                    <td><?= $row['opsi_bayar']; ?></td>
                                                    <td class="text-end">Rp <?= number_format($row['nilai_bayar'], 0, ",", "."); ?></td>
                                                    <td class="text-center"><?= $row['no_pemesanan']; ?></td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                            <?php
                                $res->free();
                            } else
                                echo "Gagal Eksekusi SQL" . (DEVELOPMENT ? " : " . $db->error : "") . "<br>";
                        } else
                            echo "Gagal koneksi" . (DEVELOPMENT ? " : " . $db->connect_error : "") . "<br>";
                            ?>
                                </div>
                    </div>
                </div>

            </div>
        </div>
</body>

</html>