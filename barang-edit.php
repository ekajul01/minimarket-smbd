<?php  
	session_start();
	require "function.php";
	if (!isset($_SESSION['login'])) {
		header("location:login.php");
		exit;
	}
	$barang = mysqli_query($conn, "SELECT * FROM barang");
	date_default_timezone_set('Asia/Jakarta');
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="style.css">
	<link href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="font/css/all.css">
	<title> Edit Barang </title>
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
			<h3> Barang Edit </h3>
			<div class="box">
				<?php
					$data_view= mysqli_query($conn, "SELECT a.*, b.nama_kategori FROM barang a, kategori b WHERE a.id_kategori = b.id_kategori and a.id = '".$_GET['id']."' ");
					$row = mysqli_fetch_assoc($data_view);
				?>	
				<form method="post" action="">
				<p style="margin-bottom: 5px;">ID Barang</p>
				<input type="text" name="idbrg" class="input-control" value="<?php echo $row['id_barang']?>" readonly>

				<p style="margin-bottom: 5px;">Kategori</p>
				<?php $query2 = mysqli_query($conn, "SELECT * FROM kategori"); ?>
				<select name="ktgr" class="input-control" required>
					<option value=""> -- Pilih -- </option>
						<?php
				            foreach ($query2 as $r) {
				        ?>
				  	<option value="<?= $r["id_kategori"];?>" <?php echo ($r['nama_kategori'] == $row['nama_kategori'])? 'selected':''?>> <?= $r["nama_kategori"];?></option>
							  	<?php } ?>
				</select>
				
				<p style="margin-bottom: 5px;">Nama Barang</p>
				<input type="text" name="brg" class="input-control" value="<?php echo $row['nama_barang']?>" requaired>
				
				<p style="margin-bottom: 5px;">Merk</p>
				<input type="text" name="merk" class="input-control" value="<?php echo $row['merk']?>" requaired>	

				<p style="margin-bottom: 5px;">Harga Beli</p>
				<input type="text" name="beli" class="input-control" value="<?php echo $row['harga_beli']?>" requaired>

				<p style="margin-bottom: 5px;">Harga Jual</p>
				<input type="text" name="jual" class="input-control" value="<?php echo $row['harga_jual']?>" requaired>	

				<p style="margin-bottom: 5px;">Satuan</p>
				<input type="text" name="satuan" class="input-control" value="<?php echo $row['satuan_barang']?>" requaired>

				<p style="margin-bottom: 5px;">Stok</p>
				<input type="text" name="stok" class="input-control" value="<?php echo $row['stok']?>" requaired>	

				<p style="margin-bottom: 5px;">Tanggal Update</p>
				<input type="text" name="tglup" class="input-control" value="<?php echo date("j F Y, G:i");?>" readonly><br>
				<button type="submit" name="edit" class="edit">Ubah Data</button>
				</form>
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

		<?php 
			if(isset($_POST['edit'])){
				$update = mysqli_query($conn, "UPDATE barang SET
						   	id_barang = '".$_POST['idbrg']."', 
						   	id_kategori = '".$_POST['ktgr']."', 
						   	nama_barang = '".$_POST['brg']."',
						   	merk = '".$_POST['merk']."',
						   	harga_beli = '".$_POST['beli']."',
						   	harga_jual = '".$_POST['jual']."',
						   	satuan_barang = '".$_POST['satuan']."',
						   	stok = '".$_POST['stok']."',
						   	tgl_update = '".$_POST['tglup']."'
					    WHERE id = '".$_GET['id']."' ");
				if($update){
					echo "
					    <script>
					        alert('data berhasil diubah!');
					        document.location.href = 'barang.php';
					    </script>
					";

				}else{
					echo "
					    <script>
					        alert('data gagal diubah!');
					        document.location.href = 'barang.php';
					    </script>
					";
				}
			}
		?>