<?php 
include '../../db.php';
include '../../fungsi.php';

$nama = strtoupper($_GET['nama']);
$notelepon = $_GET['notelepon'];
if (isset($_GET['update'])) {
	$id = $_GET['id'];
	$sql = "UPDATE driver SET nama_driver = '$nama', no_telp = '$notelepon' WHERE id_driver = $id;";
}else {
	$sql = "INSERT INTO driver (id_driver, nama_driver, no_telp, status) VALUES (NULL, '$nama', '$notelepon', 'ready')";
}

//cek duplikat
$querycek = mysqli_query($db, "SELECT no_telp from driver WHERE no_telp = '$notelepon'");
$cek = mysqli_num_rows($querycek);
if ($cek !== 0) {
    echo "
        <script>
            alert('Nomor telepon yang dimasukkan telah terdaftar')
            document.location.href = 'form.php';
        </script>
    ";
    exit();
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
                alert('Data berhasil diubah')
                document.location.href = 'index.php';
            </script>
        ";
    	} else {
    		echo "
            <script>
                alert('Data berhasil ditambah')
                document.location.href = 'index.php';
            </script>
        ";
    	}
    }
?>