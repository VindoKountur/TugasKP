<?php 
	session_start();
	include "../db.php";
	if (!isset($_SESSION['login'])) {
		header("location:../index.php");
		exit();
	}
	if (isset($_POST['submit'])) {
		$id_transaksi = $_POST['id'];
		$idperusahaan = $_POST['idperusahaan'];
		$jumlah_pesanan = $_POST['quantity'];
		$harga_jual = $_POST['hargajual'];
		$id_truk = $_POST['id_truk'];
		$id_sopir = $_POST['id_sopir'];
		$no_po = $_POST['no_po'];
		$no_segel = $_POST['no_segel'];
		$tax_no1 = $_POST['tax_no1'];
		$tax_no2 = $_POST['tax_no2'];
		$tax_no3 = $_POST['tax_no3'];
		$tax_no4 = $_POST['tax_no4'];
		$tax_no = "$tax_no1"."."."$tax_no2"."."."$tax_no3"."."."$tax_no4";
		$today = date("Y-m-d");

		if (strlen($tax_no) !== 19) {
			echo "
				<script>
					alert('Format faktur pajak yang dimasukkan salah')
					document.location.href='?id=$id_transaksi';
				</script>
			";
			exit();
		}
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

		//detail
		$total = $harga_jual * $jumlah_pesanan;
		$ppn = $total*10/100;
		$hasil_pbbkb = $total*$a/100;
		$pph = $total * 0.3/100;
		$total_seluruh = $total + $ppn + $hasil_pbbkb + $pph;
		$total_oat = $oat * $jumlah_pesanan;
		//insert
		$update = mysqli_query($db, "UPDATE transaksi SET nama_p = '$idperusahaan', quantity = '$jumlah_pesanan', harga_jual = '$harga_jual', ppn = '$ppn', h_pbbkb = '$hasil_pbbkb', pph = '$pph', total_oat = '$total_oat', total = '$total', total_seluruh = '$total_seluruh', truk_digunakan = '$id_truk', sopir = '$id_sopir', no_segel = '$no_segel', no_po = '$no_po', tax_no = '$tax_no' WHERE id_transaksi = '$id_transaksi'");
	    if (!$update) {
	    	echo "
	    		<script>
	    			alert('Gagal mengubah transaksi')
	    		</script>
	    	";
	    }else{
	    	echo "
	    		<script>
	    			alert('Transaksi berhasil diubah')
	    			document.location.href = 'index.php'
	    		</script>
	    	";
	    }
		
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Ubah Transaksi</title>
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
			margin-top: 15px;
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
			<?php 
				$id = $_GET['id'];
				$query = mysqli_query($db,"SELECT *, LEFT(tax_no, 3) as tax_no1, substring(tax_no,5,3) as tax_no2, substring(tax_no,9,2) as tax_no3, right(tax_no,8) as tax_no4 FROM transaksi WHERE id_transaksi = '$id'");
				$t = mysqli_fetch_assoc($query);
			?>
			<div class="head">
				<label>Ubah Transaksi</label>
			</div>
			<!-- ID -->
			<input type="hidden" name="id" value="<?php echo($id) ?>">
			<div class="row m5">
				<div class="col-25">
					Nama Perusahaan
				</div>
				<div class="col-75">: 
					<select name="idperusahaan">
					<?php 
						$query = mysqli_query($db,"SELECT * FROM perusahaan");
						while ($get = mysqli_fetch_assoc($query)) {
							if ($get['id_perusahaan'] == $t['nama_p']) {
								echo "<option value='$get[id_perusahaan]' selected>$get[nama_perusahaan]</option>";
							}else{
								echo "<option value='$get[id_perusahaan]'>$get[nama_perusahaan]</option>";
							}
						}
					?>
					</select>
				</div>
			</div>
			<div class="row m5">
					<div class="col-25"><label>Quantity<label></div>
					<div class="col-75">
						: <input type="number" name="quantity" required value="<?php echo($t['quantity']) ?>">
					</div>
				</div>
				<div class="row m5">
					<div class="col-25"><label>Harga Jual<label></div>
					<div class="col-75">
						: <input type="number" name="hargajual" required value="<?php echo($t['harga_jual']) ?>">
					</div>
				</div>
				<div class="row m5">
					<div class="col-25">
						Truk
					</div>
					<div class="col-75">: 
						<select name="id_truk">
						<?php 
							$query = mysqli_query($db,"SELECT * FROM truk");
							while ($get = mysqli_fetch_assoc($query)) {
								if ($get['id_truk'] == $t['truk_digunakan']) {
									echo "<option value='$get[id_truk]' selected>$get[nomor_plat]</option>";
								}else{
									echo "<option value='$get[id_truk]'>$get[nomor_plat]</option>";
								}
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
							$query = mysqli_query($db,"SELECT * FROM driver");
							while ($get = mysqli_fetch_assoc($query)) {
								if ($get['id_driver'] == $t['sopir']) {
									echo "<option value='$get[id_driver]' selected>$get[nama_driver]</option>";
								}else{
									echo "<option value='$get[id_driver]'>$get[nama_driver]</option>";
								}
							}
						?>
						</select>
					</div>
				</div>
				<div class="row m5">
					<div class="col-25"><label>No Pembelian (optional)<label></div>
					<div class="col-75">
						: <input type="text" name="no_po" value="<?php echo($t['no_po']) ?>">
					</div>
				</div>
				<div class="row m5">
					<div class="col-25"><label>No Segel<label></div>
					<div class="col-75">
						: <input type="number" name="no_segel" required value="<?php echo($t['no_segel']) ?>">
					</div>
				</div>
				<div class="row m5">
					<div class="col-25"><label>No Faktur Pajak<label></div>
					<div class="col-75">
						: 
						<input type="text" name="tax_no1" id="tax_no1" value="<?php echo($t['tax_no1']) ?>" style="width: 24px;" maxlength="3">.
						<input type="text" name="tax_no2" id="tax_no2" value="<?php echo($t['tax_no2']) ?>" style="width: 24px;" maxlength="3">.
						<input type="text" name="tax_no3" id="tax_no3" value="<?php echo($t['tax_no3']) ?>" style="width: 15px;" maxlength="2">.
						<input type="text" name="tax_no4" id="tax_no4" value="<?php echo($t['tax_no4']) ?>" style="width: 60px;" maxlength="8">
					</div>
				</div>
				<div class="row">
					<div class="col-25 m5" style="line-height: 40px;"><a href="detail.php?id=<?php echo($id) ?>" class="batal">Kembali</a>
					</div>
					<div class="col-25">
		        		<input type="submit" name="submit" class="buat" value="Ubah Data" style="width: 200px;">
					</div>
				</div>
		</form>
	</div>
	<script type="text/javascript">
		//1
		const tax_no1 = document.getElementById('tax_no1');

		tax_no1.addEventListener('input', function() {
		  let start = this.selectionStart;
		  let end = this.selectionEnd;
		  
		  const current = this.value
		  const corrected = current.replace(/([^+0-9]+)/gi, '');
		  this.value = corrected;
		  
		  if (corrected.length < current.length) --end;
		  this.setSelectionRange(start, end);
		});

		//2
		const tax_no2 = document.getElementById('tax_no2');

		tax_no2.addEventListener('input', function() {
		  let start = this.selectionStart;
		  let end = this.selectionEnd;
		  
		  const current = this.value
		  const corrected = current.replace(/([^+0-9]+)/gi, '');
		  this.value = corrected;
		  
		  if (corrected.length < current.length) --end;
		  this.setSelectionRange(start, end);
		});

		//3
		const tax_no3 = document.getElementById('tax_no3');

		tax_no3.addEventListener('input', function() {
		  let start = this.selectionStart;
		  let end = this.selectionEnd;
		  
		  const current = this.value
		  const corrected = current.replace(/([^+0-9]+)/gi, '');
		  this.value = corrected;
		  
		  if (corrected.length < current.length) --end;
		  this.setSelectionRange(start, end);
		});

		//4
		const tax_no4 = document.getElementById('tax_no4');

		tax_no4.addEventListener('input', function() {
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