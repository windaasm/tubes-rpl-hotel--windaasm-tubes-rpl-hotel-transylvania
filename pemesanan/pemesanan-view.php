<?php
include_once("../functions.php");
sessionPetugas();
$_SESSION["current_page"] = "Pemesanan";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Pemesanan | Hotel Transylvania</title>
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
                <?php
                if (isset($_GET["error"])) {
                    $error = $_GET["error"];
                    if ($error == 1)
                        showError("Nama Pengguna dan Kata Sandi tidak sesuai.");
                    else if ($error == 2)
                        showError("Error database. Silahkan hubungi administrator");
                    else if ($error == 3)
                        showError("Koneksi ke Database gagal. Autentikasi gagal.");
                    else if ($error == 4)
                        showError("Anda tidak boleh mengakses halaman sebelumnya karena belum login. Silahkan login terlebih dahulu.");
                    else if ($error == 5)
                        showError("Anda tidak memiliki hak untuk mengakses halaman sebelumnya");
                    else
                        showError("Unknown Error.");
                }
                ?>
                <h6 class="mt-4">
                    <span id="Day"></span>, <span id="Date"></span> - <span id="Time"></span> WIB
                </h6>
                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Pemesanan</h6>
                    </div>
                    <div class="card-body">
                        <?php
                        $db = dbConnect();
                        if ($db->connect_errno == 0) {
                            $sql = "SELECT m.no_pemesanan, p.nama_petugas, k.no_kamar, k.jenis_kamar, pe.nama_pelanggan, 
                                    m.banyak_orang, m.lama_inap, m.tgl_check_out, m.tgl_check_in
                                    FROM tmemesan m
                                    LEFT JOIN tpetugas p ON m.id_petugas = p.id_petugas
                                    JOIN tkamar k ON m.no_kamar = k.no_kamar
                                    JOIN tpelanggan pe ON m.nik = pe.nik
                                    ";
                            $res = $db->query($sql);
                            if ($res) {
                        ?>
                                <!-- <a href="pemesanan-tambah.php"><button type="button" class="btn btn-outline-primary rounded btn-sm mb-3">Tambah</button></a> -->

                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" id="example" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th class="dt-center">No</th>
                                                <th class="dt-center">Nama Pemesan</th>
                                                <th class="dt-center">No Kamar</th>
                                                <th class="dt-center">Jenis Kamar</th>
                                                <th class="dt-center">Banyak Orang</th>
                                                <th class="dt-center">Lama Inap</th>
                                                <th class="dt-center">Tanggal <i>Check-in</i></th>
                                                <th class="dt-center">Tanggal <i>Check-out</i></th>
                                                <th class="dt-center">Nama Petugas</th>
                                                <?php 
                                                if ($_SESSION["user"] == "Petugas" && $_SESSION["jabatan"] == "Petugas Resepsionis") {
                                                    echo "<th class='dt-center'>Aksi</th>";
                                                }
                                                ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no =  1;
                                            $data = $res->fetch_all(MYSQLI_ASSOC);
                                            foreach ($data as $row) {
                                            ?>
                                                <tr>
                                                    <td class="text-center"><?= $no++; ?></td>
                                                    <td><?= $row['nama_pelanggan']; ?></td>
                                                    <td class="text-center"><?= $row['no_kamar']; ?></td>
                                                    <td><?= $row['jenis_kamar']; ?></td>
                                                    <td class="text-center"><?= $row['banyak_orang']; ?></td>
                                                    <td class="text-center"><?= $row['lama_inap']; ?> hari</td>
                                                    <td class="text-center"><?= $row['tgl_check_in']; ?></td>
                                                    <td class="text-center"><?= $row['tgl_check_out']; ?></td>
                                                    <td><?= $row['nama_petugas']; ?></td>
                                                    <?php
                                                    if ($_SESSION["user"] == "Petugas" && $_SESSION["jabatan"] == "Petugas Resepsionis") {
                                                        ?>
                                                        <td class="text-center">
                                                            <a href="pemesanan-edit.php?no_pemesanan=<?= $row['no_pemesanan'] ?>" class="btn btn-success btn-circle btn-sm">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                        </td>
                                                        <?php
                                                    }
                                                    ?>
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
    </div>
</body>

</html>