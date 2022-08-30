<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

	<title>Hotel Transylvania</title>
</head>

<body>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
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
                        <a href="index.php"><button class="btn btn-primary">Login</button></a>
                    </div>
                </div>
                <div class="row m-2">
                    <div class="col">
                        <div class="login-layout text-center">
                            <h4>REGISTRASI</h4>
                            <form method="POST" action="do-regis.php"  class="was-validated">
                                <div class="mb-3 text-start">
                                    <label for="nik" class="form-label">NIK</label>
                                    <input type="text" class="form-control" id="nik" name="nik" placeholder="Masukkan NIK" maxlength="16" required>
								<div class="invalid-feedback">
                                    Harap isi NIK
                                </div>
								</div>
                                <div class="mb-3 text-start">
                                    <label for="Nama" class="form-label">Nama Pelanggan</label>
                                    <input type="text" class="form-control" id="Nama" name="nama" placeholder="Masukkan Nama" maxlength="30" required>
                                <div class="invalid-feedback">
									Harap isi Nama
								</div>
								</div>
                                <div class="mb-3 text-start">
                                    <label for="telp" class="form-label">No Telepon</label>
                                    <input type="text" class="form-control" id="telp" name="telp" placeholder="Masukkan No Telp" maxlength="13" required>
                                <div class="invalid-feedback">
									Harap isi No Telp
								</div>
								</div>
                                <div class="mb-3 text-start">
                                    <label for="nama_pengguna" class="form-label">Nama Pengguna</label>
                                    <input type="text" class="form-control" id="nama_pengguna" name="pengguna" placeholder="Masukkan Nama Pengguna" maxlength="10" required>
								<div class="invalid-feedback">
									Harap isi Nama Pengguna
								</div>
								</div>
                                <div class="mb-3 text-start">
                                    <label for="kata_sandi" class="form-label">Kata Sandi</label>
                                    <input type="password" class="form-control" id="kata_sandi" name="katasandi" placeholder="Masukkan Kata Sandi" maxlength="8" required>
                                <div class="invalid-feedback">
									Harap isi Kata Sandi
								</div>
								</div>
                                <div class="mb-3 text-start form-check">
                                    <label class="form-check-label">Lihat Kata Sandi</label>
                                    <input type="checkbox" onclick="lihatPassword()" class="form-check-input">
                                </div>
                                <div class="d-flex justify-content-center">
                                    <button type="submit" name="btn_Regis" class="btn btn-primary">Registrasi</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<script type="text/javascript">
		function lihatPassword() {
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