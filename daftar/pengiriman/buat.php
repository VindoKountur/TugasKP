<?php 
include '../../db.php';
$tempatKirim = strtoupper($_GET['lokasi']);
$harga = $_GET['harga'];
if (isset($_GET['update'])) {
	$id = $_GET['id'];
	$sql = "UPDATE pengiriman SET tempat_kirim = '$tempatKirim', harga_kirim = '$harga' WHERE id_kirim = '$id'";
}else{
	$sql = "INSERT INTO pengiriman (id_kirim, tempat_kirim, harga_kirim) VALUES (NULL, '$tempatKirim', '$harga')";
}
//cek duplikat
$querycek = mysqli_query($db, "SELECT tempat_kirim from pengiriman WHERE tempat_kirim = '$tempatKirim'");
$cek = mysqli_num_rows($querycek);
	//database
    $ins = mysqli_query($db, $sql);
    if (!$ins) {
    	echo "fail";
    	exit();
    }else{
    	if (isset($_GET['update'])) {
    		echo "
            <script>
                alert('Data berhasil diubah')
                document.location.href = 'index.php';
            </script>
        ";
    	}else{
    		echo "
            <script>
                alert('Data berhasil ditambah')
                document.location.href = 'index.php';
            </script>
        ";
    	}
    }
?>