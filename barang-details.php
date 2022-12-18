<?php  
	session_start();
	require "function.php";
	if (!isset($_SESSION['login'])) {
		header("location:login.php");
		exit;
	}
	$barang = mysqli_query($conn, "SELECT * FROM barang");
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="style.css">
	<link href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="font/css/all.css">
	<title> Detail Barang </title>
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
			<h3> Barang Details </h3>
			<div class="box">
				<?php
					$data_view= mysqli_query($conn, "SELECT a.*, b.nama_kategori FROM barang a, kategori b WHERE a.id_kategori = b.id_kategori and a.id = '".$_GET['id']."' ");
					$row = mysqli_fetch_assoc($data_view);
				?>	

				<p style="margin-bottom: 5px;">ID Barang</p>
				<input type="text" name="" class="input-control" value="<?php echo $row['id_barang']?>" readonly>

				<p style="margin-bottom: 5px;">Kategori</p>
				<input type="text" name="" class="input-control" value="<?php echo $row['nama_kategori']?>" readonly>
				
				<p style="margin-bottom: 5px;">Nama Barang</p>
				<input type="text" name="" class="input-control" value="<?php echo $row['nama_barang']?>" readonly>
				
				<p style="margin-bottom: 5px;">Merk</p>
				<input type="text" name="" class="input-control" value="<?php echo $row['merk']?>" readonly>	

				<p style="margin-bottom: 5px;">Harga Beli</p>
				<input type="text" name="" class="input-control" value="Rp. <?php echo number_format($row['harga_beli'])?>" readonly>

				<p style="margin-bottom: 5px;">Harga Jual</p>
				<input type="text" name="" class="input-control" value="RP. <?php echo number_format($row['harga_jual'])?>" readonly>	

				<p style="margin-bottom: 5px;">Satuan</p>
				<input type="text" name="" class="input-control" value="<?php echo $row['satuan_barang']?>" readonly>

				<p style="margin-bottom: 5px;">Stok</p>
				<input type="text" name="" class="input-control" value="<?php echo $row['stok']?>" readonly>	

				<p style="margin-bottom: 5px;">Tanggal Input</p>
				<input type="text" name="" class="input-control" value="<?php echo $row['tgl_input']?>" readonly>

				<p style="margin-bottom: 5px;">Tanggal Update</p>
				<input type="text" name="" class="input-control" value="<?php echo $row['tgl_update']?>" readonly>
			</div>
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