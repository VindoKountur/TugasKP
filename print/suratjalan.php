<?php
	include "../db.php";
	include "../fungsi.php";
	require_once __DIR__ . '/vendor/autoload.php';

	#profil
	$query = mysqli_query($db,"SELECT * FROM profil WHERE id='1'");
	$profil = mysqli_fetch_assoc($query);
	$profil_no_telepon = $profil['no_telepon'];
	$profil_email = $profil['email'];
	$today = date("Y-m-d");

	$id_transaksi=$_GET['id'];
	$query = mysqli_query($db,"SELECT suratjalan FROM transaksi WHERE id_transaksi = '$id_transaksi'");
	$a = mysqli_fetch_assoc($query);
	if (is_null($a['suratjalan'])) {
		$query = mysqli_query($db,"UPDATE transaksi SET suratjalan = '$today' WHERE id_transaksi = '$id_transaksi'");
		if (!$query) {
			echo "gagal input data";
			exit();
		}
	}
	
	#transaksi
	$query = mysqli_query($db,"SELECT p.nama_perusahaan, p.ship_to, t.nomor_plat, tr.quantity, tr.no_segel, d.nama_driver, tr.pembuat_sj FROM transaksi AS tr INNER JOIN driver AS d ON tr.sopir = d.id_driver INNER JOIN truk AS t ON tr.truk_digunakan = t.id_truk INNER JOIN perusahaan AS p ON tr.nama_p = p.id_perusahaan WHERE tr.id_transaksi = '$id_transaksi'");
	$cek = mysqli_num_rows($query);
	if ($cek == 0) {
		echo "Ada yang salah, data perusahaan yang berkaitan telah terhapus";
		exit();
	}
	$tr = mysqli_fetch_assoc($query);
	$tr_namap = $tr['nama_perusahaan'];
	$tr_shipto = $tr['ship_to'];
	$tr_noplat = $tr['nomor_plat'];
	$tr_quantity = $tr['quantity'];
	$tr_nosegel = $tr['no_segel'];
	$tr_namad = $tr['nama_driver'];
	$tr_pembuat = $tr['pembuat_sj'];

	#NO URUT + TANGGAL
	$query = mysqli_query($db,"SELECT right(id_transaksi,3) as urut, MONTH(tanggal_pesan) as bulan_pesan, YEAR(tanggal_pesan) as tahun_pesan, DAY(tanggal_pesan) as hari_pesan, MONTH(suratjalan) as bulan_suratjalan, YEAR(suratjalan) as tahun_suratjalan, DAY(suratjalan) as hari_suratjalan FROM transaksi WHERE id_transaksi = '$id_transaksi'");
	$get = mysqli_fetch_assoc($query);
	$urut = $get['urut'];
	$tgl_bulan = romawi($get['bulan_pesan']);
	$tgl_tahun = $get['tahun_pesan'];
	$tgl_hari = $get['hari_pesan'];
	$sj_tahun = $get['tahun_suratjalan'];
	$sj_bulan = namabulan($get['bulan_suratjalan']);
	$sj_hari = $get['hari_suratjalan'];
	$terbilang = terbilang($tr_quantity);
	
$mpdf = new \Mpdf\Mpdf();
$mpdf->AddPageByArray([
    'margin-left' => 5,
    'margin-right' => 5,
    'margin-top' => 5,
    'margin-bottom' => 5,
]);
$html = "<!DOCTYPE html>
		<html>
		<head>
			<title>Surat Jalan</title>
			<link rel='stylesheet' type='text/css' href='css/suratjalan.css'>
		</head>
		<body>
		<div class='atas1'>
			<div class='atas11'>MITRA UTAMA ENERGI</div><br>
			<div class='atas12'><img src='../img/logo.jpg'></div>
		</div>
		<div class='atas2' style='position:absolute; left:300px; top:80px;'>
			<div class='atas21'>SURAT JALAN</div>
			<div class='atas22'>BUKTI SERAH TERIMA BBM</div><br>
			<div class='atas23'>No. : $urut/MUE/SJ/$tgl_bulan/$tgl_tahun</div> 
		</div>
		<div class='atas3'>
			<div>Kepada : $tr_namap, $tr_shipto</div><br>
			<div>Pada hari ini, Tanggal $sj_hari $sj_bulan $sj_tahun telah diserahkan BBM Biosolar dengan mobil tangki $tr_noplat</div>
			<div>Sejumlah : $tr_quantity ( $terbilang ) Liter</div>
		</div>
		<br>
		<div class = 'tenga'>
			<table border='0' cellspacing='0'>
				<tr>
					<td>BERANGKAT DARI BITUNG</td>
					<td>:</td>
					<td width='200'></td>
					<td>BONGKAR MULAI</td>
					<td>:</td>
					<td width='200'></td>
				</tr>
				<tr>
					<td>TIBA DI TUJUAN</td>
					<td>:</td>
					<td></td>
					<td>SELESAI</td>
					<td>:</td>
					<td></td>
				</tr>
			</table>
		</div>
		<br>
		<div class='bawah1'>
			**No. Segel Kompartemen : $tr_nosegel
		</div><br>
		<div class='bawah2'>  
			<div class='kiri'>
				 <div>Yang Menerima</div><br><br><br><br><br>
				 <div>(..........................)</div>
				 <div>Nama & Stampel</div>
			</div>
			<div class='kanan'>
				 <div class='kanan1'>
				 	<div>YANG MENERIMA</div>
				 	<div>MITRA UTAMA ENERGI</div>
				 </div>
				 <br><br><br><br>
				 <div class='kanan2'>
				 	<div class='kanan21'>
				 		<div>( $tr_pembuat )</div>
				 		<div>Pengurus</div>
				 	</div>
				 	<div class='kanan22'>
				 		<div>( $tr_namad )</div>
				 		<div>Driver</div>
				 	</div>
				 </div>
			</div>
		</div>
		</body>
		</html>
";
$mpdf->WriteHTML($html);
$mpdf->Output();


?>
