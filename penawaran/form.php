<?php 
	session_start();
	include "../db.php";
	$a = date("t");
	if (!isset($_SESSION['login'])) {
		header("location:../index.php");
		exit();
	}
	if (isset($_GET['submit'])) {
		$np = strtoupper($_GET['np']);
		$lampiran = strtoupper($_GET['lampiran']);
		$hp = $_GET['HP'];
		$pbbkb = $_GET['pbbkb'];
		$periode = $_GET['periode'];
		$oat = $_GET['oat'];
		$t = $_GET['t'];
		$today = date("Y-m-d");
			$p1 = $hp*10/100;
			$p2 = $hp*$pbbkb/100;
			$p3 = $hp*0.3/100;
			$ttl1 = $hp+$p1+$p2+$p3+$oat;
			if ($pbbkb == 1.3) {
				$modepbbkb = 1;
			    $ttl2 = $t*250;
			    $ttl3 = $ttl1*250;
			}elseif ($pbbkb == 6.75) {
				$modepbbkb = 2;
			    $ttl2 = $t*2000;
			    $ttl3 = $ttl1*2000;
			}elseif ($pbbkb == 7.5) {
				$modepbbkb = 3;
			    $ttl2 = $t*500;
			    $ttl3 = $ttl1*500;
			}
			$ttl4 = $ttl2 - $ttl3;
			if ($pbbkb == 1.3) {
			    $dd = $ttl4/-279;
			}elseif ($pbbkb == 6.75) {
			    $dd = $ttl4/-2341;
			}elseif ($pbbkb == 7.5) {
			 $dd = $ttl4/-589;
			}
			$hdd = $hp - $dd;
			$pajak1d = $hdd*10/100;
			$pajak2d = $hdd*$pbbkb/100;
			$pajak3d = $hdd*0.3/100;
			$jumlah = $hdd + $pajak1d + $pajak2d + $pajak3d +$oat;

			//menentukan diskon
			echo "Harga Pokok = "."$hp"."<br>";
			echo "PBBKB = "."$pbbkb"."<br>";
			echo "OAT = "."$oat"."<br>";
			echo "Harga Jual = "."$t"."<br>";
			echo "Pajak 1 s = "."$p1"."<br>";
			echo "Pajak 2 s = "."$p2"."<br>";
			echo "Pajak 3 s = "."$p3"."<br>";
			echo "Total 1 = "."$ttl1"."<br>";   // Harga pokok + pajak1 + pajak2 + pajak3 + oat
			echo "Total 2 = "."$ttl2"."<br>";   // Harga jual * 250(pbbkb 17%) 2000(pbbkb 90%) 500 (pbbkb 100%)
			echo "Total 3 = "."$ttl3"."<br>";   // Total 1 * 250(pbbkb 17%) 2000(pbbkb 90%) 500 (pbbkb 100%)
			echo "Total 4 = "."$ttl4"."<br>";   // Total 2 - Total 3
			echo "Diskon = "."$dd"."<br><br>";  // Total 4/-279 (pbbkb 17%); Total4/-2341 (pbbkb 90%); Total4/-589 (pbbkb100%)
			
			//rincian harga
			echo "Harga Pokok = "."$hp"."<br>";
			echo "Diskon = "."$dd"."<br>";
			echo "Harga Dasar = "."$hdd"."<br>"; // Harga Pokok - Diskon
			echo "Pajak 1 = "."$pajak1d"."<br>"; 
			echo "Pajak 2 = "."$pajak2d"."<br>";
			echo "Pajak 3 = "."$pajak3d"."<br>";
			echo "OAT = "."$oat"."<br>";
			echo "Harga Jual Fix = "."$jumlah"."<br>"; // Harga Dasar + Pajak 1 + Pajak 2 + Pajak 3;

			//atur ID
			$getiddetail = mysqli_query($db,"SELECT LEFT(id_sp, 4) as thn, substring(id_sp,5,2) as bln, right(id_sp,3) as urut, tanggal_buat, nama_p, periode_surat, harga_pokok, total, oat, pbbkb_m FROM penawaran ORDER BY id_sp DESC LIMIT 1");
			$data = mysqli_fetch_assoc($getiddetail);
			$tanggalbuat = $data['tanggal_buat'];
			$namap = $data['nama_p'];
			$psurat = $data['periode_surat'];
			$harpok = $data['harga_pokok'];
			$oatd = $data['oat'];
			$pbbkbd = $data['pbbkb_m'];
			$tot = $data['total'];
			$thnid = $data['thn'];
			$blnid = $data['bln'];
			$thnini = date("Y");
			$blnini = date("m");
			$urutid = $data['urut'];
			if ($thnid == $thnini && $blnid == $blnini) {
				$urutnaik = $urutid + 1;
				$urutid = sprintf("%03d", $urutnaik); 
				$setid = "$thnid"."$blnid"."$urutid";
			}elseif ($thnid == $thnini && $blnid != $blnini) {
				$setid = "$thnid"."$blnini"."001";
				$urutid = "001";
			}elseif ($thnid != $thnini) {
				$setid = "$thnini"."$blnini"."001";
				$urutid = "001";
			}else{
				echo "ada yang salah";
				exit();
			}

			// duplikat cek
			if ($tanggalbuat == $today && $np == $namap && $harpok == $hp && $tot == $t && $psurat == $periode && $modepbbkb == $pbbkbd && $oat == $oatd) {
				echo "Surat penawaran ini sudah pernah dibuat, lihat di <a href='index.php'>lihat daftar surat penawaran</a>";
				exit();
			}

			#profil
			$query = mysqli_query($db, "SELECT * FROM profil");
			$profil_data = mysqli_fetch_assoc($query);
			$pengguna = $profil_data['pengguna'];

			//database
		    $ins = mysqli_query($db,"INSERT INTO penawaran (id_sp, tanggal_buat, nama_p, periode_surat, lampiran, harga_pokok, diskon, harga_dasar, ppn, pbbkb, pbbkb_m, pph_migas, oat, total, pembuat) VALUES ('$setid', '$today', '$np', '$periode','$lampiran', '$hp', '$dd', '$hdd', '$pajak1d', '$pajak2d', '$modepbbkb', '$pajak3d', '$oat', '$jumlah' , '$pengguna')");
		    if (!$ins) {
		    	echo "
		    		<script>
		    			alert('Gagal tambah data')
		    			document.location.href='form.php'
		    		</script>
		    	";
		    }else{
		    	echo "
		    		<script>
		    			alert('Penawaran berhasil dibuat')
		    			document.location.href='index.php'
		    		</script>
		    	";
		    }
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Penawaran Baru</title>
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
			height: 50px;	
			padding-top: 20px;
		}
		input[type=text], input[type=number] {
			padding: 5px;
			width: 300px;
		}
		select {
			padding: 4px;
			width: 313px;
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
<div class="header">
	<label>PT MITRA UTAMA ENERGI</label>
</div>
<div class="contain">
	<div class="nav">
		<a href="../home.php">
			<div class="logo"><img src="../img/logo.jpg"></div>	
		</a>
		<a href="index.php">
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
		<form action="" method="GET">
			<div class="head">
				<label>Buat Penawaran Baru</label>
			</div>
			<div class="row m5">
				<div class="col-25">
					Periode Pembuatan Surat
				</div>
				<div class="col-75">: 
					<select name="periode">
						<option value="1">(1) Tanggal 1 - 14</option>
						<option value="2">(2) Tanggal 15 - <?php echo "$a"; ?></option>
					</select>
				</div>
			</div>
			<div class="row m5">
				<div class="col-25"><label>Nama Pemesan<label></div>
				<div class="col-75">
					: <input type="text" name="np" required>
				</div>
			</div>
			<div class="row m5">
				<div class="col-25"><label>Harga Pokok<label></div>
				<div class="col-75">
					: <input type="text" name="HP" id="hp" required>
				</div>
			</div>
			<div class="row m5">
				<div class="col-25"><label>PBBKB<label></div>
				<div class="col-75">: 
					<input type="radio" title="Potongan pajak 1.3%" name="pbbkb" value="1.3" checked><label title="Potongan pajak 1.3%">17%</label>
			        <input type="radio" title="Potongan pajak 6.75%" name="pbbkb" value="6.75"><label title="Potongan pajak 6.75%" title="Potongan pajak 6.75%">90%</label>
			        <input type="radio" title="Potongan pajak 7.5%" name="pbbkb" value="7.5"><label title="Potongan pajak 7.5%" title="Potongan pajak 7.5%">100%</label>
				</div>
			</div>
			<div class="row m5">
				<div class="col-25"><label>OAT<label></div>
				<div class="col-75">:
					<input type="text" name="oat" id="oat" required>
				</div>
			</div>
			<div class="row m5">
				<div class="col-25"><label>Harga Jual<label></div>
				<div class="col-75">:
					<input type="text" name="t" id="t" required>
				</div>
			</div>
			<div class="row m5">
				<div class="col-25"><label>Lampiran   (tidak wajib)<label></div>
				<div class="col-75">
					: <input type="text" name="lampiran">
				</div>
			</div>
			<div class="row">
				<div class="col-25 m5" style="line-height: 40px;"><a href="index.php" class="batal">Kembali</a>
				</div>
				<div class="col-25">
		       		<input type="submit" name="submit" class="buat" value="Buat">
				</div>
			</div>
		</form>
	</div>
</body>
<script type="text/javascript">
	//hp
	const hp = document.getElementById('hp');

	hp.addEventListener('input', function() {
	  let start = this.selectionStart;
	  let end = this.selectionEnd;
	  
	  const current = this.value
	  const corrected = current.replace(/([^0-9]+)/gi, '');
	  this.value = corrected;
	  
	  if (corrected.length < current.length) --end;
	  this.setSelectionRange(start, end);
	});
	//oat
	const oat = document.getElementById('oat');

	oat.addEventListener('input', function() {
	  let start = this.selectionStart;
	  let end = this.selectionEnd;
	  
	  const current = this.value
	  const corrected = current.replace(/([^0-9]+)/gi, '');
	  this.value = corrected;
	  
	  if (corrected.length < current.length) --end;
	  this.setSelectionRange(start, end);
	});
	//t
	const t = document.getElementById('t');

	t.addEventListener('input', function() {
	  let start = this.selectionStart;
	  let end = this.selectionEnd;
	  
	  const current = this.value
	  const corrected = current.replace(/([^0-9]+)/gi, '');
	  this.value = corrected;
	  
	  if (corrected.length < current.length) --end;
	  this.setSelectionRange(start, end);
	});
</script>
</html>