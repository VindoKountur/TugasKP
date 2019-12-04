<?php 
	session_start();
	include "../db.php";
	include "../fungsi.php";
	if (!isset($_SESSION['login'])) {
		header("location:../index.php");
		exit();
	}
	if (!isset($_GET['id'])) {
			echo "ID belum ditentukan";
			exit();
	}else{
		$id = $_GET['id'];
	}

	if (isset($_POST['submit'])) {
		$tax_no1 = $_POST['tax_no1'];
		$tax_no2 = $_POST['tax_no2'];
		$tax_no3 = $_POST['tax_no3'];
		$tax_no4 = $_POST['tax_no4'];
		$tax_no = "$tax_no1"."."."$tax_no2"."."."$tax_no3"."."."$tax_no4";

		//cek tax no
		if (strlen($tax_no) !== 19) {
			echo "
				<script>
					alert('Format faktur pajak yang dimasukkan salah')
					document.location.href='?id=$id&fp=1';
				</script>
			";
			exit();
		}
		$query = mysqli_query($db,"UPDATE transaksi SET tax_no = '$tax_no' WHERE id_transaksi = '$id'");
		if ($query) {
			echo "
				<script>
					alert('Nomor Faktur Pajak telah dimasukkan, invoice sudah bisa dibuat')
					document.location.href = 'index.php'
				</script>
			";
		}else{
			echo "
				<script>
					alert('Terjadi kesalahan')
				</script>
			";
		}

	}
		#nomor surat
		$getiddetail = mysqli_query($db,"SELECT LEFT(id_transaksi, 4) as tahun, substring(id_transaksi,5,2) as bulan, right(id_transaksi,3) as urut FROM transaksi WHERE id_transaksi = '$id'");
		$no = mysqli_fetch_assoc($getiddetail);
		$bulan = $no['bulan'];
		$romawibulan = romawi($bulan);
		$tahuninvoice = $no['tahun'];
		$urut = $no['urut'];
		$urutfix = sprintf("%03d", $urut); 
