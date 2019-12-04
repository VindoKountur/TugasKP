<?php 
	session_start();
	include "../db.php";
	$a = date("t");
	if (!isset($_SESSION['login'])) {
		header("location:../index.php");
		exit();
	}
	if (isset($_GET['submit'])) {
		$id = $_GET['idsp'];
		$np = strtoupper($_GET['np']);
		$lampiran = strtoupper($_GET['lampiran']);
		$hp = $_GET['HP'];
		$pbbkb = $_GET['pbbkb'];
		$periode = $_GET['periode'];
		$oat = $_GET['oat'];
		$t = $_GET['t'];
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

		    $update = mysqli_query($db,"UPDATE penawaran SET nama_p = '$np', periode_surat = '$periode',lampiran = '$lampiran', harga_pokok = '$hp', diskon = '$dd', harga_dasar='$hdd',ppn = '$pajak1d',pbbkb = '$pajak2d', pbbkb_m = '$modepbbkb', pph_migas = '$pajak3d', oat='$oat', total = '$jumlah' WHERE id_sp = '$id'");
		    if (!$update) {
		    	echo "
		    		<script>
		    			alert('Data gagal diubah')
		    		</script>
		    	";
		    }else{
		    	echo "
		    		<script>
		    			alert('Data telah diubah')
		    			document.location.href='index.php'
		    		</script>
		    	";
		    }
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Ubah Penawaran</title>
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
			font-size: 20px;
			margin: 0 auto;
			width: 200px;
			height: 50px;	
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
		<?php 
			$id = $_GET['idsp'];
			$query = mysqli_query($db,"SELECT * FROM penawaran WHERE id_sp = $id");
			$data = mysqli_fetch_assoc($query);
		?>
		<form action="" method="GET">
			<input type="hidden" name="idsp" value="<?php echo($id) ?>">
			<div class="head">
				<label>Ubah Data Penawaran</label>
			</div>
			<div class="row m5">
				<div class="col-25">
					Periode Pembuatan Surat
				</div>
				<div class="col-75">: 
					<select name="periode">
						<option value="1" <?php if ($data['periode_surat'] == 1): ?>
							selected
						<?php endif ?>>(1) Tanggal 1 - 14</option>
						<option value="2" <?php if ($data['periode_surat'] == 2): ?>
							selected
						<?php endif ?>>(2) Tanggal 15 - <?php echo "$a"; ?></option>
					</select>
				</div>
			</div>
			<div class="row m5">
					<div class="col-25"><label>Nama Pemesan<label></div>
					<div class="col-75">
						: <input type="text" name="np" required value="<?php echo($data['nama_p']) ?>">
					</div>
				</div>
				<div class="row m5">
					<div class="col-25"><label>Harga Pokok<label></div>
					<div class="col-75">
						: <input type="text" name="HP" id="hp" required value="<?php echo($data['harga_pokok']) ?>">
					</div>
				</div>
				<div class="row m5">
					<div class="col-25"><label>PBBKB<label></div>
					<div class="col-75">: 
						<input type="radio" name="pbbkb" title="Potongan pajak 1.3%" value="1.3" <?php if ($data['pbbkb_m']==1): ?>
							checked
						<?php endif ?>><label title="Potongan pajak 1.3%">17%</label>
				        <input type="radio" name="pbbkb" title="Potongan pajak 6.75%" value="6.75" <?php if ($data['pbbkb_m']==2): ?>
				        	checked
				        <?php endif ?>><label title="Potongan pajak 6.75%">90%</label>
				        <input type="radio" name="pbbkb" title="Potongan pajak 7.5%" value="7.5" <?php if ($data['pbbkb_m']==3): ?>
				        	checked
				        <?php endif ?>><label title="Potongan pajak 7.5%">100%</label>
					</div>
				</div>
				<div class="row m5">
					<div class="col-25"><label>OAT<label></div>
					<div class="col-75">:
						<input type="text" name="oat" id="oat" required value="<?php echo($data['oat']) ?>">
					</div>
				</div>
				<div class="row m5">
					<div class="col-25"><label>Harga Jual<label></div>
					<div class="col-75">:
						<input type="text" name="t" id="t" required value="<?php echo($data['total']) ?>">
					</div>
				</div>
				<div class="row m5">
				<div class="col-25"><label>Lampiran   (tidak wajib)<label></div>
				<div class="col-75">
					: <input type="text" name="lampiran" value="<?php echo($data['lampiran']) ?>">
				</div>
			</div>
				<div class="row">
					<div class="col-25 m5" style="line-height: 40px;"><a href="index.php" class="batal">Kembali</a>
					</div>
					<div class="col-25">
		        		<input type="submit" name="submit" class="buat" value="Ubah">
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