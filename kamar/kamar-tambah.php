<?php 
include_once("../functions.php");
sessionPetugas();
$_SESSION["current_page"] = "Kamar";
if ($_SESSION["jabatan"] != "Petugas Administrasi") {
    header("Location: kamar-view.php?error=5");
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Tambah Kamar | Hotel Transylvania</title>
        <?php include_once "../head.php"; ?>
    </head>
    <body>
        <!-- <article id="article" class="alert-box-hide"> -->
        <?php 
        if(isset($_POST['tblTambah'])) {
            $db = dbConnect();
            $noKamar = $db -> escape_string(trim($_POST["noKamar"]));
            $jenisKamar = $db -> escape_string($_POST["jenisKamar"]);
            $status = $db -> escape_string($_POST["status"]);
            $fasilitas = $db -> escape_string(trim($_POST["fasilitas"]));
            $harga = $db -> escape_string($_POST["harga"]);
            // begin validasi
            $salah = "";
            if (substr($noKamar, 0, 1) == 0) {
                $salah .= "Digit pertama nomor kamar tidak boleh diisi angka nol.<br>";
            } else if ( strlen($noKamar) == 0 || strlen($noKamar) > 3) {
                $salah .= "Nomor kamar tidak boleh kosong atau lebih dari 3 digit.<br>";
            } else {
                $res = $db -> query("SELECT COUNT(*) data FROM tkamar WHERE no_kamar = '$noKamar'"); // telusuri
                if ($res) {
                    $data = $res -> fetch_assoc();
                    if ($data["data"]) {
                        $salah .= "Nomor kamar sudah ada.<br>";
                    } elseif (!is_numeric($noKamar)) {
                        $salah .= "Nomor kamar harus berupa angka.<br>";
                    } 
                } else {
                    $salah .= "Nomor kamar tidak ditemukan.<br>";
                }
            }

            if ( is_numeric($fasilitas)) {
                $salah .= "Fasilitas tidak boleh berupa angka saja.<br>";
            }
        
            if ( !is_numeric($harga)) {
                $salah .= "Harga harus berupa angka.<br>";
            }
            ?>
            <div id="alertBox" class="card shadow-lg bg-light text-center" style="width: 30rem;">
            <?php 
            // end validasi
            if ($salah == "") {
                ?>
                    <h3 class="card-text">Penyimpanan Data Kamar</h3>
                    <p class="card-text">Semua data valid.</p>
                    <?php
                    $query = "INSERT INTO tkamar VALUES ('$noKamar','$jenisKamar','$status','$fasilitas','$harga')";
                    $result = $db -> query($query);
                    if ($result) {
                        if ($db -> affected_rows > 0) {
                            ?>
                            <p class="card-text">Data berhasil ditambahkan.</p>
                            <div class="d-flex justify-content-center">
                                <a href="kamar-view.php" class="btn btn-primary">Lihat Data</a>
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
                <h3 class="card-text">Penyimpanan Data Kamar</h3>
                <p class="card-text">Berikut kesalahan - kesalahan dalam validasi : </p>
                <p class="card-text"><?= $salah; ?></p>
                <div class="d-flex justify-content-center">
                    <a href="javascript:history.back()" class="btn btn-primary">Kembali</a>
                </div>
                <?php
            }
            ?>
            </div>
            <?php
        }
        ?>
        <!-- </article> -->
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
                    <div class="row">
                        <div class="col-6 ps-4">
                            <form method="POST" action="">
                                <div class="form-group mb-3">
                                    <label for="NoKamar">No Kamar</label>
                                    <input type="text" class="form-control" id="NoKamar" name="noKamar" placeholder="No Kamar" maxlength="3" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Jenis Kamar</label>
                                    <select name="jenisKamar" class="form-control">
                                        <option value="">-- Pilih Jenis --</option>
                                        <option value="Standar">Standar</option>
                                        <option value="Single">Single</option>
                                        <option value="Double">Double</option>
                                        <option value="Family">Family</option>
                                        <option value="Suite">Suite</option>
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="Status">Status</label>
                                    <select name="status" id="Status" class="form-control">
                                        <option value="">-- Pilih Status --</option>
                                        <option value="Lengkap">Lengkap</option>
                                        <option value="Tidak Lengkap">Tidak Lengkap</option>
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="Fasilitas">Fasilitas</label>
                                    <input type="text" name="fasilitas" class="form-control" id="Fasilitas" placeholder="Fasilitas" maxlength="20">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="Harga">Harga</label>
                                    <input type="text" name="harga" class="form-control" id="Harga" placeholder="Harga" maxlength="13">
                                </div>
                                <div class="d-flex justify-content-center">
                                    <button id="tblTambah" type="submit" class="btn btn-primary mr-3" name="tblTambah">Tambah</button>
                                </div>
                            </form>
                        </div>  
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
