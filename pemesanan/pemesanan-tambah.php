<?php
include_once("../functions.php");
session_start();
if (isset($_SESSION["jabatan"])){
    header("Location: pemesanan-view.php?error=5");
}
$_SESSION["current_page"] = "Pemesanan";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Tambah Pemesanan | Hotel Transylvania</title>
    <!-- <link rel="icon" type="image/x-icon" href="assets/favicon.ico" /> -->
    <?php include_once('../head.php'); ?>
</head>

<body>
    <?php
    if (isset($_POST["tblTambah"])) {
        $db = dbConnect();
        $nik = $db->escape_string($_POST["nik"]);
        $tglCheckin = $_POST["tglCheckin"];
        $waktuCheckin = $_POST["waktuCheckin"];
        $checkin = $db->escape_string($tglCheckin . " " . $waktuCheckin);
        $tglCheckout = $_POST["tglCheckout"];
        $waktuCheckout = $_POST["waktuCheckout"];
        $checkout = $db->escape_string($tglCheckout . " " . $waktuCheckout);
        $noKamar = $db->escape_string($_POST["noKamar"]);
        // $idPetugas = $db->escape_string($_POST["idPetugas"]);
        $banyakOrang = $db->escape_string($_POST["banyakOrang"]);

        $earlier = new DateTime($tglCheckin);
        $later = new DateTime($tglCheckout);

        $abs_diff = $later->diff($earlier)->format("%a");
        // begin validasi
        $salah = "";

        if ($tglCheckin >= date("Y-m-d")) {
            if ($tglCheckin <= $tglCheckout) {
                if ($tglCheckin == $tglCheckout) {
                    if ($waktuCheckin > $waktuCheckout) {
                        $salah .= "Waktu check-in tidak boleh melebihi/melewati waktu check-out.<br>";
                    }
                }
            } else { // tgl checkin melewati atau lebih dari tanggal checkout
                $salah .= "Tanggal check-in tidak boleh melebihi/melewati tanggal check-out.<br>";
            }
        } else { // tanggal checkin sebelum tanggal sekarang
            $salah .= "Tanggal check-in tidak boleh sebelum tanggal hari ini.<br>";
        }

        if ($noKamar == "") {
            $salah .= "Kamar harus dipilih.<br>";
        }

        // if ($idPetugas == "") {
        //     $salah .= "Petugas harus dipilih.<br>";
        // }

    ?>
        <div id="alertBox" class="card shadow-lg bg-light text-center" style="width: 30rem;">
            <?php
            // end validasi
            if ($salah == "") {
            ?>
                <h3 class="card-text">Penyimpanan Data Pemesanan</h3>
                <p class="card-text">Semua data valid.</p>
                <?php
                $query = "INSERT INTO tmemesan(no_kamar, nik, banyak_orang, lama_inap, tgl_check_in, tgl_check_out) 
                            VALUES ('$noKamar', '$nik', $banyakOrang, $abs_diff, '$checkin', '$checkout')
                        ";
                $result = $db->query($query);
                if ($result) {
                    if ($db->affected_rows > 0) {
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
                    echo "Errornya : " . $db->error;
                }
            } else {
                ?>
                <h3 class="card-text">Penyimpanan Data Pemesanan</h3>
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
                <h3>Tambah Data</h3>
                <h6 class="mt-4">
                    <span id="Day"></span>, <span id="Date"></span> - <span id="Time"></span> WIB
                </h6>
                <form method="POST" action="">

                    <!-- Baris 1 -->
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="form-floating m-2">
                                <input type="text" class="form-control" id="NIK" name="nik" placeholder="Banyak Orang" value="<?= $_SESSION["nik"]?>" readonly>
                                <label for="NIK">NIK Pemesan</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating m-2">
                                <input type="text" class="form-control" id="BanyakOrang" name="banyakOrang" placeholder="Banyak Orang" maxlength="2">
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
                                <input type="date" class="form-control" id="TglCheckin" name="tglCheckin" placeholder="Tanggal Check-in">
                                <label for="TglCheckin">Tanggal <i>Check-in</i></label>
                            </div>
                        </div>
                        <!-- Baris 2 Kolom 2 -->
                        <div class="col-md-4">
                            <div class="form-floating m-2">
                                <input type="time" class="form-control" id="WaktuCheckin" name="waktuCheckin" placeholder="Waktu Check-in">
                                <label for="TglCheckin">Waktu <i>Check-in</i></label>
                            </div>
                        </div>
                    </div>
                    <!-- Baris 3 -->
                    <div class="row g-3">
                        <!-- isi data gagal jika hanya salah satu (tanggal/waktu) diisi -->
                        <!-- Baris 3 Kolom 1 -->
                        <div class="col-md-4">
                            <div class="form-floating m-2">
                                <input type="date" class="form-control" id="TglCheckout" name="tglCheckout" placeholder="Tanggal Check-out">
                                <label for="TglCheckout">Tanggal <i>Check-out</i></label>
                            </div>
                        </div>
                        <!-- Baris 3 Kolom 2 -->
                        <div class="col-md-4">
                            <div class="form-floating m-2">
                                <input type="time" class="form-control" id="WaktuCheckout" name="waktuCheckout" placeholder="Waktu Check-out">
                                <label for="TglCheckout">Waktu <i>Check-out</i></label>
                            </div>
                        </div>
                    </div>
                    <!-- Baris 4 -->
                    <div class="row g-3">
                        <!-- Baris 4 Kolom 1 -->
                        <div class="col-md-4">
                            <div class="form-floating m-2">
                                <select class="form-select" id="Kamar" name="noKamar">
                                    <option value="">--Pilih Nomor - Jenis Kamar--</option>
                                    <?php
                                    $data = getList("SELECT * FROM tkamar ORDER BY no_kamar");
                                    foreach ($data as $row) {
                                        echo "<option value=\"" . $row["no_kamar"] . "\">" . $row["no_kamar"] . " - " . $row["jenis_kamar"] . "</option>";
                                    }
                                    ?>
                                </select>
                                <label for="Kamar">Nomor dan Jenis Kamar</label>
                            </div>
                        </div>
                    </div>
                    <!-- Baris 5 -->
                    <div class="row g-3 m-2">
                        <div class="col-md-8">
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary mr-3" name="tblTambah">Tambah</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>