<?php
	include '../db.php';
	$notelepon = $_GET['notelepon'];
	$email = $_GET['email'];
	$pengguna = $_GET['pengguna'];

	$sql = mysqli_query($db,"UPDATE profil SET no_telepon = '$notelepon', email='$email', pengguna = '$pengguna' WHERE id = '1'");
	if (!$sql) {
		echo "fail";
		exit();
	}else{
		header("location:index.php?upddone");
	}
?>