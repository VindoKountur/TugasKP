<?php
	include '../db.php';
	include '../fungsi.php';

	#profil
	$query = mysqli_query($db,"SELECT * FROM profil WHERE id='1'");
	$profil = mysqli_fetch_assoc($query);
	$profil_email = $profil['email'];
	$today = date("Y-m-d");

	$tr_id = $_GET['id'];
	//CEK
	$query = mysqli_query($db,"SELECT suratjalan FROM transaksi WHERE id_transaksi = '$tr_id'");
	$a = mysqli_fetch_assoc($query);
	if (empty($a['suratjalan'])) {
		echo "
			<script>
				alert('invoice belum bisa dibuat, surat jalan belum pernah dibuat')
			</script>
		";
		echo "invoice belum bisa dibuat, surat jalan belum pernah dibuat";
		exit();
	}
	$query = mysqli_query($db,"SELECT tax_no FROM transaksi WHERE id_transaksi= '$tr_id'");
	$a = mysqli_fetch_assoc($query);
	if (empty($a['tax_no'])) {
		echo "
			<script>
				alert('No Faktur Pajak belum dimasukkan, silahkan masukan nomor faktur pajak')
				document.location.href = '../transaksi/detail.php?id=$tr_id&fp=1'
			</script>
		";
		exit();
	}
	$query = mysqli_query($db,"SELECT invoice, truk_digunakan, sopir FROM transaksi WHERE id_transaksi = '$tr_id'");
	$a = mysqli_fetch_assoc($query);
	if (is_null($a['invoice'])) {
		#truk sopir
		$truk = $a['truk_digunakan'];
		$sopir = $a['sopir'];
		mysqli_query($db,"UPDATE transaksi SET invoice = '$today' WHERE id_transaksi = '$tr_id'");
		mysqli_query($db,"UPDATE driver SET status = 'ready' WHERE id_driver = '$sopir'");
		mysqli_query($db,"UPDATE truk SET status = 'ready' WHERE id_truk = '$truk'");
	}

	#id
	$getiddetail = mysqli_query($db,"SELECT LEFT(id_transaksi, 4) as tahun, substring(id_transaksi,5,2) as bulan, right(id_transaksi,3) as urut FROM transaksi WHERE id_transaksi = '$tr_id'");
	$no = mysqli_fetch_assoc($getiddetail);
	$bulan = $no['bulan'];
	$romawibulan = romawi($bulan);
	$tahuninvoice = $no['tahun'];
	$urut = $no['urut'];
	$urutfix = sprintf("%03d", $urut); 

	#TRANSAKSI
	$query = mysqli_query($db,"SELECT *, month(suratjalan) as bulansj, day(suratjalan) as harisj, year(suratjalan) as tahunsj, month(invoice) as bulaninv, day(invoice) as hariinv, year(invoice) as tahuninv FROM transaksi as tr INNER JOIN perusahaan as p ON tr.nama_p = p.id_perusahaan INNER JOIN truk as t ON tr.truk_digunakan = t.id_truk WHERE tr.id_transaksi='$tr_id'");
	$cek = mysqli_num_rows($query);
	if ($cek == 0) {
		echo "Ada yang salah, data perusahaan yang berkaitan telah terhapus";
		exit();
	}
	$data = mysqli_fetch_assoc($query);
	#delivery date
	$bulansj = namabulan($data['bulansj']);
	$tahunsj = $data['tahunsj'];
	$harisj = $data['harisj'];

	#invoice date
	$bulaninv = namabulan($data['bulaninv']);
	$tahuninv = $data['tahuninv'];
	$hariinv = $data['hariinv'];

	#lain
	$pembuat = $data['pembuat_invoice'];
	$no_po = $data['no_po'];
	$tax_no = $data['tax_no'];
	$nama_perusahaan = $data['nama_perusahaan'];
	$npwp = $data['npwp'];
	$ship_to = $data['ship_to'];
	$nomor_plat = $data['nomor_plat'];
	$quantity = $data['quantity'];
	$harga_jual = formatharga($data['harga_jual']);
	$total = numchange($data['total']);
	$ppn = numchange($data['ppn']);
	$j_pbbkb = $data['pbbkb'];
	$pbbkb = numchange($data['h_pbbkb']);
	$pph = numchange($data['pph']);
	$oat = numchange($data['total_oat']);
	$seluruh = numchange($data['total_seluruh']);
	$ini = $data['total_seluruh'];
	$ini=ceil($ini);
		if (substr($ini,-3)>499){
		    $total_harga=round($ini,-3);
		} elseif (substr($ini,-3) == 0) {
			$total_harga=$ini;
		} else {
		    $total_harga=round($ini,-3)+1000;
		}
	$itu = numchange($total_harga);

	
	$terbilang = terbilang($total_harga);
