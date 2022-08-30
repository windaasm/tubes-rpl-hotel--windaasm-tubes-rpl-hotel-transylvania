<?php
include_once("../functions.php");
sessionPetugas();
$_SESSION["current_page"] = "Petugas";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Petugas | Hotel Transylvania</title>
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
                        <h6 class="m-0 font-weight-bold text-primary">Petugas</h6>
                    </div>
                    <div class="card-body">
                        <?php
                        $db = dbConnect();
                        if ($db->connect_errno == 0) {
                            $sql = "SELECT * FROM tpetugas";
                            $res = $db->query($sql);
                            if ($res) {
                                if ($_SESSION["jabatan"] == "Petugas Administrasi") {
                        ?>
                                    <a href="petugas-tambah.php"><button type="button" class="btn btn-outline-primary rounded btn-sm mb-3">Tambah</button></a>
                                <?php
                                }
                                ?>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" id="example" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th class="dt-center">ID Petugas</th>
                                                <th class="dt-center">Nama Petugas</th>
                                                <th class="dt-center">Jabatan</th>
                                                <th class="dt-center">Nama Pengguna</th>
                                                <th class="dt-center">No Lantai</th>
                                                <th class="dt-center">Pelayanan</th>
                                                <th class="dt-center">Tugas Keuangan</th>
                                                <th class="dt-center">Tugas Administrasi</th>
                                                <?php
                                                if ($_SESSION["jabatan"] == "Petugas Administrasi") {
                                                ?>
                                                    <th class="dt-center">Aksi</th>
                                                <?php } ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $data = $res->fetch_all(MYSQLI_ASSOC);
                                            foreach ($data as $row) {
                                            ?>
                                                <tr>
                                                    <td class="text-center"><?= $row['id_petugas']; ?></td>
                                                    <td><?= $row['nama_petugas']; ?></td>
                                                    <td><?= $row['jabatan']; ?></td>
                                                    <td><?= $row['nama_pengguna']; ?></td>
                                                    <td><?= $row['no_lantai']; ?></td>
                                                    <td><?= $row['pelayanan']; ?></td>
                                                    <td><?= $row['tugas_keuangan']; ?></td>
                                                    <td><?= $row['tugas_administrasi']; ?></td>
                                                    <?php
                                                    if ($_SESSION["jabatan"] == "Petugas Administrasi") {
                                                    ?>
                                                        <td class="text-center">
                                                            <a href="petugas-edit.php?id_petugas=<?= $row['id_petugas'] ?>" class="btn btn-success btn-circle btn-sm">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <!-- <a href="#" class="btn btn-danger btn-circle btn-sm">
                                                        <i class="fas fa-trash"></i>
                                                    </a> -->
                                                        </td>
                                                </tr>
                                        <?php
                                                    }
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