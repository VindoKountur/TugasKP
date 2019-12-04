<?php  
	session_start();
	include 'db.php';
	if (isset($_SESSION['login'])) {
		header("location:home.php");
	}
	if (isset($_POST['submit'])) {
		$uname = $_POST['uname'];
		$upass = $_POST['upass'];
		$query = mysqli_query($db, "SELECT * FROM user WHERE uname = '$uname' AND upass ='$upass' ");
		$data = mysqli_fetch_assoc($query);
		if (!$data) {
			header("location:index.php?salah");
		}else {
			$_SESSION['login'] = "Loged in";
			header("location:home.php");
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>LOGIN</title>
	<style type="text/css">
		body {
			
		}
		.contain {
			text-align: center;
			margin: 160px auto;
			width: 350px;
			height: 400px;
			border: 1px solid black;
			background-color: lightskyblue;
			position: relative;
			border-radius: 15px;
		}
		.logo {
			width: 150px;
			height: 150px;
			margin: -60px auto;
			border: 2px solid black;
			border-radius: 50%;
			background-color: white;
		}
		.logo img{
			margin: 20px auto;
			border-radius: 40px;
		}
		.form {
			margin-top: 70px;
		}
		.form input {
			margin-top: 30px;
		}
		.form input[type=text], input[type=password] {
			width: 200px;
			height: 20px;
			text-align: center;
			border: none;
			border-radius: 5px;
			padding: 5px;
		}
		.form input[type=submit] {
			width: 100px;
			height: 30px;
			border: none;
			background-color: blue;
			color: white;
		}
		.form input[type=submit]:hover {
			box-shadow: 2px 2px 5px rgba(0, 0, 0, .6);
		}
	</style>
</head>
<body>
	<?php 
		$url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
      	if(strpos($url,'salah') !== false){
      		echo "<script>alert('Nama atau password salah');</script>";
    	}
	?>
	<div class="contain">
		<div class="logo">
			<img src="img/logo.jpg"><br>
		</div>
		<div class="form">
			<form action="?" method="POST">
				<input type="text" name="uname" placeholder="USERNAME" required><br>
				<input type="password" name="upass" placeholder="PASSWORD" required><br>
				<input type="submit" name="submit" value="LOGIN">
			</form>
		</div>
	</div>
</body>
</html>