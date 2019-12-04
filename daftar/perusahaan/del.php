<?php include '../../db.php';
	
	$id = $_GET['id'];
	$query = mysqli_query($db, "SELECT * FROM transaksi WHERE nama_p = '$id'");
	$cek = mysqli_num_rows($query);
	if ($cek != 0) {
		echo "Perusahaan ini masih berkaitan dengan transaksi yang ada";
		exit();
	}
	$del = mysqli_query($db, "DELETE FROM perusahaan WHERE id_perusahaan = '$id'");
	if (!$del) {
		echo "
			<script>
			alert('Gagal dihapus')
			document.location.href= 'index.php'
			</script>
		";
	}else{
		echo "
			<script>
			alert('Data telah dihapus')
			document.location.href = 'index.php'
			</script>
		";
	}


?>