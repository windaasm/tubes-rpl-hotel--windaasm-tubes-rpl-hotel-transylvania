<?php
include_once("functions.php");
$db = dbConnect();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi | Hotel Transylvania</title>
    <?php include_once('head.php'); ?>
</head>
<body>
    <?php
    if (isset($_POST["btn_Regis"])) {
        $nik = $db->escape_string(trim($_POST['nik']));
        $nama = $db->escape_string(trim($_POST['nama']));
        $telp = $db->escape_string(trim($_POST['telp']));
        $pengguna = $db->escape_string(trim($_POST['pengguna']));
        $password = $db->escape_string(trim($_POST['katasandi']));

        $salah = "";

        $query = $db->query("SELECT * FROM tpelanggan WHERE nik = '$nik'");
        if ($query->num_rows > 0)
            $salah .= "NIK sudah terdaftar.<br>";

        if (!is_numeric($nik) || strlen($nik) == 0 ||strlen($nik) != 16)
            $salah .= "NIK berupa angka 16 digit dan harus diisi.<br>";

        if (is_numeric($nama))
            $salah .= "Nama tidak boleh berisi angka.<br>";

        if (!is_numeric($telp))
            $salah .= "Telepon harus berupa angka.<br>";

        if (strlen($pengguna) == 0)
            $salah .= "Nama Pengguna harus diisi.<br>";

        $query = $db->query("SELECT * FROM tpelanggan WHERE nama_pengguna = '$pengguna'");
        if ($query->num_rows > 0)
            $salah .= "Nama Pengguna sudah terdaftar.<br>";
            
        if (strlen($password) == 0)
            $salah .= "Kata Sandi harus diisi.<br>";
        ?>
        <div class="position-absolute top-50 start-50 translate-middle">
        <?php
        if ($salah == "") {
            ?>
            <div class="alert alert-primary" role="alert">
                Semua data valid, berhasil melakukan registrasi.
            </div>
            <?php
            $query = "INSERT INTO tpelanggan VALUES ('$nik','$nama','$telp','$pengguna', '$password')";
            $res =  $db->query($query);
            if ($res) {
                if ($db->affected_rows > 0) {
                    ?>
                    <div class="d-flex justify-content-center">
                        <div class="alert alert-primary" role="alert">
                            <p>
                                Data berhasil disimpan.
                            </p>
                            <a href="index.php" class="btn btn-primary">Kembali Ke Login</a>
                        </div>
                    </div>
                    <?php
                }
            } else {
                ?>
                Data gagal disimpan karena terdapat kesalahan. Silahkan coba lagi.<br>
                <a href=javascript:history.back(); class="btn btn-dark">Kembali</a>
                <?php
            }
        } else {
            ?>
            <div class="card text-center" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title fs-5">Terjadi kesalahan sebagai berikut</h5>
                    <p class="card-text"><?= $salah; ?></p>
                    <a href=javascript:history.back(); class="btn btn-primary">Kembali Ke Form</a>
                </div>`
            </div>
            <?php
        }
    } else {
        header("Location: registrasi.php");
    } 
    ?>
    </div>
</body>
</html>
