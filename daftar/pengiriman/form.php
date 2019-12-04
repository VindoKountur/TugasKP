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
	<title>Tambah Lokasi</title>
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
			height: 500px;
			margin: 70px auto;
		}
		/*Atur Kolom*/
		.row {
			margin-top: 20px;
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
			width: 200px;
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
		<form action="buat.php" method="GET">
			<?php 
				if (isset($_GET['update'])) {
					$id = $_GET['id'];
					$query = mysqli_query($db,"SELECT * FROM pengiriman WHERE id_kirim = '$id'");
					$data = mysqli_fetch_array($query);
					echo "<input type='hidden' name='update' value='1'>";
					echo "<input type='hidden' name='id' value='$id'>";
				}
			?>
			<div class="head">
				<label>Tambah Lokasi</label>
			</div>
			<div class="row m5">
				<div class="col-25"><label>Lokasi<label></div>
				<div class="col-75">
					: <input type="text" name="lokasi" required <?php if(isset($_GET['update'])){ echo "value='$data[tempat_kirim]'"; } ?>>
				</div>
			</div>
			<div class="row m5">
				<div class="col-25"><label>Harga<label></div>
				<div class="col-75">:
					<input type="text" name="harga" required id="tel" <?php if(isset($_GET['update'])){ echo "value='$data[harga_kirim]'"; } ?>>
				</div>
			</div>
			<div class="row">
				<div class="col-25 m5" style="line-height: 40px;"><a href="index.php" class="batal">Kembali</a>
				</div>
				<div class="col-25">
		       		<input type="submit" name="sumbit" class="buat" value="<?php if(isset($_GET['update'])){ echo "Update"; }else{ echo "Tambah"; } ?>">
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
	</script>
</body>
</html>