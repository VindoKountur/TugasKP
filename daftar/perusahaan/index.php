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
	<title>Perusahaan</title>
	<style type="text/css">
		a {
			text-decoration: none;
		}
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
		.menu a {
			text-decoration: none;
		}
		.menu .menu-item {
			background-color: blue;
			width: 150px;
			height: 20px;
			margin-left: 200px;
			padding: 5px;
			text-align: center;
			color: white;
			border-radius: 5px;
			position: absolute;
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
		.lain {
			height: 50px;
			width: 1240px;
			margin: 0 auto;
		}
		.lain .menu-item {
			background-color: blue;
			padding: 8px;
			float: left;
			margin-left: 1em;
			color: white;
			border-radius: 5px;
			padding-right: 12px;
			padding-left: 12px;
		}
		.menu-item:hover {
			box-shadow: 2px 2px 5px rgba(0, 0, 0, .6);
		}
		.inti {
			height: 500px;
			width: 1240px;
			background-color: #eee;
			margin: 0 auto;
		}
		.inti a {
			text-decoration: none;
			color: white;
			display: inline-block;
			background-color: #6666ff;
			padding: 2px;
			border-radius: 4px;
			padding-left: 4px;
			padding-right: 4px;
		}
		.inti a:hover {
			box-shadow: 2px 2px 5px rgba(0, 0, 0, .6);
		}
		.inti .tabel th {
			padding: 8px;
			background-color: #bbb;
		}
		.overflow {
			height: 463px;
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
	<label>PT MITRA UTAMA ENERGI - DAFTAR PERUSAHAAN</label>
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
		<div class="menu">
			<a href="form.php">
				<div class="menu-item">Tambah Perusahaan</div>
			</a>
			<div class="search">
				<form action="#" method="GET">
					<input type="text" name="search" placeholder="Cari Perusahaan" id="cari" style="border: 3px inset rgba(0,0,0,.4);">
				</form>
			</div>
		</div>
		<div class="lain">
			<a href="../perusahaan/index.php">
				<div class="menu-item">Perusahaan</div>
			</a>
			<a href="../mobil/index.php">
				<div class="menu-item">Truk</div>
			</a>
			<a href="../sopir/index.php">
				<div class="menu-item">Sopir</div>
			</a>
			<a href="../pengiriman/index.php">
				<div class="menu-item">Lokasi Pengiriman</div>
			</a>
		</div>
		<div class="inti" id="tabel">
			<div class="tabel">
				<table width="100%">
					<tr>
						<th width="25">No</th>
						<th width="200">Nama Perusahaan</th>
						<th width="130">NPWP</th>
						<th width="100">No Telepon</th>
						<th width="86">PBBKB (%)</th>
						<th width="69">OAT (Rp)</th>
						<th width="98">Alamat Kirim</th>
						<th>Alamat Lengkap</th>
						<th width="110">Option</th>
					</tr>
				</table>
			</div>
			<div class="overflow">
				<table width="100%">
					<?php 
						$no = 1;
						$query = mysqli_query($db,"SELECT * FROM perusahaan");
						$null = mysqli_num_rows($query);
						if ($null == 0) {
							?>
								<tr align="center">
									<td rowspan="9" colspan="9"><h2>Belum ada data perusahaan yang dibuat</h2></td>
								</tr>
							<?php
						}
						while ($data = mysqli_fetch_assoc($query)) { 
						$jalan = $data['jalan'];
						$kabkota = $data['kabkota'];
						$provinsi = $data['provinsi'];
						$alamat = "$jalan".", "."$kabkota".", "."$provinsi";
							?>
								<tr>
									<td align="center" width="38"><?=$no?></td>
									<td width="216"><?=$data['nama_perusahaan']?></td>
									<td width="146" align="center"><?=$data['npwp']?></td>
									<td width="116" align="center"><?=$data['no_telp']?></td>
									<td width="93" align="center"><?=$data['pbbkb']?></td>
									<td width="85" align="center"><?=$data['oat']?></td>
									<td width="126" align="center"><?=$data['ship_to']?></td>
									<td><?= $alamat ?></td>
									<td width="126" align="center"><a href='form.php?update=1&id=<?php echo($data['id_perusahaan'])?>'>Ubah</a> || <a href="del.php?id=<?php echo($data['id_perusahaan'])?>" onclick="return confirm('Ingin menghapus data?')" style="background-color: red;">Hapus</a></td>
								</tr>
					<?php
							$no++;
						}
					?>
				</table>
			</div>
			<script src="../../js/perusahaan.js"></script>
		</div>
	</div>
</div>
</body>
</html>