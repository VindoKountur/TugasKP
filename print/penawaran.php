<?php
include '../db.php';
include '../fungsi.php';
require_once __DIR__ . '/vendor/autoload.php';

#profil
$query = mysqli_query($db, "SELECT * FROM profil");
$profil_data = mysqli_fetch_assoc($query);
$nomortelepon = $profil_data['no_telepon'];
$pengguna = $profil_data['pengguna'];
$idsp=$_GET['idsp'];
$get = mysqli_query($db,"SELECT * FROM penawaran WHERE id_sp ='$idsp'");
$data = mysqli_fetch_array($get,MYSQLI_ASSOC);
$tanggalbuat = $data['tanggal_buat'];
$nama_p = $data['nama_p'];
$periode = $data['periode_surat'];
if (empty($data['lampiran'])) {
	$lampiran = "-";
}else{
	$lampiran = $data['lampiran'];
}
$hp = $data['harga_pokok'];
$dd = $data['diskon'];
$hdd = $data['harga_dasar'];
$pajak1d = $data['ppn'];
$pajak2d = $data['pbbkb'];
$pajak3d = $data['pph_migas'];
$oat = $data['oat'];
$ttl = $data['total'];
$modepbbkb = $data['pbbkb_m'];
$pembuat = $data['pembuat'];

//det
$last3 = mysqli_query($db,"SELECT right(id_sp,3) as urut FROM penawaran WHERE id_sp = '$idsp'");
$dl3 = mysqli_fetch_array($last3, MYSQLI_ASSOC);
$urut = $dl3['urut'];
if ($modepbbkb == 1) {
	$cpbbkb = "17%";
}elseif ($modepbbkb == 2) {
	$cpbbkb = "90%";
}elseif ($modepbbkb == 3) {
	$cpbbkb = "100%";
}

//numchange
	$hpp = numchange($hp);
	$dis = numchange($dd);
	$hd = numchange($hdd);
	$pajak1 = numchange($pajak1d);
	$pajak2 = numchange($pajak2d);
	$pajak3 = numchange($pajak3d);
	$oatt = numchange($oat);
	$ttll = numchange($ttl);
	//tanggal
    $gettgl = mysqli_query($db,	"SELECT MONTH(tanggal_buat) as bulan, YEAR(tanggal_buat) as tahun, DAY(tanggal_buat) as hari FROM penawaran WHERE id_sp = '$idsp'");
    $d = mysqli_fetch_array($gettgl, MYSQLI_ASSOC);
	$thnini = $d['tahun'];
	$blnini = $d['bulan'];
	$tgl = $d['hari'];
	$thari=cal_days_in_month(CAL_GREGORIAN,$blnini,$thnini);
	if ($periode == 1) {
		$tlsperiode = "01 - 14";
	}else{
		$tlsperiode = "15 - $thari";
	}
	if ($blnini == 1) {
      $nmbln = "Januari";
      $rmwbln = "I";
    }elseif ($blnini == 2) {
      $nmbln = "Februari";
      $rmwbln = "II";
    }elseif ($blnini == 3) {
      $nmbln = "Maret";
      $rmwbln = "III";
    }elseif ($blnini == 4) {
      $nmbln = "April";
      $rmwbln = "IV";
    }elseif ($blnini == 5) {
      $nmbln = "Mei";
      $rmwbln = "V";
    }elseif ($blnini == 6) {
      $nmbln = "Juni";
      $rmwbln = "VI";
    }elseif ($blnini == 7) {
      $nmbln = "Juli";
      $rmwbln = "VII";
    }elseif ($blnini == 8) {
      $nmbln = "Agustus";
      $rmwbln = "VIII";
    }elseif ($blnini == 9) {
      $nmbln = "September";
      $rmwbln = "IX";
    }elseif ($blnini == 10) {
      $nmbln = "Oktober";
      $rmwbln = "X";
    }elseif ($blnini == 11) {
      $nmbln = "November";
      $rmwbln = "XI";
    }elseif ($blnini == 12) {
      $nmbln = "Desember";
      $rmwbln = "XII";
    }