require_once __DIR__ . '/vendor/autoload.php';
$mpdf = new \Mpdf\Mpdf();
$mpdf->AddPageByArray([
    'margin-left' => 15,
    'margin-right' => 15,
    'margin-top' => 15,
    'margin-bottom' => 15,
]);
$html = "<!DOCTYPE html>
		<html>
		<head>
			<title>INVOICE</title>
			<link rel='stylesheet' type='text/css' href='css/invoice.css'>
		</head>
		<body>
		<div class='grup1'>
		<div class='logo'>
			<img src='../img/logo.jpg'>
		</div>
		<div class='head'>
			<span>INVOICE</span>
		</div>
	</div>
	<div class='clr'></div>
	<div class='grup2'>
		<div class='alamat'>
			<p>
				PT. MITRA UTAMA ENERGI<br>
				JL. RING ROAD KEL. BUMI NYIUR<br>
				LING. V KEC. WANEA KOTA MANADO
			</p>
			<label>EMAIL : $profil_email</label>
		</div>
		<div class='detinvoice'><br>
			<div class='col-40'>
				<label>TANGGAL</label>
			</div>
				<label> : $hariinv $bulaninv $tahuninv</label><br>
			<div class='col-40'>
				<label>NO INVOICE</label>
			</div>
				<label> : $urutfix/INV/$romawibulan/$tahuninvoice</label><br>
			<div class='col-40'>
				<label>NO PEMBELIAN</label>
			</div>
				<label> : $no_po</label><br>
			<div class='col-40'>
				<label>NO FAKTUR PAJAK</label>
			</div>
				<label> : $tax_no</label><br>
			<div></div>
		</div>
	</div>
	<div class='clr'></div>
	<div class='grup3'>
		<div class='billto'>
			<table border='1' cellspacing='0' style='width: 90%;'>
				<tr>
					<th>TAGIHAN KEPADA</th>
				</tr>
				<tr>
					<td class='kolominput'>$nama_perusahaan</td>
				</tr>
				<tr>
					<td>NPWP : $npwp</td>
				</tr>
			</table>
		</div>
		<div class='shipto'>
			<table border='1' cellspacing='0' style='width: 95%;'>
				<tr>
					<th>PENGANTARAN KE</th>
				</tr>
				<tr>
					<td class='kolominput'>$ship_to</td>
				</tr>
				<tr>
					<td>Nomor Plat : $nomor_plat</td>
				</tr>
			</table>
		</div>
	</div>
	<div class='clr'></div>
	<div class='detpesan'>
		<table border='1' cellspacing='0' style='width: 98%;'>
			<tr>
				<th>Tanggal Pengantaran</th>
				<th>Deskripsi</th>
				<th>Jumlah Pesanan</th>
				<th>Harga</th>
				<th>Sub Total</th>
			</tr>
			<tr>
				<td style='text-align:center;'>$harisj $bulansj $tahunsj</td>
				<td style='text-align:center;'>SOLAR HSD</td>
				<td style='text-align:center;'>$quantity Liters</td>
				<td style='text-align:center;'>$harga_jual</td>
				<td style='text-align:center;'>$total</td>
			</tr>
		</table>
	</div>
	<br>
	<div class='detharga'>
		<div style='width: 100%;'>
			<div class='col-25'>
				<span>SUB TOTAL</span>
			</div>
			<div class='col-75'>
				<div class='col-10'>: Rp. </div>
				<div class='col-num'>$total</div>
			</div>
			<div class='col-25'>
				<span>PPN 10%</span>
			</div>
			<div class='col-75'>
				<div class='col-10'>: Rp. </div>
				<div class='col-num'>$ppn</div>
			</div>
			<div class='col-25'>
				<span>PBBKB $j_pbbkb%</span>
			</div>
			<div class='col-75'>
				<div class='col-10'>: Rp. </div>
				<div class='col-num'>$pbbkb</div>
			</div>
			<div class='col-25'>
				<span>PPH MIGAS 0,3%</span>
			</div>
			<div class='col-75'>
			<div class='col-10'>: Rp. </div>
			<div class='col-num'>$pph</div>
			</div>
			<div class='col-25'>
				<span>OAT</span>
			</div>
			<div class='col-75'>
				<div class='col-10'>: Rp. </div>
				<div class='col-num'>$oat</div>
			</div>
			<div class='col-25'>
				<span>TOTAL PEMBAYARAN</span>
			</div>
			<div class='col-75'>
				<div class='col-10'>: Rp. </div>
				<div class='col-num' style='border-top: 2px solid black;'>$seluruh</div>
			</div>
			<div class='col-25'>
				<span>PEMBULATAN</span>
			</div>
			<div class='col-75'>
				<div class='col-10'>: Rp. </div>
				<div class='col-num'>$itu</div>
			</div>
		</div>
	</div>
	<div class='clr'></div>
	<br>
	<div>Terbilang : </div>
	<div class='terbilang' style='width: 100%; height: 25px; border: 1px solid black; text-align: center; font-weight: bold; font-style: italic;'>
		# $terbilang Rupiah #
	</div><br>
	<div>
		<div>PT Mitra Utama Energi</div>
		<br><br><br><br><br>
		<div style='width:100px; text-align:center;'>( $pembuat )</div>
	</div>
	</body>
	</html>
";
$mpdf->WriteHTML($html);
$mpdf->Output();

?>