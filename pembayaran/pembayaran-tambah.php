<?php 
include_once("../functions.php");
sessionPetugas();
$_SESSION["current_page"] = "Pembayaran"; 
if ($_SESSION["jabatan"] != "Petugas Bagian Keuangan") {
    header("Location: pembayaran-view.php?error=5");
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Tambah Pembayaran | Hotel Transylvania</title>
        <!-- <link rel="icon" type="image/x-icon" href="assets/favicon.ico" /> -->
        <?php include_once('../head.php'); ?>
    </head>
    <body>
        <?php 
        if(isset($_POST['tblTambah'])) {
            $db = dbConnect();
            // $noPembayaran = $db -> escape_string($_POST["noPembayaran"]);
            $opsiBayar = $db -> escape_string($_POST["opsiBayar"]);
            $nilaiBayar = $db -> escape_string($_POST["nilaiBayar"]);
            $noPemesanan = $db -> escape_string($_POST["noPemesanan"]);
            // begin validasi
            $salah = "";
            
            if (!is_numeric($nilaiBayar)) {
                $salah .= "Nilai bayar harus berupa angka.<br>";
            }           
            ?>
            <div id="alertBox" class="card shadow-lg bg-light text-center" style="width: 30rem;">
            <?php 
            // end validasi
            if ($salah == "") {
                ?>
                    <h3 class="card-text">Penyimpanan Data Pembayaran</h3>
                    <p class="card-text">Semua data valid.</p>
                    <?php
                    $query = "INSERT INTO tpembayaran VALUES ('$noPembayaran', '$opsiBayar', '$nilaiBayar', '$noPemesanan')";
                    $result = $db -> query($query);
                    if ($result) {
                        if ($db -> affected_rows > 0) {
                            ?>
                            <p class="card-text">Data berhasil ditambahkan.</p>
                            <div class="d-flex justify-content-center">
                                <a href="pembayaran-view.php" class="btn btn-primary">Lihat Data</a>
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
                <h3 class="card-text">Penyimpanan Data Pembayaran</h3>
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
                                    <label for="OpsiBayar">Opsi Bayar</label>
                                    <select class="form-control" id="OpsiBayar" name="opsiBayar" placeholder="Opsi Bayar">
                                        <option value="">Pilih Opsi Bayar</option>
                                        <option value="Tunai">Tunai</option>
                                        <option value="Non Tunai">Non Tunai</option>
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="nilaiBayar">Nilai Bayar</label>
                                    <input type="text" class="form-control" id="nilaiBayar" name="nilaiBayar" placeholder="0" maxlength="7">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="Status">Pemesanan</label>
                                    <select class="form-select" id="noPemesanan" name="noPemesanan">
                                        <option value="">Pilih Pemesanan</option>
                                        <?php
                                            $dataPesan = getList("SELECT p.no_pemesanan, t.nama_pelanggan FROM tmemesan p JOIN tpelanggan t ON t.nik = p.nik ORDER BY no_pemesanan"); 
                                            foreach ($dataPesan as $row) {
                                                echo "<option value=\"" . $row["no_pemesanan"] . "\">" . $row["no_pemesanan"] . " - " . $row["nama_pelanggan"] . "</option>";
                                            }
                                        ?>
                                    </select>
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
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