$mpdf = new \Mpdf\Mpdf();
$mpdf->AddPageByArray([
    'margin-left' => 0,
    'margin-right' => 0,
    'margin-top' => 0,
    'margin-bottom' => 0,
]);
$html = "<!DOCTYPE html>
		<html>
		<head>
			<title>Surat Penawaran</title>
			<link rel='stylesheet' type='text/css' href='css/penawaran.css'>
		</head>
		<body>
		<div class='bodysp'>
		<div>
		<img src='img/headerpenawaran.png'>
		<br>
		<div class='contain'>
			<br>
			<label>Manado, $tgl $nmbln $thnini</label><br><br>
			<div class='col-25'>
				<label>No</label>
			</div>
				<label> : $urut/MUE/SP/$rmwbln/$thnini</label><br>
			<div class='col-25'>
				<label>Lampiran</label>
			</div>
				<label> : $lampiran</label><br>
			<div class='col-25'>
				<label>Perihal</label>
			</div>
				<label> : Penawaran Harga Solar BBM Industri</label><br><br>
				<label>Kepada Yth,</label><br>
				<label>PIMPINAN</label><br>
				<label>$nama_p</label><br>
			<div class='col-25'>
				<label>Di</label>
			</div>
				<label> : Tempat</label><br>
		<h4>Dengan Hormat,</h4>
		<p align='justify'>Dengan ini kami dari PT. Mitra Utama Energi bermaksud menawarkan untuk mengadakan kerjasama dengan perusahaan bapak, dengan mensuplai bahan bakar minyak solar industri spek Pertamina, dengan perincian untuk periode $tlsperiode $nmbln $thnini sebagai berikut :</p>
		<div class='col-25'>
			<span>Harga Pokok</span>
		</div>
		<div class='col-75'>
			<div class='col-10'>: Rp. </div>
			<div class='col-num'>$hpp</div>
		</div>
		<div class='col-25'>
			<span>Diskon</span>
		</div>
		<div class='col-75'>
			<div class='col-10'>: Rp. </div>
			<div class='col-num' style='border-bottom:1px solid black ;'>$dis</div>
		</div>
		<div class='col-25'>
			<span>Harga Dasar</span>
		</div>
		<div class='col-75'>
			<div class='col-10'>: Rp. </div>
			<div class='col-num'>$hd</div>
		</div>
		<div class='col-25'>
			<span>PPN 10%</span>
		</div>
		<div class='col-75'>
			<div class='col-10'>: Rp. </div>
			<div class='col-num'>$pajak1</div>
		</div>
		<div class='col-25'>
			<span>PBBKB $cpbbkb</span>
		</div>
		<div class='col-75'>
			<div class='col-10'>: Rp. </div>
			<div class='col-num'>$pajak2</div>
		</div>
		<div class='col-25'>
			<span>PPH Migas 0,3%</span>
		</div>
		<div class='col-75'>
			<div class='col-10'>: Rp. </div>
			<div class='col-num'>$pajak3</div>
		</div>
		<div class='col-25'>
			<span>OAT</span>
		</div>
		<div class='col-75'>
			<div class='col-10'>: Rp. </div>
			<div class='col-num'>$oatt</div>
		</div>
		<div class='col-25'>
			<span>Total</span>
		</div>
		<div class='col-75'>
			<div class='col-10'>: Rp. </div>
			<div class='col-num' style='border-top: 2px solid black;'>$ttll</div>
		</div>
		<p>*Pembayaran Negosiasi<br>*Solar diantar sampai lokasi<br>*Untuk keterangan lebih lanjut, hubungi kami di $nomortelepon</p>
		<p align='justify'>Demikian Surat Penawaran ini, kiranya Perusahaan kami dan Perusahaan Bapak dapat bekerjasama dengan baik.
		Atas perhatiannya kami ucapkan terima kasih.</p>
		<br><br>
		<div style='width:150px;'>
			<div style='text-align:center;'>Hormat Kami</div><br><br><br><br>
			<div style='text-align:center;'>$pembuat</div>
		</div>
		</div>
		<img src='img/footerpenawaran.png' style='margin-top:2.3em; width:100%; bottom:0;'>
	</div>
	</div>
	</body>
	</html>
";
$mpdf->WriteHTML($html);
$mpdf->Output();

?>