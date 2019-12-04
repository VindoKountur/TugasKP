<?php 
	session_start();
	include "../db.php";
	include "../fungsi.php";
	if (!isset($_SESSION['login'])) {
		header("location:../index.php");
		exit();
	}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Penawaran</title>
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
		.menu {
			width: 80%;
			height: 20px;
			/*background-color: #ccc;*/
			margin: 30px auto;
			position: relative;
		}
		.menu .menu-item {
			background-color: blue;
			width: 120px;
			height: 20px;
			margin-left: 200px;
			padding: 5px;
			text-align: center;
			color: white;
			border-radius: 5px;
			position: absolute;
		}
		.menu .menu-item:hover {
			box-shadow: 2px 2px 5px rgba(0, 0, 0, .6);
		}
		.menu .search {
			position: absolute;
			right: 0;
			top: 0;
		}
		.menu .search input[type=text]{
			padding: 5px;
			width: 250px;
			height: 15px;
		}
		.menu .search input[type=submit] {
			padding: 5px;
			width: 50px;
			background-color: blue;
			color: white;
			border:none;
		}
		.inti {
			height: 550px;
			width: 1240px;
			background-color: #eee;
			margin: 0 auto;
		}
		.inti .tabel th {
			padding: 8px;
			background-color: #bbb;
		}
		.inti a {
			text-decoration: none;
			color: white;
			display: inline-block;
			background-color: red;
			padding: 2px;
			border-radius: 4px;
			padding-left: 4px;
			padding-right: 4px;
		}
		.inti a:hover {
			box-shadow: 2px 2px 5px rgba(0, 0, 0, .6);
		}
		.btn {
			background-color: #0c0;
			padding: 5px;
			text-decoration: none;
			color: white;
			width: 50px;
			height: 20px;
			display: inline-block;
			text-align: center;
			border: none;
			border-radius: 5px;
		}
		.overflow {
			height: 510px;
			overflow: auto;
		}
		.overflow table {
			border-collapse: collapse;
		}
		.overflow tr:hover {
			background-color: rgba(0, 0, 0, .08);
		}
		/* width */
		::-webkit-scrollbar {
		    width: 7px;
		}

		/* Track */
		::-webkit-scrollbar-track {
		    background: transparent; 
		}
		 
		/* Handle */
		::-webkit-scrollbar-thumb {
		    background: #888;
		    border-radius: 20px;
		}

		/* Handle on hover */
		::-webkit-scrollbar-thumb:hover {
		    background: #555; 
		}
	</style>
</head>
<body style="margin: 0; padding: 0;">
<div class="header">
	<label>PT MITRA UTAMA ENERGI - DATA PENAWARAN</label>
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
	<div class="main">
		<div class="menu">
			<a href="form.php">
				<div class="menu-item">Buat Penawaran</div>
			</a>
			<div class="search">
				<form action="#" method="GET">
					<input type="text" name="search" placeholder="Cari Perusahaan" id="cari" style="border: 3px inset rgba(0,0,0,.4);">
				</form>
			</div>
		</div>
		<div class="inti" id="tabel">
			<div class="tabel">
				<table width="100%">
					<?php  
						$query = mysqli_query($db,"SELECT * FROM penawaran ORDER BY tanggal_buat DESC");
						$no = 1;
						
					?>
					<tr>
						<th width="30">No</th>
						<th>Nama Perusahaan</th>
						<th width="180">Tanggal Buat</th>
						<th width="180">Harga Pokok (Rp)</th>
						<th width="180">Harga Jual (Rp)</th>
						<th width="180">Option</th>
					</tr>
				</table>
			</div>
			<div class="overflow">
				<table width="100%">
					<?php  
						$null = mysqli_num_rows($query);
						if ($null == 0) {
							?>
							<tr align="center">
								<td colspan="10" rowspan="6"><h2>Belum ada penawaran yang dibuat</h2></td>
							</tr>
							<?php
						} else {
					?>
					<?php while ($data = mysqli_fetch_assoc($query)) { ?>
								<tr>
									<td align="center" width="46"><?=$no?></td>
									<td><?= $data['nama_p']?></td>
									<td align="center" width="196"><?= $data['tanggal_buat']?></td>
									<td align="center" width="196"><?= formatharga($data['harga_pokok'])?></td>
									<td align="center" width="196"><?= formatharga($data['total'])?></td>
									<td align="center" width="196"><a href="../print/penawaran.php?idsp=<?php echo($data['id_sp']) ?>" target="_blank" style="background-color: #6666ff ;">Cetak</a> || <a href="formubah.php?idsp=<?php echo($data['id_sp']) ?>" style="color: black; background-color: white; border: .5px solid black;">Ubah</a> || <a href="del.php?idsp=<?php echo($data['id_sp']) ?>" onclick="return confirm('Ingin menghapus data ini?')" style="color: white;">Hapus</a></td>
								</tr>
							<?php $no++; ?>
					<?php } } ?>
					
				</table>
			</div>
			<script src="../js/penawaran.js"></script>
		</div>
	</div>
</div>
</body>
</html>