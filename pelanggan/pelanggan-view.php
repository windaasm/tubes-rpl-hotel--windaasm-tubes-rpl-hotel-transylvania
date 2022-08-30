<?php
include_once("../functions.php");
session();
$_SESSION["current_page"] = "Pelanggan";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Pelanggan | Hotel Transylvania</title>
    <!-- Core theme CSS (includes Bootstrap)-->
    <?php include_once('../head.php'); ?>
    <style>
        input[readonly] {
            background-color: white !important;
        }
    </style>
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
                <!-- DataTales Example -->
                <?php
                if ($_SESSION["user"] == "Petugas") {
                ?>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Pelanggan</h6>
                        </div>
                        <div class="card-body">
                            <?php
                            $db = dbConnect();
                            if ($db->connect_errno == 0) {
                                $sql = "SELECT * FROM tpelanggan";
                                $res = $db->query($sql);
                                if ($res) {
                            ?>
                                    <!-- <a href="pelanggan-tambah.php"><button type="button" class="btn btn-outline-primary rounded btn-sm mb-3">Tambah</button></a> -->
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped" id="example" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th class="dt-center">NIK</th>
                                                    <th class="dt-center">Nama Pelanggan</th>
                                                    <th class="dt-center">Telepon</th>
                                                    <th class="dt-center">Nama Pengguna</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $data = $res->fetch_all(MYSQLI_ASSOC);
                                                foreach ($data as $row) {
                                                ?>
                                                    <tr>
                                                        <td class="text-center"><?= $row['nik']; ?></td>
                                                        <td><?= $row['nama_pelanggan']; ?></td>
                                                        <td class="text-center"><?= $row['telepon']; ?></td>
                                                        <td><?= $row['nama_pengguna']; ?></td>
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
                    <?php
                } else {
                    $user = $_SESSION["nama_pengguna"];
                    $query = "SELECT * FROM tpelanggan WHERE nama_pengguna = '$user'";
                    if ($show = ambilsatubaris($db, $query)) {
                    ?>
                        <div class="container rounded bg-white">
                            <div class="row">
                                <div class="col-md-5 border-right">
                                    <div class="d-flex justify-content-between align-items-center my-3">
                                        <h4 class="text-right">Profil Pelanggan</h4>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="NIK" class="labels">NIK</label>
                                            <input type="text" id="NIK" class="form-control" readonly value="<?= $show["nik"] ?>">
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="pengguna" class="labels">Nama Pengguna</label>
                                            <input type="text" id="pengguna" class="form-control" value="<?= $show["nama_pelanggan"] ?>" readonly>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="telepon" class="labels">Telepon</label>
                                            <input type="text" id="telepon" class="form-control" value="<?= $show["telepon"] ?>" readonly>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="nama" class="labels">Nama Pengguna</label>
                                            <input type="text" id="nama" class="form-control" value="<?= $show["nama_pengguna"] ?>" readonly>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="sandi" class="labels">Kata Sandi</label>
                                            <input type="password" class="form-control" id="sandi" value="<?= $show["kata_sandi"] ?>" readonly>
                                        </div>
                                        <div class="col">
                                            <div class="text-start form-check">
                                                <label class="form-check-label">Lihat Kata Sandi</label>
                                                <input type="checkbox" onclick="lihatPassword()" class="form-check-input">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="mt-3 text-center">
                                                <a href=javascript:history.back(); class="p-3">
                                                    <button class="btn btn-secondary" type="button">Kembali</button>
                                                </a>
                                                <a href="pelanggan-form-edit.php?nik=<?= $show["nik"]; ?>" class="p-3">
                                                    <button class="btn btn-primary" type="button">Masuk Form Ubah</button>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function lihatPassword() {
            var pass = document.getElementById('sandi');
            if (pass.type == 'password') {
                pass.type = "text";
            } else {
                pass.type = 'password';
            }
        }
    </script>
</body>

</html>