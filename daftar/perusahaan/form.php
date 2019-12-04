<?php 
	session_start();
	include "../../db.php";
	if (!isset($_SESSION['login'])) {
		header("location:../../index.php");
		exit();
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Tambah Perusahaan</title>
	<style type="text/css">
		.header {
			width: 1535px;
			height: 40px;
			background-color: white;
			text-align: center;
			font-size: 26px;
			line-height: 40px;
		}
		.contain {
			height: 692px;
			width: 1535px;
			/*background-color: pink;*/
		}
		.nav {
			margin: 20px auto;
			height: 48px; 
			width: 80%;
			background-color: #ddd;
			position: relative;
		}
		.logo {
			background-color: white;
			float: left;
			width: 140px;
			height: 140px;
			margin-left: 20px;
			margin-top: -40px;
			border: 2px solid black;
			border-radius: 50%;
			overflow: auto;
			position: relative;
			z-index: 1;
		}
		.logo img {
			height: 100px;
			width: 100px;
			margin-left: 20px;
			margin-top: 18px;
		}
		.nav-item {
			background-color: lightskyblue;
			padding: 10px;
			float: left;
			font-size: 24px;
			margin-right: 2px;
			color: black;
		}
		.nav-item:hover {
			background-color: #999999;
			color: white;
			transition: .3s;
		}
		.main {
			background-color: #ccc;
			width: 800px;
			height: 506px;
			margin: 70px auto;
		}
		/*Atur Kolom*/
		.row {
			margin-top: 10px;
		}
		.col-10 {
		    float: left;
		    width: 10%;
		}

		.col-25 {
		    float: left;
		    width: 25%;
		    line-height: 25px;
		}

		.col-75 {
		    float: left;
		    width: 75%;
		}
		/* Clear floats after the columns */
		.row:after {
		    content: "";
		    display: table;
		    clear: both;
		}

		.m25 {
			margin-left: 6em;
		}
		.m5{
		    margin-left: 5%;
		}
		/*Main*/
		.head {
			font-size: 22px;
			margin: 0 auto;
			width: 200px;
			height: 30px;
			padding-top: 20px;	
		}
		input[type=text], input[type=number] {
			padding: 5px;
			width: 365px;
		}
		select {
			padding: 4px;
			width: 213px;
		}
		.buat {
			width: 70px;
			padding: 10px;
			background-color: blue;
			color: white;
			border:none;
			cursor: pointer;
		}
		.batal {
			width: 70px;
			padding: 8px;
			background-color: red;
			color: white;
			border: none;
			text-decoration: none;
		}
		.batal:hover, .buat:hover {
			box-shadow: 2px 2px 5px rgba(0, 0, 0, .6);
		}
	</style>
</head>
<body style="margin: 0; padding: 0;">
	<?php 
		$a = date("t");
	?>
<div class="header">
	<label>PT MITRA UTAMA ENERGI</label>
</div>
<div class="contain">
	<div class="nav">
		<a href="../../home.php">
			<div class="logo"><img src="../../img/logo.jpg"></div>	
		</a>
		<a href="../../penawaran/index.php">
			<div class="nav-item" style="margin-left: 10px;">Penawaran</div>
		</a>
		<a href="../../transaksi/index.php">
			<div class="nav-item">Transaksi</div>	
		</a>
		<a href="../../daftar/perusahaan/index.php">
			<div class="nav-item">Daftar Data</div>
		</a>
		<a href="../../profil/index.php">
			<div class="nav-item">Profil</div>
		</a>
		<a href="../../logout.php">
			<div class="nav-item" style="position: absolute; right: 0; top: 0;">Logout</div>
		</a>
	</div>
	<div class="main">
		<form action="buat.php" method="GET" id="pForm">
			<?php 
			if (isset($_GET['update'])) {
				$id = $_GET['id'];
				$query = mysqli_query($db,"SELECT *,LEFT(npwp, 2) as npwp1, substring(npwp,4,3) as npwp2, substring(npwp,8,3) as npwp3, substring(npwp,12,1) as npwp4, substring(npwp,14,3) as npwp5, right(npwp,3) as npwp6 FROM perusahaan WHERE id_perusahaan = '$id'");
				$data = mysqli_fetch_assoc($query);
				echo "<input type='hidden' name='update' value='1'>";
				echo "<input type='hidden' name='id' value='$data[id_perusahaan]'>";
			}
			?>
			<div class="head">
				<label><u>Tambah Perusahaan</u></label>
			</div>
			<div class="row m5">
				<div class="col-25"><label>Nama<label></div>
				<div class="col-75">
					: <input type="text" name="nama" required <?php if (isset($_GET['update'])) { echo "value='$data[nama_perusahaan]'"; } ?>>
				</div>
			</div>
			<div class="row m5">
				<div class="col-25"><label>NPWP<label></div>
				<div class="col-75">
					: 
					<input type="text" name="npwp1" id="npwp1" required minlength="2" maxlength="2" style="width: 20px;" <?php if (isset($_GET['update'])) { echo "value='$data[npwp1]'"; } ?>>.
					<input type="text" name="npwp2" id="npwp2" required minlength="3" maxlength="3" style="width: 30px;" <?php if (isset($_GET['update'])) { echo "value='$data[npwp2]'"; } ?>>.
					<input type="text" name="npwp3" id="npwp3" required minlength="3" maxlength="3" style="width: 30px;" <?php if (isset($_GET['update'])) { echo "value='$data[npwp3]'"; } ?>>.
					<input type="text" name="npwp4" id="npwp4" required minlength="1" maxlength="1" style="width: 15px;" <?php if (isset($_GET['update'])) { echo "value='$data[npwp4]'"; } ?>>-
					<input type="text" name="npwp5" id="npwp5" required minlength="3" maxlength="3" style="width: 30px;" <?php if (isset($_GET['update'])) { echo "value='$data[npwp5]'"; } ?>>.
					<input type="text" name="npwp6" id="npwp6" required minlength="3" maxlength="3" style="width: 30px;" <?php if (isset($_GET['update'])) { echo "value='$data[npwp6]'"; } ?>>
				</div>
			</div>
			<div class="row m5">
				<div class="col-25"><label>No Telepon<label></div>
				<div class="col-75">:
					<input type="text" name="notelepon" id="tel" maxlength="12" <?php if (isset($_GET['update'])) { echo "value='$data[no_telp]'"; } ?>>
				</div>
			</div>
			<div class="row m5">
				<div class="col-25"><label>Jenis PBBKB<label></div>
				<div class="col-75">: 
					<?php 
					if (isset($_GET['update'])) { 
						$checked=$data['pbbkb']; } 
						?>
					<input type="radio" name="pbbkb" value="17" 
					<?php  
						if (isset($_GET['update'])) {
							if ($checked == 17) {
								echo "checked";
							}
						} else {
							echo "checked";
						}
					?>>17%
			        <input type="radio" name="pbbkb" value="90"
			        <?php  
						if (isset($_GET['update'])) {
							if ($checked == 90) {
								echo "checked";
							}
						}
					?>>90%
			        <input type="radio" name="pbbkb" value="100"
			        <?php  
						if (isset($_GET['update'])) {
							if ($checked == 100) {
								echo "checked";
							}
						}
					?>>100%
				</div>
			</div>
			<div class="row m5">
				<div class="col-25"><label>Lokasi pengiriman<label></div>
				<div class="col-75">:
					<select name="alamatkirim">
						<?php 
							$query = mysqli_query($db,"SELECT * FROM pengiriman");
							while ($get = mysqli_fetch_assoc($query)) {
								if (isset($_GET['update'])) {
									if ($get['tempat_kirim'] == $data['ship_to']) {
										echo "<option value='$get[tempat_kirim]' selected>$get[tempat_kirim]</option>";
									}else{
										echo "<option value='$get[tempat_kirim]'>$get[tempat_kirim]</option>";
									}
								}else{
									echo "<option value='$get[tempat_kirim]'>$get[tempat_kirim]</option>";
								}
							}
						?>
						</select>
					</div>
			</div>
			<div class="head">
				<label><u>Alamat Perusahaan</u></label>
			</div>
			<div class="row m5">
				<div class="col-25"><label>Nama Jalan<label></div>
				<div class="col-75">:
					<input type="text" name="jalan" required <?php if (isset($_GET['update'])) { echo "value='$data[jalan]'"; } ?>>
				</div>
			</div>
			<div class="row m5">
				<div class="col-25"><label>Kabupaten / Kota<label></div>
				<div class="col-75">:
					<input type="text" name="kabkota" required <?php if (isset($_GET['update'])) { echo "value='$data[kabkota]'"; } ?>>
				</div>
			</div>
			<div class="row m5">
				<div class="col-25"><label>Provinsi<label></div>
				<div class="col-75">:
					<input type="text" name="provinsi" required <?php if (isset($_GET['update'])) { echo "value='$data[provinsi]'"; } ?>>
				</div>
			</div>
			<div class="row">
				<div class="col-25 m5" style="line-height: 40px;"><a href="index.php" class="batal">Kembali</a>
				</div>
				<div class="col-25">
		       		<input type="submit" name="sumbit" class="buat" value="<?php if(isset($_GET['update'])){echo "Update";}else{echo "Tambah";} ?>">
					</div>
			</div>
		</form>
	</div>
	<script type="text/javascript">
		//tel
	const tel = document.getElementById('tel');

	tel.addEventListener('input', function() {
	  let start = this.selectionStart;
	  let end = this.selectionEnd;
	  
	  const current = this.value
	  const corrected = current.replace(/([^+0-9]+)/gi, '');
	  this.value = corrected;
	  
	  if (corrected.length < current.length) --end;
	  this.setSelectionRange(start, end);
	});
	//1
	const npwp1 = document.getElementById('npwp1');

	npwp1.addEventListener('input', function() {
	  let start = this.selectionStart;
	  let end = this.selectionEnd;
	  
	  const current = this.value
	  const corrected = current.replace(/([^+0-9]+)/gi, '');
	  this.value = corrected;
	  
	  if (corrected.length < current.length) --end;
	  this.setSelectionRange(start, end);
	});
	//2
	const npwp2 = document.getElementById('npwp2');

	npwp2.addEventListener('input', function() {
	  let start = this.selectionStart;
	  let end = this.selectionEnd;
	  
	  const current = this.value
	  const corrected = current.replace(/([^+0-9]+)/gi, '');
	  this.value = corrected;
	  
	  if (corrected.length < current.length) --end;
	  this.setSelectionRange(start, end);
	});
	//3
	const npwp3 = document.getElementById('npwp3');

	npwp3.addEventListener('input', function() {
	  let start = this.selectionStart;
	  let end = this.selectionEnd;
	  
	  const current = this.value
	  const corrected = current.replace(/([^+0-9]+)/gi, '');
	  this.value = corrected;
	  
	  if (corrected.length < current.length) --end;
	  this.setSelectionRange(start, end);
	});
	//4
	const npwp4 = document.getElementById('npwp4');

	npwp4.addEventListener('input', function() {
	  let start = this.selectionStart;
	  let end = this.selectionEnd;
	  
	  const current = this.value
	  const corrected = current.replace(/([^+0-9]+)/gi, '');
	  this.value = corrected;
	  
	  if (corrected.length < current.length) --end;
	  this.setSelectionRange(start, end);
	});
	//5
	const npwp5 = document.getElementById('npwp5');

	npwp5.addEventListener('input', function() {
	  let start = this.selectionStart;
	  let end = this.selectionEnd;
	  
	  const current = this.value
	  const corrected = current.replace(/([^+0-9]+)/gi, '');
	  this.value = corrected;
	  
	  if (corrected.length < current.length) --end;
	  this.setSelectionRange(start, end);
	});
	//6
	const npwp6 = document.getElementById('npwp6');

	npwp6.addEventListener('input', function() {
	  let start = this.selectionStart;
	  let end = this.selectionEnd;
	  
	  const current = this.value
	  const corrected = current.replace(/([^+0-9]+)/gi, '');
	  this.value = corrected;
	  
	  if (corrected.length < current.length) --end;
	  this.setSelectionRange(start, end);
	});
	</script>
</body>
</html>