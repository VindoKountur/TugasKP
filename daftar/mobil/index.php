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
	<title>Truk</title>
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
		.menu-item:hover {
			box-shadow: 2px 2px 5px rgba(0, 0, 0, .6);
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
			padding-left: 12px;
			padding-right: 12px;
		}
		.inti {
			height: 500px;
			width: 640px;
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
	<label>PT MITRA UTAMA ENERGI - DAFTAR TRUK</label>
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
				<div class="menu-item">Tambah Truk</div>
			</a>
			<div class="search">
				<form action="#" method="GET">
					<input type="text" name="search" placeholder="Cari Truk" id="cari" style="border: 3px inset rgba(0,0,0,.4);">
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
						<th width="30">No</th>
						<th>Plat Nomor</th>
						<th>Status</th>
						<th width="280">Option</th>
					</tr>
				</table>
			</div>
			<div class="overflow">
				<table width="100%">
					<?php 
						$no = 1;
						$query = mysqli_query($db,"SELECT * FROM truk");
						$null = mysqli_num_rows($query);
						if ($null == 0) {
							?>
								<tr align="center">
									<td rowspan="3" colspan="3"><h2>Belum ada data yang dibuat</h2></td>
								</tr>
							<?php
						}
						while ($data = mysqli_fetch_assoc($query)) { 
							$status1 = $data['status'];
							if ($status1 !== 'ready') {
								$status = 'Sedang Digunakan';
							}else{
								$status = 'Siap Digunakan';
							}
							?>
								<tr>
									<td width="44" align="center"><?=$no?></td>
									<td align="center"><?=$data['nomor_plat']?></td>
									<td align="center" width="110"><?=$status?></td>
									<td width="296" align="center"><a href="form.php?update=1&id=<?php echo($data['id_truk'])?>">Edit</a> || <a href="del.php?id=<?php echo($data['id_truk']) ?>" onclick="return confirm('Ingin menghapus data?')" style="background-color: red;">Hapus</a></td>
								</tr>	
					<?php 
							$no++;
							}
					?>
				</table>
			</div>
			<script src="../../js/truk.js"></script>
		</div>
	</div>
</div>
</body>
</html>