<?php
include_once("../functions.php");
session();
$_SESSION["current_page"] = "Kamar";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Kamar | Hotel Transylvania</title>
    <!-- <link rel="icon" type="image/x-icon" href="assets/favicon.ico" /> -->
    <!-- Core theme CSS (includes Bootstrap)-->
    <?php  include_once('../head.php'); ?>

</head>

<body>
    <div class="d-flex" id="wrapper">
        <?php 
        if ($_SESSION["user"] == "Petugas") {
            include_once("../sidebar-petugas.php"); 
        } else if ($_SESSION["user"] == "Pelanggan") {
            include_once("../sidebar-pelanggan.php");
        }
        ?>

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
                        showError("Anda tidak boleh mengakses halaman sebelumnya karena belum login. Silahkan
                                        login terlebih dahulu.");
                    else if ($error == 5)
                        showError("Anda tidak memiliki hak untuk mengakses halaman sebelumnya");
                    else
                        showError("Unknown Error.");
                }
                ?>
                <h6 class="mt-4">
                    <span id="Day"></span>, <span id="Date"></span> - <span id="Time"></span> WIB
                </h6>
                <!-- data table siswa -->
                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Kamar</h6>
                    </div>
                    <div class="card-body">
                        <?php
                        $db = dbConnect();
                        if ($db->connect_errno == 0) {
                            $sql = "SELECT * FROM tkamar";
                            $res = $db->query($sql);
                            if ($res) {
                                if ($_SESSION["user"] == "Petugas" && $_SESSION["jabatan"] == "Petugas Administrasi") {
                                ?>
                                <a href="kamar-tambah.php"><button type="button" class="btn btn-outline-primary rounded btn-sm mb-3">Tambah</button></a>
                                <?php } ?>

                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" id="example" width="100%" cellspacing="0">
                                        <thead>
                                            <tr> 
                                                <th class="dt-center">No Kamar</th>
                                                <th class="dt-center">Jenis Kamar</th>
                                                <th class="dt-center">Status</th>
                                                <th class="dt-center">Fasilitas</th>
                                                <th class="dt-center">Harga</th>
                                                <?php 
                                                if ($_SESSION["user"] == "Petugas" && ($_SESSION["jabatan"] == "Pramukamar" 
                                                || $_SESSION["jabatan"] == "Petugas Administrasi"))
                                                    echo "<th class='dt-center'>Aksi</th>";
                                                ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $data = $res->fetch_all(MYSQLI_ASSOC);
                                            foreach ($data as $row) {
                                            ?>
                                                <tr>
                                                    <td class="text-center"><?= $row['no_kamar']; ?></td>
                                                    <td><?= $row['jenis_kamar']; ?></td>
                                                    <td><?= $row['status']; ?></td>
                                                    <td><?= $row['fasilitas']; ?></td>
                                                    <td class="text-end">Rp <?= number_format($row['harga'], 0, ",", "."); ?></td>
                                                    <?php
                                                    if ($_SESSION["user"] == "Petugas" && ($_SESSION["jabatan"] == "Pramukamar" 
                                                    || $_SESSION["jabatan"] == "Petugas Administrasi")) {
                                                        ?>
                                                        <td class="text-center">
                                                            <a href="kamar-edit.php?no_kamar=<?= $row['no_kamar'] ?>" class="btn btn-success btn-circle btn-sm">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <?php
                                                            if ($_SESSION["jabatan"] == "Petugas Administrasi") {
                                                                ?>
                                                                <a href="kamar-hapus.php?no_kamar=<?= $row['no_kamar'] ?>" class="btn btn-danger btn-circle btn-sm hapus-data">
                                                                    <i class="fas fa-trash"></i>
                                                                </a>
                                                                <?php
                                                            }
                                                            ?>
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