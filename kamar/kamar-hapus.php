<?php
include_once("../functions.php");
sessionPetugas();
$_SESSION["current_page"] = "Kamar";
if ($_SESSION["jabatan"] != "Petugas Administrasi") {
    header("Location: kamar-view.php?error=5");
}

$no = $_GET['no_kamar'];

$sql = "DELETE FROM tkamar WHERE no_kamar ='$no'";

$db = dbConnect();
$res = $db->query($sql);

if($res){
    ?>
    <div class="alert alert-danger d-flex align-items-center" role="alert">
				<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
				<div>
					Data berhasil dihapus.<br>
				</div>
	</div>
    <?php
    header('Location: kamar-view.php');
}
else
?>
<div class="alert alert-danger d-flex align-items-center" role="alert">
				<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
				<div>
					Data gagal dihapus.<br>
				</div>
</div>
