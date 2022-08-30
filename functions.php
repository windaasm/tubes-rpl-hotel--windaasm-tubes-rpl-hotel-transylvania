<?php
define("DEVELOPMENT", TRUE);
function dbConnect()
{
	$db = new mysqli("localhost", "root", "", "db_hotel_transylvania"); // Sesuaikan dengan konfigurasi server anda.
	return $db;
}
// getListKategori digunakan untuk mengambil seluruh data dari tabel produk
function session()// untuk akses berdua
{
	session_start();
	if (!isset($_SESSION["nama_pengguna"])) {
		session_destroy();
		header("Location: ../index.php?error=4");
	}
}

function sessionPetugas()
{
	session_start();
	if ($_SESSION["user"] != "Petugas") {
		session_destroy();
		header("Location: ../index.php?error=5");
	}
}

function sessionPelanggan()
{
	session_start();
	if ($_SESSION["user"] != "Pelanggan") {
		session_destroy();
		header("Location: ../index.php?error=5");
	}
}

function getList($query)
{
	$db = dbConnect();
	if ($db->connect_errno == 0) {
		$res = $db->query($query);
		if ($res) {
			$data = $res->fetch_all(MYSQLI_ASSOC);
			$res->free();
			return $data;
		} else
			return FALSE;
	} else
		return FALSE;
}

$db = dbConnect();

function ambilsatubaris($db, $sql)
{
	$db = dbConnect();
	$query = $db->query($sql);
	return mysqli_fetch_assoc($query);
}

function banner()
{
?>
	<div id="banner">
		<h1>Hotel Transylvania</h1>
	</div>
<?php
}

function pagination()
{
	// pagination
	$db = dbConnect();
	$perpage = 4;
	$hasil = $db->query("SELECT * FROM barang");
	$total = $hasil->num_rows;
	$banyakHal = $total / $perpage;
	$page = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
	$start = ($page > 1) ?  ($page * $perpage) - $perpage : 0;
}

function showError($message)
{
?>
	<div style="background-color:#FAEBD7;padding:10px;border:1px solid red;margin:50px 0px">
		<?php echo $message; ?>
	</div>
<?php
}
?>