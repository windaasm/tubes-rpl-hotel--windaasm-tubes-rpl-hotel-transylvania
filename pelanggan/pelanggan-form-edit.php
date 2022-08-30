<?php 
include_once("../functions.php");
session_start();
if (isset($_SESSION["jabatan"])){
    header("Location: pelanggan-view.php?error=5");
}
$_SESSION["current_page"] = "Pelanggan";

if (isset($_POST['tblEdit'])) {
    if ($db->connect_errno == 0) {
        $nik = $db->escape_string($_POST['nik']);
        $nama = $db->escape_string(trim($_POST['nama']));
        $telp = $db->escape_string(trim($_POST['telp']));
        $pengguna = $db->escape_string(trim($_POST['pengguna']));
        $password = $db -> escape_string(trim($_POST['katasandi']));
        // $password = $db->escape_string(trim($_POST['password']));
        $salah = "";
        // $query = $db->query("SELECT * FROM tpelanggan WHERE nik = '$nik'");
        // if ($query->num_rows > 0)
        //     $salah .= "NIK sudah terdaftar.<br>";

        // if (!is_numeric($nik) || strlen($nik) == 0 ||strlen($nik) != 16)
        //     $salah .= "NIK berupa angka 16 digit dan harus diisi.<br>";
    
        if (is_numeric($nama))
            $salah .= "Nama tidak boleh berisi angka.<br>";

        if (!is_numeric($telp))
            $salah .= "Telepon harus berupa angka.<br>";

        if (strlen($pengguna) == 0)
            $salah .= "Nama Pengguna harus diisi.<br>";

        if ($pengguna != $_SESSION["nama_pengguna"]) {
            $query = $db->query("SELECT * FROM tpelanggan WHERE nama_pengguna = '$pengguna'");
            if ($query->num_rows > 0)
                $salah .= "Nama Pengguna sudah terdaftar.<br>";
        }

        if (strlen($password) == 0)
            $salah .= "Kata Sandi harus diisi.<br>";

        ?>
        <div id="alertBox" class="card shadow-lg bg-light text-center" style="width: 30rem;">
        <?php
        if ($salah == "") {
            ?>
            <h3 class="card-text">Edit Profil Pelanggan</h3>
            <p class="card-text">Semua data valid.</p>
            <?php
            $query = "UPDATE tpelanggan SET nama_pelanggan = '$nama', telepon = '$telp', nama_pengguna = '$pengguna', kata_sandi = '$password' WHERE nik = '$nik'";
            $res =  $db->query($query);
            if ($res) {
                if ($db->affected_rows > 0) {
                    ?>
                    <p class="card-text">Data berhasil diubah.</p>
                    <div class="d-flex justify-content-center">
                        <a href="pelanggan-view.php" class="btn btn-primary">Lihat Profil</a>
                    </div>
                <?php
                } else {
                    ?>
                    <p class="card-text">Data berhasil di ubah, tanpa perubahan data.</p>
                    <div class="d-flex justify-content-center">
                        <a href="javascript:history.back()" class="btn btn-secondary mx-4">Ubah Kembali</a>
                        <a href="pelanggan-view.php" class="btn btn-primary">Lihat Profil</a>
                    </div>
                    <?php
                }
            } else {
                ?>
                <p class="card-text">Data gagal disimpan.</p>
                <div class="d-flex justify-content-center">
                    <a href="javascript:history.back()" class="btn btn-primary">Kembali</a>
                </div>
                <?php
                echo "Errornya : " . $db -> error;
            }
        } else {
            ?>
            <h3 class="card-text">Edit Profil Pelanggan</h3>
            <p class="card-text">Berikut kesalahan - kesalahan dalam validasi : </p>
            <p class="card-text"><?= $salah; ?></p>
            <div class="d-flex justify-content-center">
                <a href="javascript:history.back()" class="btn btn-primary">Kembali</a>
            </div>
            <?php
        }
    } else
        echo "Gagal koneksi" . (DEVELOPMENT ? " : " . $db->connect_error : "") . "<br>";
}
?>
</div>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Edit Pelanggan | Hotel Transylvania</title>
        <?php include_once "../head.php"; ?>
    </head>
    <body>
        <div class="d-flex" id="wrapper">
            <?php include_once("../sidebar-pelanggan.php"); ?>

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
                    <h6 class="my-4">
                        <span id="Day"></span>, <span id="Date"></span> - <span id="Time"></span> WIB
                    </h6>
                    <div class="row">
                        <div class="mx-3">
                            <h4>Edit Profil Pelanggan</h4>
                        </div>
                        <div class="col-6 ps-4">
                            <?php
                            if (isset($_GET["nik"])) {
                                $db = dbConnect();
                                $nik = $db -> escape_string($_GET["nik"]);
                                $sql = "SELECT * FROM tpelanggan WHERE nik = '$nik'";
                                if ($edit = ambilsatubaris($db, $sql)) {
                                    ?> 
                                    <form method="POST" action="">
                                        <div class="form-group mb-3">
                                            <label for="nik">NIK</label>
                                            <input type="text" class="form-control" id="nik" name="nik" maxlength="16" placeholder="Format NIK 16 digit angka. Contoh 31xxxxxxxxxxxxxx" value="<?= $edit["nik"]; ?>" readonly>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="nama">Nama</label>
                                            <input type="text" class="form-control" id="nama" name="nama" maxlength="30" placeholder="Nama Pelanggan" value="<?= $edit["nama_pelanggan"]; ?>">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="telp">No Telepon</label>
                                            <input type="text" class="form-control" id="telp" name="telp"  maxlength="13"placeholder="Format No Telp 08xxx atau 628xxxx" value="<?= $edit["telepon"]; ?>">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="pengguna">Nama Pengguna</label>
                                            <input type="text" class="form-control" id="pengguna" name="pengguna" maxlength="10" placeholder="Nama Pengguna" value="<?= $edit["nama_pengguna"]; ?>">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="katasandi">Kata Sandi</label>
                                            <input type="password" class="form-control" id="katasandi" name="katasandi" maxlength="8" placeholder="Kata Sandi" value="<?= $edit["kata_sandi"]; ?>">
                                        </div>
                                        <div class="d-flex justify-content-center">
                                            <a href=javascript:history.back(); class="p-3">
                                                <button class="btn btn-secondary" type="button">Kembali</button>
                                            </a>
                                            <a class="p-3"><button type="submit" class="btn btn-primary mr-3" name="tblEdit">Ubah</button></a>
                                        </div>
                                    </form>
                                    <?php
                                }
                            } else {
                                ?>
                                <div class="alert alert-secondary" role="alert">
                                    NIK tidak ditemukan
                                </div>
                                <?php
                            }
                            ?>
                        </div>  
                    </div>
                </div>
            </div>
        </div>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
