<?php
include_once("../functions.php");
sessionPetugas();
if ($_SESSION["jabatan"] != "Petugas Administrasi") {
    header("Location: petugas-view.php?error=5");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Edit Petugas | Hotel Transylvania</title>
    <?php include_once "../head.php"; ?>
</head>

<body>
    <?php
    if (isset($_POST['TblEdit'])) {
        $db = dbConnect();
        $id = $db->escape_string(trim($_POST["id_petugas"]));
        $nama = $db->escape_string(trim($_POST["nama_petugas"]));
        $jabatan = $db->escape_string(trim($_POST["jabatan"]));
        $namaPengguna = $db->escape_string(trim($_POST["pengguna"]));
        $kataSandi = $db->escape_string(trim($_POST["katasandi"]));

        $salah = "";
        if (isset($_POST["tugasA"])) {
            $tugas = $db->escape_string(trim($_POST["tugasA"]));
            $col = "tugas_administrasi";
            $col1 = "tugas_keuangan";
            $col2 = "pelayanan";
            $col3 = "no_lantai";
        } else if (isset($_POST["tugasK"])) {
            $tugas = $db->escape_string(trim($_POST["tugasK"]));
            $col = "tugas_keuangan";
            $col1 = "tugas_administrasi";
            $col2 = "pelayanan";
            $col3 = "no_lantai";
        } else if (isset($_POST["tugasR"])) {
            $tugas = $db->escape_string(trim($_POST["tugasR"]));
            $col = "pelayanan";
            $col1 = "tugas_administrasi";
            $col2 = "tugas_keuangan";
            $col3 = "no_lantai";
        } else if (isset($_POST["noLantai"])) {
            $tugas = $db->escape_string(trim($_POST["noLantai"]));
            $col = "no_lantai";
            $col1 = "tugas_administrasi";
            $col2 = "tugas_keuangan";
            $col3 = "pelayanan";
        }

        if (strlen($id) == 0 || strlen($id) < 3 || strlen($id) > 5) {
            $salah .= "Id petugas tidak boleh kosong atau tidak sah.<br>";
        } else {
            $res = $db->query("SELECT * FROM tpetugas WHERE id_petugas='$id'"); // telusuri
            if ($res) {
                $data = $res->fetch_assoc();
                if (!is_numeric(substr($id, 1)) || substr($id, 0, 1) != 'P') {
                    $salah .= "Id petugas harus diawali dengan 'P' kemudian angka.<br>";
                }
            } else {
                $salah .= "Id petugas tidak ditemukan.<br>";
            }
        }

        // $namaPengguna = $db -> escape_string(trim($_POST["fasilitas"]));
        // begin validasi

        if (strlen($nama) == 0 || is_numeric($nama)) {
            $salah .= "Nama tidak boleh kosong dan tidak boleh berupa angka.<br>";
        }

        if ($jabatan == "") {
            $salah .= "Jabatan harus dipilih.<br>";
        }
    ?>
        <div id="alertBox" class="card shadow-lg bg-light text-center" style="width: 30rem;">
            <?php
            // end validasi
            if ($salah == "") {
            ?>
                <h3 class="card-text">Edit Data Petugas</h3>
                <p class="card-text">Semua data valid.</p>
                <?php
                $query = "UPDATE tpetugas SET nama_petugas='$nama', jabatan='$jabatan', $col='$tugas', $col1='', $col2='', $col3='', nama_pengguna='$namaPengguna', kata_sandi='$kataSandi' WHERE id_petugas = '$id'";
                $result = $db->query($query);
                if ($result) {
                    if ($db->affected_rows > 0) {
                ?>
                        <p class="card-text">Data berhasil diubah.</p>
                        <div class="d-flex justify-content-center">
                            <a href="petugas-view.php" class="btn btn-primary">Lihat Data</a>
                        </div>
                    <?php
                    } else {
                    ?>
                        <p class="card-text">Data berhasil di ubah, tanpa perubahan data.</p>
                        <div class="d-flex justify-content-center">
                            <a href="javascript:history.back()" class="btn btn-primary">Ubah Kembali</a>
                            <a href="petugas-view.php" class="btn btn-primary">Lihat Data</a>
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
                <h3 class="card-text">Edit Data petugas</h3>
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
                        <?php
                        if (isset($_GET["id_petugas"])) {
                            $db = dbConnect();
                            $idPetugas = $db->escape_string($_GET["id_petugas"]);
                            $sql = "SELECT * FROM tpetugas WHERE id_petugas = '$idPetugas'";
                            if ($dataPetugas = ambilsatubaris($db, $sql)) {
                        ?>
                                <form method="POST" action="">
                                    <div class="form-group mb-3">
                                        <label for="IdPetugas">ID Petugas</label>
                                        <input type="text" name="id_petugas" class="form-control" id="IdPetugas" placeholder="Id Petugas" value="<?= $dataPetugas["id_petugas"]; ?>" readonly>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="Nama">Nama Petugas</label>
                                        <input type="text" name="nama_petugas" class="form-control" id="Nama" placeholder="Nama" value="<?= $dataPetugas["nama_petugas"]; ?>" maxlength="20">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Jabatan</label>
                                        <select name="jabatan" id="Jabatan" class="form-control" onchange="updateTugasJabatan()">
                                            <option value="">-- Pilih Jabatan --</option>
                                            <option value="Petugas Administrasi">Petugas Administrasi</option>
                                            <option value="Petugas Bagian Keuangan">Petugas Bagian Keuangan</option>
                                            <option value="Petugas Resepsionis">Petugas Resepsionis</option>
                                            <option value="Pramukamar">Pramukamar</option>
                                        </select>
                                        </select>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label id="labelTugasJabatan" for="key"></label>
                                        <input type="text" class="form-control" id="key" name="key" maxlength="20" readonly>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="Nama">Nama Pengguna</label>
                                        <input type="text" name="pengguna" class="form-control" id="NamaPengguna" placeholder="Nama Pengguna" value="<?= $dataPetugas["nama_pengguna"]; ?>" maxlength="10">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="katasandi">Kata Sandi</label>
                                        <input type="password" class="form-control" id="katasandi" name="katasandi" placeholder="Kata Sandi" value="<?= $dataPetugas["kata_sandi"]; ?>" maxlength="8">
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <a href="petugas-view.php" class="mr-3">
                                            <button class="btn btn-secondary mr-3" type="button">Batal</button>
                                        </a>
                                        <button type="submit" class="btn btn-primary mr-3" name="TblEdit">Edit</button>
                                    </div>
                                </form>
                        <?php
                            }
                        } else {
                            echo "ID Petugas tidak ditemukan";
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
    <script src="js/scripts.js"></script>
    <script>
        function updateTugasJabatan() {
            inputTugasJabatan = document.getElementById("key");
            inputTugasJabatan.removeAttribute("readonly");
            var jabatan = document.getElementById("Jabatan").selectedIndex;
            var label = document.getElementById("labelTugasJabatan");
            if (jabatan == 0) {
                label.innerHTML = "(Pilih jabatan dahulu)";
                inputTugasJabatan.readOnly = true;
            } else if (jabatan == 1) {
                label.innerHTML = "Tugas Administrasi";
                inputTugasJabatan.setAttribute("name", "tugasA");
                inputTugasJabatan.setAttribute("maxlength", "20");
                inputTugasJabatan.value = "";
            } else if (jabatan == 2) {
                label.innerHTML = "Tugas Bagian Keuangan";
                inputTugasJabatan.setAttribute("name", "tugasK");
                inputTugasJabatan.setAttribute("maxlength", "20");
                inputTugasJabatan.value = "";
            } else if (jabatan == 3) {
                label.innerHTML = "Pelayanan";
                inputTugasJabatan.setAttribute("name", "tugasR");
                inputTugasJabatan.setAttribute("maxlength", "20");
                inputTugasJabatan.value = "";
            } else if (jabatan == 4) {
                label.innerHTML = "Nomor Lantai";
                inputTugasJabatan.setAttribute("name", "noLantai");
                inputTugasJabatan.setAttribute("maxlength", "1");
                inputTugasJabatan.value = "";
            }
        }
    </script>
</body>

</html>