<?php  
	session_start();
	require "function.php";
	if (!isset($_SESSION['login'])) {
		header("location:login.php");
		exit;
	}
	$v_brg = mysqli_query($conn, "SELECT * FROM v_barang");
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="style.css">
	<link href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="font/css/all.css">
	<title> Barang </title>
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
			<h3> Data Barang</h3>
			<div class="box">
				<table border="1" cellspacing="0" class="table">
					<thead>
						<tr>
							<th> No </th>
							<th> ID Barang </th>
							<th> Kategori </th>
							<th> Nama Barang </th>
							<th> Merk </th>
							<th> Stok </th>
							<th> Harga Beli </th>
							<th> Harga Jual </th>
							<th> Satuan </th>
							<th> Aksi </th>
						</tr>
					</thead>
					<tbody>
						<?php $i=1; ?>
				        <?php while ($row = mysqli_fetch_assoc($v_brg)) : ?>
						<tr>
							<td> <?php echo $i;?> </td>
							<td> <?php echo $row['id_barang'];?> </td>
							<td> <?php echo $row['nama_kategori'];?> </td>
							<td> <?php echo $row['nama_barang'];?> </td>
							<td> <?php echo $row['merk'];?> </td>
							<td> <?php echo $row['stok'];?> </td>
							<td> Rp. <?php echo number_format($row['harga_beli']);?> </td>
							<td> Rp. <?php echo number_format($row['harga_jual']);?> </td>
							<td> <?php echo $row['satuan_barang'];?> </td>
							<td> 
								<a href="barang-details.php?id=<?= $row["id"];?>"><span id="details"><i class="fa-solid fa-pen-to-square"></i> Details </span></a>
								<a href="barang-edit.php?id=<?= $row["id"];?>"><span id="edit"><i class="fa-solid fa-pen-to-square"></i> Edit  </span></a>
								<a href="barang-hapus.php?id=<?= $row["id"];?>"><span id="hapus"><i class="fa-solid fa-trash"></i> Hapus </span></a>
							</td>
						</tr>
				        <?php $i++; ?>
				        <?php endwhile; ?>				        
					</tbody>
					<p><a href="barang-tambah.php"><span id="tambah"> <i class="fa-solid fa-plus"></i>  Tambah Data </span></a></p><br>
				</table>				
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