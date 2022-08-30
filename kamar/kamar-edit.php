<?php
include_once("../functions.php");
sessionPetugas();
$_SESSION["current_page"] = "Kamar";
if ($_SESSION["jabatan"] != "Petugas Administrasi" && $_SESSION["jabatan"] != "Pramukamar") {
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
    <title>Edit Kamar | Hotel Transylvania</title>
    <?php include_once "../head.php"; ?>
</head>

<body>
    <?php 
    if(isset($_POST['tblEdit'])) {
        $db = dbConnect();
        $noKamar = $db -> escape_string(trim($_POST["noKamar"]));
        $jenisKamar = $db -> escape_string($_POST["jenisKamar"]);
        $status = $db -> escape_string($_POST["status"]);
        $fasilitas = $db -> escape_string(trim($_POST["fasilitas"]));
        $harga = $db -> escape_string($_POST["harga"]);
        // begin validasi
        $salah = "";
    
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
            <h3 class="card-text">Edit Data Kamar</h3>
            <p class="card-text">Semua data valid.</p>
            <?php
            $query = "UPDATE tkamar SET no_kamar = '$noKamar', jenis_kamar = '$jenisKamar', status = '$status', fasilitas = '$fasilitas', harga = '$harga' WHERE no_kamar = '$noKamar'";
            $result = $db -> query($query);
            if ($result) {
                if ($db -> affected_rows > 0) {
                    ?>
                    <p class="card-text">Data berhasil diubah.</p>
                    <div class="d-flex justify-content-center">
                        <a href="kamar-view.php" class="btn btn-primary">Lihat Data</a>
                    </div>
                    <?php
                } else {
                    ?>
                    <p class="card-text">Data berhasil di ubah, tanpa perubahan data.</p>
                    <div class="d-flex justify-content-center">
                        <a href="javascript:history.back()" class="btn btn-primary mx-4">Ubah Kembali</a>
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
            <h3 class="card-text">Edit Data Kamar</h3>
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
                    <h6 class="mt-4">
                        <span id="Day"></span>, <span id="Date"></span> - <span id="Time"></span> WIB
                    </h6>    
                </div>
                <div class="row">
                    <div class="col-6 ps-4">
                        <?php
                        if (isset($_GET["no_kamar"])) {
                            $db = dbConnect();
                            $noKamar = $db -> escape_string($_GET["no_kamar"]);
                            $sql = "SELECT * FROM tkamar WHERE no_kamar = '$noKamar'";
                            if ($edit = ambilsatubaris($db, $sql)) {
                        ?>
                        <form method="POST" action="">
                            <div class="form-group mb-3">
                                <label for="NoKamar">No Kamar</label>
                                <input type="text" class="form-control" id="NoKamar" name="noKamar" placeholder="No Kamar" value="<?= $edit["no_kamar"]; ?>" readonly>
                            </div>
                            <div class="form-group mb-3">
                                <label>Jenis Kamar</label>
                                <select name="jenis_kamar" class="form-control">
                                    <?php 
                                    $JenisKamar = getList("SELECT DISTINCT jenis_kamar FROM tkamar");
                                    foreach($JenisKamar as $row) {
                                        if ($row["jenis_kamar"] == $edit['jenis_kamar']) {
                                            echo "<option value='" . $row["jenis_kamar"] . "' selected>" . $row["jenis_kamar"] . "</option>";
                                        } else {
                                            echo "<option value='" . $row["jenis_kamar"] . "'>" . $row["jenis_kamar"] . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label>Status</label>
                                <select name="status" class="form-control">
                                    <?php 
                                    $Status = getList("SELECT DISTINCT status FROM tkamar");
                                    foreach($Status as $row) {
                                        if ($row["status"] == $edit['status']) {
                                            echo "<option value='" . $row["status"] . "' selected>" . $row["status"] . "</option>";
                                        } else {
                                            echo "<option value='" . $row["status"] . "'>" . $row["status"] . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="Fasilitas">Fasilitas</label>
                                <input type="text" class="form-control" id="Fasilitas" name="fasilitas" placeholder="Fasilitas" value="<?= $edit["fasilitas"]; ?>" maxlength="20">
                            </div>
                            <div class="form-group mb-3">
                                <label for="Harga">Harga</label>
                                <input type="text" class="form-control" id="Harga" name="harga" placeholder="Harga" value="<?= $edit["harga"]; ?>" maxlength="13">
                            </div>
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary mr-3" name="tblEdit">Ubah</button>
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