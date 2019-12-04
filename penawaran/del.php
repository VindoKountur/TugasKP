<?php include '../db.php';
	
	$idsp = $_GET['idsp'];
	$del = mysqli_query($db, "DELETE FROM penawaran WHERE id_sp = '$idsp'");
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