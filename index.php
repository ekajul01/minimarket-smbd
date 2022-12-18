<?php  
	session_start();
	require "function.php";
	if (!isset($_SESSION['login'])) {
		header("location:login.php");
		exit;
	}

	$query1 = mysqli_query($conn, "SELECT * FROM barang");
	$jml1 = mysqli_num_rows($query1);
	$query2 = mysqli_query($conn, "SELECT sum(stok) as stok FROM barang");
	$jml2 = mysqli_fetch_assoc($query2);
	$query3 = mysqli_query($conn, "SELECT sum(jumlah) as jumlah FROM nota");
	$jml3 = mysqli_fetch_assoc($query3);
	$query4 = mysqli_query($conn, "SELECT * FROM kategori");
	$jml4 = mysqli_num_rows($query4);
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="style.css">
	<link href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="font/css/all.css">
	<title> Dashboard </title>
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
			<h3>Dashboard</h3>
			<div class="box">
				<div class="col-3">
					<div class="panel-header">						
						<h3><i class="fa-solid fa-file-pen"></i> Nama Barang </h3>
						<hr>
					</div>
					<div class="panel-body">
						<?php $a1 = "CALL sp_countIDBarang(@jumlahbrg)";
							$a2 = mysqli_query($conn, $a1);
							$a3 = mysqli_query($conn, "SELECT @jumlahbrg");
							$a4 = mysqli_fetch_assoc($a3);							
						?>
						<p><?php echo $a4['@jumlahbrg'];?></p>
						<hr>
					</div>
					<div class="panel-footer">
						<a href="barang.php"> Tabel Barang >> </a>
					</div>
				</div>
				<div class="col-3">
					<div class="panel-header">
						<h3><i class="fa-solid fa-file-contract"></i> Stok Barang</h3>
						<hr>
					</div>
					<div class="panel-body">
						<?php $c1 = "CALL sp_countStok(@stok1)";
							$c2 = mysqli_query($conn, $c1);
							$c3 = mysqli_query($conn, "SELECT @stok1");
							$c4 = mysqli_fetch_assoc($c3);							
						?>
						<p><?php echo $c4['@stok1'];?></p>
						<hr>
					</div>
					<div class="panel-footer">
						<a href="barang.php"> Tabel Barang >> </a>
					</div>
				</div>
				<div class="col-3">
					<div class="panel-header">
						<h3><i class="fa-solid fa-users"></i> Telah Terjual </h3>
						<hr>
					</div>
					<div class="panel-body">
						<?php $d1 = "CALL sp_countTerjual(@jmljual)";
							$d2 = mysqli_query($conn, $d1);
							$d3 = mysqli_query($conn, "SELECT @jmljual");
							$d4 = mysqli_fetch_assoc($d3);							
						?>
						<p><?php echo $d4['@jmljual'];?></p>
						<hr>
					</div>
					<div class="panel-footer">	
						<a href=""> Tabel Laporan >> </a>
					</div>
				</div>
				<div class="col-3">
					<div class="panel-header">
						<h3><i class="fa-solid fa-file-pen"></i> Kategori Barang </h3>
						<hr>
					</div>
					<div class="panel-body">
						<?php 
							$b1 = "CALL jumlahKtgr(@ktgrList)";
							$b2 = mysqli_query($conn, $b1);
							$b3 = mysqli_query($conn, "SELECT @ktgrList");
							$b4 = mysqli_fetch_assoc($b3);						
						?>
						<p><?php echo $b4['@ktgrList'];?></p>
						<hr>
					</div>
					<div class="panel-footer">	
						<a href="kategori.php"> Tabel Kategori >> </a>
					</div>
				</div>
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