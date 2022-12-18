<?php 
	require "function.php";
	if (isset($_SESSION['login'])) {
		header("location:index.php");
		exit;
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="style.css">
	<link href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap" rel="stylesheet">
	<title> Login </title>
</head>
<body>

	<!-- content -->
	<?php 
	if(isset($_GET['pesan'])){
		if($_GET['pesan'] == "gagal"){
			echo "<script>
                    alert('Login gagal! username dan password salah!');
            </script>";
		}else if($_GET['pesan'] == "logout"){
			echo "<script>
                    alert('Anda telah berhasil logout!');
            </script>";
		}else if($_GET['pesan'] == "belum_login"){
			echo "<script>
                    alert('Anda harus login untuk mengakses halaman user!');
            </script>";
		}
	}
	?>

	<span id="bg-login">
		<div class="box-login">
			<h2> Login </h2>
			<form method="post" action="cek-login.php">

				<p style="margin-bottom: 5px;">Username</p>
				<input type="text" name="user" placeholder="masukkan username" class="input-control">

				<p style="margin-bottom: 5px;">Password</p>
				<input type="password" name="pass" placeholder="masukkan password" class="input-control">

				<button type="submit" name="submit" class="btn"> Login </button>
			</form>
		</div>		
	</span>

	<!-- footer -->
	<footer>
		<div class="container">
			<?php 
				$toko = mysqli_query($conn, "SELECT * FROM toko WHERE id_toko = 1");
				$viewtoko = mysqli_fetch_assoc($toko);
			?>
			<small> Copyright &copy; <?php echo $viewtoko['nama_toko']; ?></small>
		</div>
	</footer>
</body>
</html>