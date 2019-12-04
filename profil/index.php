<?php 
	session_start();
	include "../db.php";
	if (!isset($_SESSION['login'])) {
		header("location:../index.php");
		exit();
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
		<a href="gantipassword.php" class="kembali" style="background-color: blue;">Ganti Kata Sandi</a>
	</div>
	<div class="main">
		<?php  
			$query = mysqli_query($db,"SELECT * FROM profil");
			$data = mysqli_fetch_assoc($query);
		?>
		<div class="mid">
			<div class="detail">
				<div class="table-detail">
					<?php
						if (isset($_GET['update'])) {
							echo "<form action='buat.php' method='get'>";
						}
					?>  
					<table>
						<tr>
							<th colspan="3">Profil Perusahaan</th>
						</tr>
						<tr>
							<td width="130">No Telepon</td>
							<td width="10">:</td>
							<td>
								<?php
								if (isset($_GET['update'])) {
									echo "<input type='text' name='notelepon' id='tel' maxlength='12' value='$data[no_telepon]'>";
								}else{
									echo "$data[no_telepon]";
								}
								?>
							</td>
						</tr>
						<tr>
							<td>Email</td>
							<td>:</td>
							<td>
								<?php
								if (isset($_GET['update'])) {
									echo "<input type='text' name='email' value='$data[email]'>";
								}else{
									echo "$data[email]";
								}
								?>
							</td>
						</tr>
						<tr>
							<th colspan="3">Pengguna</th>
						</tr>
						<tr>
							<td>Nama Pengguna</td>
							<td>:</td>
							<td>
								<?php 
								if (isset($_GET['update'])) {
									echo "<input type='text' name='pengguna' value='$data[pengguna]'>";
								}else{
									echo "$data[pengguna]";
								}
								?>
							</td>
						</tr>
						<tr>
							<td>
								<?php 
									if (isset($_GET['update'])) {
										echo "<input type='submit' name='submit' value='Ubah' class='ubah' style='border:none;'>";
									}else{
										echo "<a href='?update=1' class='ubah' style='width:70px;'>Ubah Data</a>";
									}
								?>
							</td>
							<td></td>
							<td>
							<?php 
								if (isset($_GET['update'])) {
									echo "<a href='?' class='ubah' style='width:40px; background-color:red;'>Batal</a>";
								}
							?>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
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