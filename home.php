<?php 
	session_start();
	include "db.php";
	if (!isset($_SESSION['login'])) {
		header("location:index.php");
		exit();
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<style type="text/css">
		body{background-color: #eee;}
		.header {
			width: 1519px;
			height: 205px;
		}
		.logo {
			width: 200px;
			height: 200px;
			margin: 0 auto;
			position: relative;
			border-radius: 50%;
			border: 2px solid black;
			overflow: auto;
			background-color: white;
		}
		.logo img{
			position: absolute;
			top: 25px;
			left: 25px;
			height: 150px;
			width: 150px;
		}
		.menu {
			width: 1519px;
			position: relative;
		}
		.satu, .dua {
			width: 1519px;
			height: 100px;
			margin-top: 50px;
		}
		.satu1, .satu2, .dua1, .dua2{
			width: 759px;
			height: 100%;
			float: left;
			position: relative;
		}
		.keluar {
			width: 759px;
			height: 100px;
			position: relative;
			margin:50px auto;
		}
		.keluar a, .satu a, .dua a{
			display: inline-block;
			text-decoration: none;
			color: black;
			padding: 10px;
			width: 50%;
			height: 70%;
			position: absolute;
			top: 5px;
			left: 180px;
			border: 2px solid black;
			background-color: lightskyblue;
		}
		.keluar a:hover, .satu a:hover, .dua a:hover{
			background-color: #999999;
			transition: .4s;
		}
		.keluar img, .satu img, .dua img {
			width: 70px;
			height: 70px;
		}
		.img, .teks {float: left;}
		.clr {clear: both;}
		.teks {
			margin-top: 20px;
			margin-left: 6px;
			font-size: 30px;
		}
		.satu1, .dua1 {
			left: 100px;
		}
		.satu2, .dua2 {
			left: -100px;
		}
	</style>
</head>
<body style="margin: 0; padding: 0;">
	<div class="header">
		<div class="logo"><img src="img/logo.jpg"></div>
	</div>
	<div class="contain">
		<div class="menu">
			<div class="satu">
				<div class="satu1">
					<a href="penawaran/index.php">
						<div class="img"><img src="img/penawaran.jpg"></div>
						<div class="teks">Penawaran</div>
					</a>
				</div>
				<div class="satu2">
					<a href="transaksi/index.php">
						<div class="img"><img src="img/transaksi.jpg"></div>
						<div class="teks">Transaksi</div>
					</a>
				</div>
				<div class="clr"></div>
			</div>
			<div class="dua">
				<div class="dua1">
					<a href="daftar/perusahaan/index.php">
						<div class="img"><img src="img/daftar.png"></div>
						<div class="teks">Daftar Data</div>
					</a>
				</div>
				<div class="dua2">
					<a href="profil/index.php">
						<div class="img"><img src="img/profil.jpg"></div>
						<div class="teks">Profil</div>
					</a>
				</div>
				<div class="clr"></div>
			</div>
			<div class="keluar">
				<a href="logout.php">
					<div class="img"><img src="img/keluar.png"></div>
					<div class="teks">Keluar</div>
				</a>	
			</div>
		</div>
	</div>
</body>
</html>