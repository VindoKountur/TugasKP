<?php include '../db.php';
	
	$id = $_GET['id'];
	$del = mysqli_query($db, "DELETE FROM transaksi WHERE id_transaksi = '$id'");
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