<?php 
include '../../db.php';
$nomorplat = strtoupper($_GET['nomorplat']);
if (isset($_GET['update'])) {
	$id = $_GET['id'];
	$sql = "UPDATE truk SET nomor_plat = '$nomorplat' WHERE id_truk = $id";
}else{
	$sql = "INSERT INTO truk (id_truk, nomor_plat, status) VALUES (NULL, '$nomorplat', 'ready')";
}
//cek duplikat
$querycek = mysqli_query($db, "SELECT nomor_plat from truk WHERE nomor_plat = '$nomorplat'");
$cek = mysqli_num_rows($querycek);
if ($cek !== 0) {
    echo "
        <script>
            alert('Truk telah terdaftar')
            document.location.href = 'form.php';
        </script>
    ";
    exit();
}
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