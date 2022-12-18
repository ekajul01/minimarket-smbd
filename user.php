<?php  
	session_start();
	require "function.php";
	if (!isset($_SESSION['login'])) {
		header("location:login.php");
		exit;
	}?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="style.css">
	<link href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="font/css/all.css">
	<title> User </title>
</head>
<body>
	<!-- header -->
	<header>
		<div class="container">
			<h1><a href=""> Minimarket </h1>
			<ul>
				<li><a href="index.php"> Dashboard </a></li>
				<li><a href="barang.php"> Barang </a></li>
				<li><a href="kategori.php"> Kategori </a></li>
				<li><a href="user.php"> User </a></li>
				<li><a href="jual.php"> Transaksi Jual </a></li>
				<li><a href="laporan.php"> Laporan Penjualan </a></li>
				<li><a href="logout.php"> Logout </a></li>
			</ul>
		</div>
	</header>

	<!-- content -->
	<div class="section">
		<div class="container">
			<h3>Kelola Pengguna</h3>
			<div class="box">	
				<?php
				    $data_edit= mysqli_query($conn, "SELECT a.*, b.* FROM login a, member b WHERE a.id_member = b.id_member AND user = '".$_SESSION['username']."' ");
				    $row = mysqli_fetch_array($data_edit);
			    ?>
			    <form action="" method="post">
			    	<input type="hidden" name="idmem" class="input-control" value="<?php echo $row['id_member']?>" required>

					<p style="margin-bottom: 5px;">Nama </p>
					<input type="text" name="nama" class="input-control" value="<?php echo $row['nm_member']?>" required>

					<p style="margin-bottom: 5px;">Email</p>
					<input type="text" name="email" class="input-control" value="<?php echo $row['email']?>" required>

					<p style="margin-bottom: 5px;">Telepon</p>
					<input type="text" name="telp" class="input-control" value="<?php echo $row['telepon']?>" required>

					<p style="margin-bottom: 5px;">NIK (KTP)</p>
					<input type="text" name="nik" class="input-control" value="<?php echo $row['NIK']?>" required>

					<p style="margin-bottom: 5px;">Alamat</p>
					<textarea type="text" name="alamat" class="input-control"> <?php echo $row['alamat_member']?> </textarea>
					
					<button type="submit" name="editprofil" class="edit"> Ubah Profil</button>
			    </form>		
			</div>

	<!-- php -->
	    <?php 
			if(isset($_POST['editprofil'])){
				$update = mysqli_query($conn, "UPDATE member SET
						   	nm_member = '".$_POST['nama']."', 
						   	email = '".$_POST['email']."',
						   	telepon = '".$_POST['telp']."', 
						   	NIK = '".$_POST['nik']."',
						   	alamat_member = '".$_POST['alamat']."'
					    WHERE id_member = '".$_POST['idmem']."' ");
				if($update){
					echo "
					    <script>
					        alert('profil berhasil diperbaharui!');
					        document.location.href = 'user.php';
					    </script>
					";

				}else{
					echo "
					    <script>
					        alert('profil gagal diperbaharui!');
					        document.location.href = 'user-profil.php';
					    </script>
					";
				}
			}
		?>

			<h3>Ganti Password</h3>
			<div class="box">	
				<form action="" method="post">
					<input type="hidden" name="idlogin" class="input-control" value="<?php echo $row['id_login']?>" required>

					<p style="margin-bottom: 5px;">Password Lama </p>
					<input type="password" name="passlama" class="input-control" placeholder="masukkan password lama" required>

					<p style="margin-bottom: 5px;">Password Baru </p>
					<input type="password" name="passbaru" class="input-control" placeholder="masukkan password baru" required>

					<button type="submit" name="ubahpassword" class="edit"> Ubah Password </button>
				</form>		
			</div>

			<?php
			    if(isset($_POST['ubahpassword'])){

			    	if(!empty($_POST['passbaru'])){

			    		if($_POST['passbaru'] != $_POST['passlama']){

				    		$update = mysqli_query($conn, "UPDATE login SET
					    	pass = '".$_POST['passbaru']."'
					    	WHERE id_login = '".$_POST['idlogin']."'");

						    if($update){
					            echo "
					                <script>
					                    alert('password berhasil diubah!');
					                    document.location.href = 'user.php';
					                </script>
					            ";

					        }else{
					            echo "
					                <script>
					                    alert('password gagal diubah!');
					                    document.location.href = 'user.php';
					                </script>
					            ";
					        }
			    		}else{
							echo "
						        <script>
					                alert('password baru tidak boleh sama dengan password lama!');
				                    document.location.href = 'user.php';
					            </script>
					        ";
						}

			    	}else{
					    echo "
				            <script>
			                    alert('password baru tidak boleh kosong!');
				                    document.location.href = 'user.php';
				            </script>
					        ";
					}
			    	
			    }
			?>
		</div>
	</div>

	<!-- footer -->
	<footer>
		<div class="container">
			<?php 
				$toko = mysqli_query($conn, "SELECT * FROM toko WHERE id_toko = 1");
				$viewtoko = mysqli_fetch_assoc($toko);
			?>
			<small> <?php echo $viewtoko['nama_pemilik']; ?> - 
					<?php echo $viewtoko['tlp']; ?></small><br>
			<small> <?php echo $viewtoko['alamat_toko']; ?></small><br>
			<small> Copyright &copy; <?php echo $viewtoko['nama_toko']; ?></small>
		</div>
	</footer>
</body>
</html>