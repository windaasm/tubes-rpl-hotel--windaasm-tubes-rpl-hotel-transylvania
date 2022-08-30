<?php
include_once("../functions.php");
sessionPetugas();
$_SESSION["current_page"] = "Pemesanan";
if ($_SESSION["jabatan"] != "Petugas Resepsionis") {
    header("Location: pemesanan-view.php?error=5");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Edit Kamar | Hotel Transylvania</title>
    <?php include_once "../head.php"; ?>
</head>

<body>
    <?php 
    if(isset($_POST['tblEdit'])) {
        $db = dbConnect();
        $noPemesanan = $db -> escape_string($_POST["noPemesanan"]);
        $idPetugas = $db -> escape_string($_POST["idPetugas"]);
        $tglCheckin = substr($_POST["tglCheckin"], 0, 10);
        $waktuCheckin = substr($_POST["tglCheckin"], 0, -8);
        $tglCheckout = substr($_POST["tglCheckout"], 0, 10);
        $waktuCheckin = substr($_POST["tglCheckout"], 0, -8);
        $checkin = $db -> escape_string($tglCheckin . " " .$waktuCheckin);
        $checkin = $db -> escape_string($tglCheckout . " " .$waktuCheckout);
        
        // begin validasi
        $salah = "";
    
        if ($idPetugas == "") {
            $salah .= "Nama petugas harus dipilih";
        }
        ?>
        <div id="alertBox" class="card shadow-lg bg-light text-center" style="width: 30rem;">
        <?php 
        // end validasi
        if ($salah == "") {
            ?>
            <h3 class="card-text">Edit Data Pemesanan</h3>
            <p class="card-text">Semua data valid.</p>
            <?php
            $query = "UPDATE tmemesan SET id_petugas = '$idPetugas'WHERE no_pemesanan = '$noPemesanan'";
            $result = $db -> query($query);
            if ($result) {
                if ($db -> affected_rows > 0) {
                    ?>
                    <p class="card-text">Data berhasil diubah.</p>
                    <div class="d-flex justify-content-center">
                        <a href="pemesanan-view.php" class="btn btn-primary">Lihat Data</a>
                    </div>
                    <?php
                } else {
                    ?>
                    <p class="card-text">Data berhasil di ubah, tanpa perubahan data.</p>
                    <div class="d-flex justify-content-center">
                        <a href="javascript:history.back()" class="btn btn-primary mx-4">Ubah Kembali</a>
                        <a href="pemesanan-view.php" class="btn btn-primary">Lihat Data</a>
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
            <h3 class="card-text">Edit Data Pemesanan</h3>
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
                <!-- Date & Time -->
                <div class="mt-4 pb-4">
                    <h3>Edit Data</h3>
                    <h6 class="mt-4">
                        <span id="Day"></span>, <span id="Date"></span> - <span id="Time"></span> WIB
                    </h6>    
                </div>
                <div class="row">
                    <div class="col-12 ps-4">
                        <?php
                        if (isset($_GET["no_pemesanan"])) {
                            $db = dbConnect();
                            $noPemesanan = $db -> escape_string($_GET["no_pemesanan"]);
                            $sql = "SELECT p.no_pemesanan, pe.nama_pelanggan, p.banyak_orang, p.lama_inap, p.tgl_check_in, p.tgl_check_out, pee.nama_petugas, pee.id_petugas, k.no_kamar, k.jenis_kamar FROM tmemesan p JOIN tpelanggan pe ON p.nik = pe.nik LEFT JOIN tpetugas pee ON p.id_petugas = pee.id_petugas JOIN tkamar k ON p.no_kamar = k.no_kamar WHERE no_pemesanan = '$noPemesanan'";
                            
                            if ($edit = ambilsatubaris($db, $sql)) {
                        ?>
                        <form method="POST" action="">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="form-floating m-2">
                                        <input type="text" class="form-control" id="noPemesanan" name="noPemesanan" placeholder="Banyak Orang" value="<?= $edit["no_pemesanan"]?>" readonly>
                                        <label for="noPemesanan">No Pemesanan</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating m-2">
                                        <input type="text" class="form-control" id="lamaInap" name="lamaInap" value="<?= $edit["lama_inap"]?>" readonly>
                                        <label for="lamaInap">Lama Inap</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="form-floating m-2">
                                        <input type="text" class="form-control" id="NIK" name="nik" value="<?= $edit["nama_pelanggan"]?>" readonly>
                                        <label for="NIK">Nama Pemesan</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating m-2">
                                        <input type="text" class="form-control" id="BanyakOrang" name="banyakOrang" value="<?= $edit["banyak_orang"]?>" readonly>
                                        <label for="BanyakOrang">Banyak Orang</label>
                                    </div>
                                </div>
                            </div>
                            <!-- Baris 2 -->
                            <div class="row g-3">
                                <!-- isi data gagal jika hanya salah satu (tanggal/waktu) diisi -->
                                <!-- Baris 2 Kolom 1 -->
                                <div class="col-md-4">
                                    <div class="form-floating m-2">
                                        <input type="text" class="form-control" id="TglCheckin" name="tglCheckin" value="<?= $edit["tgl_check_in"]?>" readonly>
                                        <label for="TglCheckin"><i>Check-in</i></label>
                                    </div>
                                </div>
                                <!-- Baris 2 Kolom 2 -->
                                <div class="col-md-4">
                                    <div class="form-floating m-2">
                                        <input type="text" class="form-control" id="TglCheckout" name="tglCheckout" value="<?= $edit["no_kamar"] . ' ' . $edit["jenis_kamar"]?>" readonly>
                                        <label for="Kamar">Nomor dan Jenis Kamar</label>
                                    </div>
                                </div>
                            </div>
                            <!-- Baris 3 -->
                            <div class="row g-3">
                                <!-- isi data gagal jika hanya salah satu (tanggal/waktu) diisi -->
                                <!-- Baris 3 Kolom 1 -->
                                <div class="col-md-4">
                                    <div class="form-floating m-2">
                                        <input type="text" class="form-control" id="TglCheckout" name="tglCheckout" value="<?= $edit["tgl_check_out"]?>" readonly>
                                        <label for="TglCheckout"><i>Check-out</i></label>
                                    </div>
                                </div>
                                <!-- Baris 3 Kolom 2 -->
                                <div class="col-md-4">
                                    <div class="form-floating m-2">
                                        <select class="form-control" id="IdPetugas" name="idPetugas">
                                            <option value="">--Pilih Nama Petugas--</option>
                                            <?php
                                            $data = getList("SELECT * FROM tpetugas ORDER BY nama_petugas");
                                            foreach ($data as $row) {
                                                echo "<option value=\"" . $row["id_petugas"] . "\"";
                                                if ($row["id_petugas"] == $edit["id_petugas"]) {
                                                    echo " selected";
                                                }
                                                echo ">" . $row["nama_petugas"] . "</option>";
                                            }
                                            ?>
                                        </select>
                                        <label for="IdPetugas">Nama Petugas</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-3 m-2">
                                <div class="col-md-8">
                                    <div class="d-flex justify-content-center">
                                        <button type="submit" class="btn btn-primary mr-3" name="tblEdit">Ubah</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <?php
                        }
                        } else {
                            ?>
                            <div class="alert alert-secondary" role="alert">
                            No kamar tidak ditemukan!
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
    <!-- Core theme JS-->
    <script src="../js/scripts.js"></script>
</body>

</html>