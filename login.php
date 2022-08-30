<?php
session_start();
$db = mysqli_connect('localhost', 'root', '', 'db_hotel_transylvania');

$nama_pengguna = $db->escape_string(trim($_POST['nama_pengguna']));
$kata_sandi = $db->escape_string(trim($_POST['kata_sandi']));
$query = "SELECT * FROM tpetugas WHERE nama_pengguna='$nama_pengguna' AND kata_sandi='$kata_sandi'";
$row = mysqli_query($db, $query);
$data = mysqli_fetch_assoc($row);


if (isset($_POST["btn_login"])) {
    if ($row -> num_rows > 0) {
        if ($kata_sandi == $data['kata_sandi']) {
            $_SESSION['nama_pengguna'] = $data['nama_pengguna'];
            $_SESSION['jabatan'] = $data['jabatan'];
            $_SESSION['user'] = "Petugas";
            header('Location: pemesanan/pemesanan-view.php');
        } else {
            header('Location: index.php?error=1');
        }
    } else {
        $query2 = "SELECT * FROM tpelanggan WHERE nama_pengguna='$nama_pengguna' AND kata_sandi='$kata_sandi'";
        $row2 = mysqli_query($db, $query2);
        $data2 = mysqli_fetch_assoc($row2);
        if ($row2 -> num_rows > 0) {
            if ($kata_sandi == $data2['kata_sandi']) {
                $_SESSION['nama_pengguna'] = $data2['nama_pengguna'];
                $_SESSION['nama_pelanggan'] = $data2['nama_pelanggan'];
                $_SESSION['nik'] = $data2['nik'];
                $_SESSION['user'] = "Pelanggan";
                header('Location: kamar/kamar-view.php');
            } else {
                header('Location: index.php?error=1');
            }
        } else {
            header('Location: index.php?error=1');
        }
    }
} else {
    header('Location: index.php?error=4');
}
