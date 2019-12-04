<?php 
	session_start();
	include "../db.php";
	if (!isset($_SESSION['login'])) {
		header("location:../index.php");
		exit();
	}
	if (isset($_POST['submit'])) {
		$passlama = $_POST['passlama'];
		$passbaru = $_POST['passbaru'];
		$konfirmasi = $_POST['konfirmasi'];
		$query = mysqli_query($db,"SELECT * FROM user WHERE id_user = 1");
		$data = mysqlI_fetch_assoc($query);
		if ($data['upass'] !== $passlama) {
			echo "<script>
				alert('Password lama yang dimasukkan salah')
				document.location.href='gantipassword.php'
			</script>";
			exit();
		}elseif ($passbaru !== $konfirmasi) {
			echo "<script>
				alert('Password baru yang dimasukkan tidak cocok dengan konfirmasi')
				document.location.href='gantipassword.php'
			</script>";
			exit();
		}else{
			$query = mysqli_query($db,"UPDATE user SET upass = '$passbaru'");
			if (!$query) {
				echo "<script>
					alert('Gagal ganti password, terjadi kesalahan')
					document.location.href='gantipassword.php'
				</script>";
				exit();
			}else{
				echo "<script>
					alert('Password telah diganti')
					document.location.href='../logout.php'
				</script>";
				exit();
			}
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Profil</title>
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
		.kembali {
			display: inline-block;
			padding: 10px;
			background-color: red;
			text-decoration: none;
			color: white;
			border-radius: 5px;
		}
		.ubah {
			display: inline-block;
			padding: 10px;
			background-color: blue;
			text-decoration: none;
			color: white;
			border: none;
		}
		.kembali:hover, .ubah:hover {
			box-shadow: 2px 2px 5px rgba(0, 0, 0, .6);
		}
		.main {
			width: 1235px;
			height: 500px;
			margin: 20px auto;
		}
		.mid {
			margin: 0 auto;
			width: 1020px;
			height: 100%;
		}
		table th {
			padding: 10px;
			font-size: 22px;
			background-color: blue;
			color: white;
		}
		table td {
			padding: 10px;
		}
		.detail {
			width: 600px;
			height: 100%;
			margin: 0 auto;
		}
		.detail .table-detail {
			width: 100%;
			height: auto;
			background-color: #ccc;
			padding-top: 10px;
		}
		.detail table, .harga table {
			width: 95%;
			margin-left: 10px;
		}
		.harga {
			float: left;
			width: 400px;
			height: 100%;
			margin-left: 20px;
		}
		.harga .table-harga {
			width: 100%;
			height: auto;
			background-color: #ccc;
			padding-top: 10px;
		}
	</style>
</head>
<body style="margin: 0; padding: 0;">
<div class="header">
	<label>PT MITRA UTAMA ENERGI - PROFIL</label>
</div>
<div class="contain">
	<div class="nav">
		<a href="../home.php">
			<div class="logo"><img src="../img/logo.jpg"></div>	
		</a>
		<a href="../penawaran/index.php">
			<div class="nav-item" style="margin-left: 10px;">Penawaran</div>
		</a>
		<a href="../transaksi/index.php">
			<div class="nav-item">Transaksi</div>	
		</a>
		<a href="../daftar/perusahaan/index.php">
			<div class="nav-item">Daftar Data</div>
		</a>
		<a href="../profil/index.php">
			<div class="nav-item">Profil</div>
		</a>
		<a href="../logout.php">
			<div class="nav-item" style="position: absolute; right: 0; top: 0;">Logout</div>
		</a>
	</div>
	<div>
		<a href="index.php" class="kembali" style="background-color: red;">Kembali</a>
	</div>
	<div class="main">
		<div class="mid">
			<div class="detail">
				<div class="table-detail">
					<form action="" method="POST">
					<table>
						<tr>
							<th colspan="3">Ganti Kata Sandi</th>
						</tr>
						<tr>
							<td width="100">Kata Sandi Lama</td>
							<td width="10">:</td>
							<td><input type="password" name="passlama" required></td>
						</tr>
						<tr>
							<td>Kata Sandi Baru</td>
							<td>:</td>
							<td><input type="password" name="passbaru" required></td>
						</tr>
						<tr>
							<td>Konfirmasi Kata Sandi Baru</td>
							<td>:</td>
							<td><input type="password" name="konfirmasi" required></td>
						</tr>
						<tr>
							<td><input type='submit' name='submit' value='Ganti' class='ubah'></td>
						</tr>
					</table>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>