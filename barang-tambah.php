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
	<title> Tambah Barang </title>
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
				<form method="post" action="">
					<p style="margin-bottom: 5px;">ID Barang</p>
					<input type="text" name="idbrg" class="input-control" required>

					<p style="margin-bottom: 5px;">Kategori</p>
					<?php $query2 = mysqli_query($conn, "SELECT * FROM kategori"); ?>
					<select name="ktgr" class="input-control" required>
						<option value="">-- Pilih --</option>
							<?php
				               	foreach ($query2 as $row) {
			                ?>
					  	<option value="<?= $row["id_kategori"];?>"> <?= $row["nama_kategori"];?></option>
						  	<?php } ?>
					</select>
					
					<p style="margin-bottom: 5px;">Nama Barang</p>
					<input type="text" name="brg" class="input-control" requaired>
					
					<p style="margin-bottom: 5px;">Merk</p>
					<input type="text" name="merk" class="input-control" requaired>	

					<p style="margin-bottom: 5px;">Harga Beli</p>
					<input type="text" name="beli" class="input-control" requaired>

					<p style="margin-bottom: 5px;">Harga Jual</p>
					<input type="text" name="jual" class="input-control" requaired>	

					<p style="margin-bottom: 5px;">Satuan</p>
					<select name="satuan" class="input-control" required>
						<option value="">-- Pilih --</option>
					  	<option value="PCS"> PCS </option>
					</select>

					<p style="margin-bottom: 5px;">Stok</p>
					<input type="text" name="stok" class="input-control" requaired>	

					<p style="margin-bottom: 5px;">Tanggal Input</p>
					<input type="text" name="tglin" class="input-control" value="<?php echo date("j F Y, G:i");?>" readonly><br>
					<button type="submit" name="tambah" class="tambah">Tambah Data</button>
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
			if(isset($_POST['tambah'])){
				$idbarang = $_POST['idbrg'];
				$kategori = $_POST['ktgr'];
				$nama = $_POST['brg'];
				$merk = $_POST['merk'];
				$beli = $_POST['beli'];
				$jual = $_POST['jual'];
				$satuan = $_POST['satuan'];
				$stok = $_POST['stok'];
				$tglin = $_POST['tglin'];

				$tambah = mysqli_query($conn, "INSERT INTO barang(id_barang,
                                id_kategori,
                                nama_barang,
                                merk,
                                harga_beli,
                                harga_jual,
                                satuan_barang,
                                stok,
                                tgl_input)
                            VALUES('$idbarang', '$kategori', '$nama', '$merk',
                                '$beli', '$jual', '$satuan', '$stok', '$tglin')");

                if($tambah){
                    echo "
                        <script>
                            alert('data berhasil ditambahkan!');
                            document.location.href = 'barang.php';
                        </script>
                    ";

                }else{
                    echo "
                        <script>
                            alert('data gagal ditambahkan!');
                            document.location.href = 'barang.php';
                        </script>
                    ";
                }



				
			}
		?>