?>
<!DOCTYPE html>
<html>
<head>
	<title>Detail Transaksi</title>
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
		.main {
			width: 1235px;
			height: 500px;
			margin: 20px auto;
		}
		.mid {
			margin: 0 auto;
			width: 1020px;
			height: 100%;
			position: relative;
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
			float: left;
			width: 600px;
			height: 100%;
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
		.hover:hover, .kembali:hover, .ubah:hover {
			box-shadow: 2px 2px 5px rgba(0, 0, 0, .6);
		}
	</style>
</head>
<body style="margin: 0; padding: 0;">
<div class="header">
	<label>PT MITRA UTAMA ENERGI - DETAIL TRANSAKSI</label>
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
	<div class="back">
		<a href="index.php" class="kembali">Kembali</a>
	</div>
	<div class="main">
		<?php  
			$query = mysqli_query($db,"SELECT * FROM transaksi AS tr INNER JOIN perusahaan AS p ON tr.nama_p = p.id_perusahaan INNER JOIN truk AS t ON tr.truk_digunakan = t.id_truk INNER JOIN driver AS d ON tr.sopir = d.id_driver WHERE tr.id_transaksi = '$id'");
			$data = mysqli_fetch_assoc($query);
		?>
		<div class="mid">
			<div class="detail"">
				<div class="table-detail">
					<table>
						<?php 
							if (!$data) {
								echo "Terjadi kesalahan, data transaksi yang bersangkutan telah terhapus";
								?>
									
								<?php
								exit();
							}
						?>
						<tr>
							<th colspan="3">Detail Pemesanan</th>
						</tr>
						<tr>
							<td width="120">Nomor Invoice</td>
							<td width="10">: </td>
							<td><?php echo "$urutfix/INV/$romawibulan/$tahuninvoice"; ?></td>
						</tr>
						<tr>
							<td width="120">Perusahaan</td>
							<td width="10">: </td>
							<td><?php echo "$data[nama_perusahaan]";  ?></td>
						</tr>
						<tr>
							<td>Nomor PO</td>
							<td>: </td>
							<td><?php echo "$data[no_po]"; ?></td>
						</tr>
						<tr>
							<td>Tanggal Pesan</td>
							<td>: </td>
							<td><?php echo "$data[tanggal_pesan]"; ?></td>
						</tr>
						<tr>
							<td>Quantity</td>
							<td>: </td>
							<td><?php echo "$data[quantity]"; ?></td>
						</tr>
						<tr>
							<td>Jenis PBBKB</td>
							<td>: </td>
							<td><?php echo "$data[pbbkb]"; ?></td>
						</tr>
						<tr>
							<td>OAT /liter</td>
							<td>: </td>
							<td><?php echo "$data[oat]"; ?></td>
						</tr>
						<tr>
							<td>No Segel</td>
							<td>: </td>
							<td><?php echo "$data[no_segel]"; ?></td>
						</tr>
						<tr>
							<td>Mobil/Truk</td>
							<td>: </td>
							<td><?php echo "$data[nomor_plat]"; ?></td>
						</tr>
						<tr>
							<td>Sopir</td>
							<td>: </td>
							<td><?php echo "$data[nama_driver]"; ?></td>
						</tr>
						<tr>
							<td>No Faktur Pajak</td>
							<td>: </td>
							<td>
								<?php if (isset($_GET['fp'])) { ?>
									<form action="" method="POST">
										<input type="text" name="tax_no1" id="tax_no1" style="width: 24px;" maxlength="3">.
										<input type="text" name="tax_no2" id="tax_no2" style="width: 24px;" maxlength="3">.
										<input type="text" name="tax_no3" id="tax_no3" style="width: 15px;" maxlength="2">.
										<input type="text" name="tax_no4" id="tax_no4" style="width: 60px;" maxlength="8">
										<button name="submit" type="submit" style="background-color: blue; color: white; padding: 5px; width: 60px; border: none;" class="hover">Simpan</button>
									</form>	
								<?php }else{
										echo "$data[tax_no]"; 
									}
								?>	
							</td>
						</tr>
						<tr>
							<td><a href="ubah.php?id=<?php echo($id)?>" class="ubah">Ubah Data</a></td>
						</tr>
					</table>
				</div>
			</div>
			<div class="harga">
				<div class="table-harga">
					<table>
						<tr>
							<th colspan="3">Detail Harga</th>
						</tr>
						<tr>
							<td width="80">Harga Jual</td>
							<td width="10">: </td>
							<td>Rp. <?php echo (numchange($data['harga_jual'])); ?></td>
						</tr>
						<tr>
							<td>Total</td>
							<td>: </td>
							<td>Rp. <?php echo (numchange($data['total'])); ?></td>
						</tr>
						<tr>
							<td>PPN</td>
							<td>: </td>
							<td>Rp. <?php echo (numchange($data['ppn'])); ?></td>
						</tr>
						<tr>
							<td>PBBKB</td>
							<td>: </td>
							<td>Rp. <?php echo (numchange($data['h_pbbkb'])); ?></td>
						</tr>
						<tr>
							<td>PPH Migas</td>
							<td>: </td>
							<td>Rp. <?php echo (numchange($data['pph'])); ?></td>
						</tr>
						<tr>
							<td>OAT</td>
							<td>: </td>
							<td>Rp. <?php echo (numchange($data['total_oat'])); ?></td>
						</tr>
						<tr>
							<td>Jumlah</td>
							<td>: </td>
							<td>Rp. <?php echo (numchange($data['total_seluruh'])); ?></td>
						</tr>
					</table>
				</div>
			</div>
			<?php if (!empty($data['suratjalan'])) { ?>
				<a href="../print/suratjalan.php?id=<?php echo($data['id_transaksi']) ?>" target="_blank" style="text-decoration: none; color: white; font-size: 20px;">
				<div style="position: absolute; bottom: 115px; right: 243px; background-color: blue; padding: 10px;" class="hover">
					Lihat Surat Jalan
				</div>
				</a>
			<?php } ?>
			<?php if (!empty($data['invoice'])) { ?>
				<a href="../print/invoice.php?id=<?php echo($data['id_transaksi']) ?>" target="_blank" style="text-decoration: none; color: white; font-size: 20px;">
				<div style="position: absolute; bottom: 115px; right: 105px; background-color: blue; padding: 10px; " class="hover">
					Lihat Invoice
				</div>
				</a>
			<?php } ?>
		</div>
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