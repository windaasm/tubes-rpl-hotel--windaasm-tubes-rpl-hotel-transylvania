<?php include_once("functions.php"); ?>
<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

	<title>Hotel Transylvania</title>
</head>

<body>
	<!-- Optional JavaScript; choose one of the two! -->

	<!-- Option 1: Bootstrap Bundle with Popper -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

	<!-- Option 2: Separate Popper and Bootstrap JS -->
	<!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
	<!-- banner -->
	<div class="banner">
		<nav class="navbar navbar-expand-lg fixed-top navbar-dark shadow-sm bg-primary">
			<div class="container-fluid justify-content-center">
				<a class="navbar-brand" href="#">Hotel Transylvania</a>
			</div>
		</nav>
	</div>
	<div>
		<img src="" alt="GAMBAR">
	</div>

	<div class="container py-5 h-100" style="width: 800px;">
		<div class="row d-flex justify-content-center align-items-center h-100">
			<div class="card p-5" style="opacity: 0.9;">
				<div class="row m-2">
					<div class="col">
						<!-- <button class="btn btn-primary"></button> -->
						<a href="registrasi.php"><button class="btn btn-primary">Registrasi</button></a>
					</div>
				</div>
				<div class="row m-2">
					<div class="col">
						<form method="post" name="f" action="login.php">
							<div class="login-layout text-center">
								<h4>LOGIN</h4>
								<?php
								if (isset($_GET["error"])) {
									$error = $_GET["error"];
									if ($error == 1)
										showError("Nama Pengguna dan Kata Sandi tidak sesuai.");
									else if ($error == 2)
										showError("Error database. Silahkan hubungi administrator");
									else if ($error == 3)
										showError("Koneksi ke Database gagal. Autentikasi gagal.");
									else if ($error == 4)
										showError("Anda tidak boleh mengakses halaman sebelumnya karena belum login. Silahkan
														login terlebih dahulu.");
									else if ($error == 5)
										showError("Anda tidak memiliki hak untuk mengakses halaman sebelumnya");
									else
										showError("Unknown Error.");
								}
								?>
								<div class="mb-3 text-start">
									<label for="nama_pengguna" class="form-label">Nama Pengguna</label>
									<input type="text" class="form-control" id="nama_pengguna" name="nama_pengguna" placeholder="Masukkan Nama Pengguna" maxlength="10">
								</div>
								<div class="mb-3 text-start">
									<label for="kata_sandi" class="form-label">Kata Sandi</label>
									<input type="password" class="form-control" id="kata_sandi" name="kata_sandi" placeholder="Masukkan Kata Sandi" maxlength="8">
								</div>
								<div class="mb-3 text-start form-check">
									<label class="form-check-label">Lihat Kata Sandi</label>
									<input type="checkbox" onclick="lihatpassword()" class="form-check-input">
								</div>
								<div class="d-flex justify-content-center">
									<button type="submit" name="btn_login" class="btn btn-primary">Login</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		function lihatpassword() {
			var pass = document.getElementById('kata_sandi');
			if (pass.type == 'password') {
				pass.type = "text";
			} else {
				pass.type = 'password';
			}
		}
	</script>
</body>

</html>