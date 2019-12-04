<?php 
include '../../db.php';
include '../../fungsi.php';
$nama = strtoupper($_GET['nama']);
$npwp1 = $_GET['npwp1'];
$npwp2 = $_GET['npwp2'];
$npwp3 = $_GET['npwp3'];
$npwp4 = $_GET['npwp4'];
$npwp5 = $_GET['npwp5'];
$npwp6 = $_GET['npwp6'];
$npwp = "$npwp1"."."."$npwp2"."."."$npwp3"."."."$npwp4"."-"."$npwp5"."."."$npwp6";
$notelepon = $_GET['notelepon'];
$pbbkb = $_GET['pbbkb'];
$alamatkirim = strtoupper($_GET['alamatkirim']);
$jalan = strtoupper($_GET['jalan']);
$kabkota = strtoupper($_GET['kabkota']);
$provinsi = strtoupper($_GET['provinsi']);

//ambil oat
$queryOAT = mysqli_query($db,"SELECT * FROM pengiriman WHERE tempat_kirim = '$alamatkirim'");
$dataOAT = mysqli_fetch_assoc($queryOAT);
$oat = $dataOAT['harga_kirim'];


//cek npwp
if (strlen($npwp) !== 20) {
    echo "
        <script>
            alert('Format NPWP yang dimasukkan salah')
            document.location.href = 'form.php';
        </script>
    ";
    exit();
}
if (!isset($_GET['update'])) {
    //cek perusahaan
    $querycek = mysqli_query($db, "SELECT npwp from perusahaan WHERE npwp = '$npwp'");
    $cek = mysqli_num_rows($querycek);
    if ($cek !== 0) {
        echo "
            <script>
                alert('Perusahaan telah terdaftar')
                document.location.href = 'form.php';
            </script>
        ";
        exit();
    }   
}
if (isset($_GET['update'])) {
    $id = $_GET['id'];
    $sql = "UPDATE perusahaan SET nama_perusahaan = '$nama', npwp = '$npwp', jalan = '$jalan', kabkota = '$kabkota', provinsi = '$provinsi', ship_to = '$alamatkirim', no_telp = '$notelepon', oat = '$oat', pbbkb = '$pbbkb' WHERE id_perusahaan = $id;";
}else{
	$sql = "INSERT INTO perusahaan (id_perusahaan, nama_perusahaan, npwp, jalan, kabkota, provinsi, ship_to, no_telp, oat, pbbkb) VALUES (NULL, '$nama', '$npwp', '$jalan', '$kabkota', '$provinsi', '$alamatkirim', '$notelepon', '$oat', '$pbbkb')";
}
	//database
    $ins = mysqli_query($db,$sql);
    if (!$ins) {
    	echo "fail";
    	exit();
    }else{
    	if (isset($_GET['update'])) {
    		 echo "
            <script>
                alert('Data berhasil di ubah')
                document.location.href = 'index.php';
            </script>
        ";
    	}else{
    		 echo "
            <script>
                alert('Perusahaan berhasil ditambah')
                document.location.href = 'index.php';
            </script>
        ";
    	}
    }
?>