<?php 
	session_start();
	include "../db.php";
	if (!isset($_SESSION['login'])) {
		header("location:../index.php");
		exit();
	}
	if (isset($_POST['submit'])) {
		$idperusahaan = $_POST['idperusahaan'];
		$jumlah_pesanan = $_POST['quantity'];
		$harga_jual = $_POST['hargajual'];
		$id_truk = $_POST['id_truk'];
		$id_sopir = $_POST['id_sopir'];
		$no_po = $_POST['no_po'];
		$no_segel = $_POST['no_segel'];
		$today = date("Y-m-d");
		$tax_no = "";

		//pbbkb
		$query = mysqli_query($db,"SELECT * FROM perusahaan WHERE id_perusahaan = '$idperusahaan'");
		$pData = mysqli_fetch_assoc($query);
		$pbbkb = $pData['pbbkb'];
		$oat = $pData['oat'];
		if ($pbbkb == 17) {
			$a = 1.3;
		}elseif ($pbbkb == 90) {
			$a = 6.75;
		}elseif ($pbbkb == 100) {
			$a = 7.5;
		}

		#profil
		$query = mysqli_query($db, "SELECT * FROM profil");
		$profil_data = mysqli_fetch_assoc($query);
		$pengguna = $profil_data['pengguna'];

		//detail
		$total = $harga_jual * $jumlah_pesanan;
		$ppn = $total*10/100;
		$hasil_pbbkb = $total*$a/100;
		$pph = $total * 0.3/100;
		$total_oat = $oat * $jumlah_pesanan;
		$total_seluruh = $total + $ppn + $hasil_pbbkb + $pph + $total_oat;

		//atur ID
		$getiddetail = mysqli_query($db,"SELECT LEFT(id_transaksi, 4) as thn, substring(id_transaksi,5,2) as bln, RIGHT(id_transaksi,3) as urut FROM transaksi ORDER BY id_transaksi DESC LIMIT 1");
		$data = mysqli_fetch_assoc($getiddetail);
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
		//insert
		$ins = mysqli_query($db,"INSERT INTO transaksi (id_transaksi, nama_p, tanggal_pesan, quantity, harga_jual, ppn, h_pbbkb, pph, total_oat, total, total_seluruh, truk_digunakan, sopir, no_segel, no_po, tax_no, suratjalan, invoice, pembuat_sj, pembuat_invoice) VALUES ('$setid', '$idperusahaan', '$today', '$jumlah_pesanan', '$harga_jual', '$ppn', '$hasil_pbbkb', '$pph', '$total_oat', '$total', '$total_seluruh', '$id_truk', '$id_sopir', '$no_segel', '$no_po', '$tax_no', NULL, NULL, '$pengguna','$pengguna');");
	    if (!$ins) {
	    	echo "
	    		<script>
	    			alert('Gagal membuat transaksi')
	    			document.location.href='form.php'
	    		</script>
	    	";
	    }else{
	    	mysqli_query($db,"UPDATE driver SET status = 'not' WHERE id_driver = '$id_sopir'");
	    	mysqli_query($db,"UPDATE truk SET status = 'not' WHERE id_truk = '$id_truk'");
	    	echo "
	    		<script>
	    			alert('Transaksi berhasil dibuat')
	    			document.location.href='index.php'
	    		</script>
	    	";
	    }
		
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Transaksi Baru</title>
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
		<form action="" method="POST">
			<div class="head">
				<label>Buat Transaksi Baru</label>
			</div>
			<div class="row m5">
				<div class="col-25">
					Nama Perusahaan
				</div>
				<div class="col-75">: 
					<select name="idperusahaan">
					<?php 
						$query = mysqli_query($db,"SELECT * FROM perusahaan");
						while ($get = mysqli_fetch_assoc($query)) {
							echo "<option value='$get[id_perusahaan]'>$get[nama_perusahaan]</option>";
						}
					?>
					</select>
				</div>
			</div>
			<div class="row m5">
					<div class="col-25"><label>Jumlah Pesanan<label></div>
					<div class="col-75">
						: <input type="text" name="quantity" id="jumlah_pesanan" required>
					</div>
				</div>
				<div class="row m5">
					<div class="col-25"><label>Harga Jual<label></div>
					<div class="col-75">
						: <input type="text" name="hargajual" id="hargaJual" required>
					</div>
				</div>
				<div class="row m5">
					<div class="col-25">
						Truk
					</div>
					<div class="col-75">: 
						<select name="id_truk">
						<?php 
							$query = mysqli_query($db,"SELECT * FROM truk WHERE status = 'ready'");
							while ($get = mysqli_fetch_assoc($query)) {
								echo "<option value='$get[id_truk]'>$get[nomor_plat]</option>";
							}
						?>
						</select>
					</div>
				</div>
				<div class="row m5">
					<div class="col-25">
						Sopir
					</div>
					<div class="col-75">: 
						<select name="id_sopir">
						<?php 
							$query = mysqli_query($db,"SELECT * FROM driver WHERE status = 'ready'");
							while ($get = mysqli_fetch_assoc($query)) {
								echo "<option value='$get[id_driver]'>$get[nama_driver]</option>";
							}
						?>
						</select>
					</div>
				</div>
				<div class="row m5">
					<div class="col-25"><label>No Pembelian <label style="color: red;">(opsional)</label><label></div>
					<div class="col-75">
						: <input type="text" name="no_po">
					</div>
				</div>
				<div class="row m5">
					<div class="col-25"><label>No Segel<label></div>
					<div class="col-75">
						: <input type="text" id="noSegel" name="no_segel" required>
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
	//jumlah_pesanan
	const jumlah_pesanan = document.getElementById('jumlah_pesanan');

	jumlah_pesanan.addEventListener('input', function() {
	  let start = this.selectionStart;
	  let end = this.selectionEnd;
	  
	  const current = this.value
	  const corrected = current.replace(/([^0-9]+)/gi, '');
	  this.value = corrected;
	  
	  if (corrected.length < current.length) --end;
	  this.setSelectionRange(start, end);
	});

	//hargaJual
	const hargaJual = document.getElementById('hargaJual');

	hargaJual.addEventListener('input', function() {
	  let start = this.selectionStart;
	  let end = this.selectionEnd;
	  
	  const current = this.value
	  const corrected = current.replace(/([^0-9]+)/gi, '');
	  this.value = corrected;
	  
	  if (corrected.length < current.length) --end;
	  this.setSelectionRange(start, end);
	});
	//noSegel
	const noSegel = document.getElementById('noSegel');

	noSegel.addEventListener('input', function() {
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