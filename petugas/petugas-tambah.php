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
    <title>Tambah Petugas | Hotel Transylvania</title>
    <?php include_once "../head.php"; ?>
</head>

<body>
    <?php
    if (isset($_POST['tblTambah'])) {
        $db = dbConnect();
        $id = $db->escape_string(trim($_POST["id"]));
        $nama = $db->escape_string(trim($_POST["nama"]));
        $jabatan = $db->escape_string(trim($_POST["jabatan"]));
        $namaPengguna = $db->escape_string(trim($_POST["pengguna"]));
        $kataSandi = $db->escape_string(trim($_POST["katasandi"]));

        if (isset($_POST["tugasA"])) {
            $tugas = $db->escape_string(trim($_POST["tugasA"]));
            $col = "tugas_administrasi";
        } else if (isset($_POST["tugasK"])) {
            $tugas = $db->escape_string(trim($_POST["tugasK"]));
            $col = "tugas_keuangan";
        } else if (isset($_POST["tugasR"])) {
            $tugas = $db->escape_string(trim($_POST["tugasR"]));
            $col = "pelayanan";
        } else if (isset($_POST["noLantai"])) {
            $tugas = $db->escape_string(trim($_POST["noLantai"]));
            $col = "no_lantai";
        }
        // $namaPengguna = $db -> escape_string(trim($_POST["fasilitas"]));
        // begin validasi
        $salah = "";
        if (strlen($id) == 0 || strlen($id) < 3 || strlen($id) > 5) {
            $salah .= "Id petugas tidak boleh kosong atau tidak sah.<br>";
        } else {
            $res = $db->query("SELECT COUNT(*) data FROM tpetugas WHERE id_petugas = '$id'"); // telusuri
            if ($res) {
                $data = $res->fetch_assoc();
                if ($data["data"]) {
                    $salah .= "Id petugas sudah ada.<br>";
                } elseif (!is_numeric(substr($id, 1)) || substr($id, 0, 1) != 'P') {
                    $salah .= "Id petugas harus diawali dengan 'P' kemudian angka.<br>";
                }
            } else {
                $salah .= "Id petugas tidak ditemukan.<br>";
            }
        }

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
                <h3 class="card-text">Penyimpanan Data Petugas</h3>
                <p class="card-text">Semua data valid.</p>
                <?php
                $query = "INSERT INTO tpetugas(id_petugas, nama_petugas, jabatan, $col, nama_pengguna, kata_sandi) VALUES ('$id','$nama','$jabatan', '$tugas', '$namaPengguna', '$kataSandi')";
                $result = $db->query($query);
                if ($result) {
                    if ($db->affected_rows > 0) {
                ?>
                        <p class="card-text">Data berhasil ditambahkan.</p>
                        <div class="d-flex justify-content-center">
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
                <h3 class="card-text">Penyimpanan Data Petugas</h3>
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
                        <form method="POST" name="form" action="">
                            <div class="form-group mb-3">
                                <label for="IdPetugas">ID Petugas</label>
                                <input type="text" class="form-control" id="IdPetugas" name="id" maxlength="5" placeholder="Format ID Petugas huruf P diikuti 4 angka. Contoh P1234">
                            </div>
                            <div class="form-group mb-3">
                                <label for="NamaPetugas">Nama Petugas</label>
                                <input type="text" class="form-control" id="NamaPetugas" maxlength="30" name="nama" placeholder="Nama Petugas">
                            </div>
                            <div class="form-group mb-3">
                                <label for="Jabatan">Jabatan</label>
                                <select name="jabatan" id="Jabatan" class="form-control" onchange="updateTugasJabatan()">
                                    <option value="">-- Pilih Jabatan --</option>
                                    <option value="Petugas Administrasi">Petugas Administrasi</option>
                                    <option value="Petugas Bagian Keuangan">Petugas Bagian Keuangan</option>
                                    <option value="Petugas Resepsionis">Petugas Resepsionis</option>
                                    <option value="Pramukamar">Pramukamar</option>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label id="labelTugasJabatan" for="key"></label>
                                <input type="text" class="form-control" id="key" name="key" maxlength="20" readonly>
                            </div>
                            <div class="mb-3 text-start">
                                <label for="nama_pengguna" class="form-label">Nama Pengguna</label>
                                <input type="text" class="form-control" id="nama_pengguna" name="pengguna" placeholder="Masukkan Nama Pengguna" maxlength="10" required>
                            </div>
                            <div class="mb-3 text-start">
                                <label for="kata_sandi" class="form-label">Kata Sandi</label>
                                <input type="password" class="form-control" id="kata_sandi" name="katasandi" placeholder="Masukkan Kata Sandi" maxlength="8" required>
                            </div>
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary mr-3" name="tblTambah">Tambah</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
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