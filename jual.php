<?php  	
    error_reporting(0);
	session_start();
	require "function.php";
	if (!isset($_SESSION['login'])) {
		header("location:login.php");
		exit;
	}
	$kategori = mysqli_query($conn, "SELECT * FROM kategori");
	date_default_timezone_set('Asia/Jakarta');

	$userlogin= mysqli_query($conn, "SELECT a.*, b.* FROM login a, member b WHERE a.id_member = b.id_member AND user = '".$_SESSION['username']."' ");
	$usrlgn = mysqli_fetch_array($userlogin);
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="style.css">
	<link href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="font/css/all.css">
	<title> Kategori </title>
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
			<h3><a href="jual.php"> Data Barang</a> | <a href="data-penjualan.php"> Penjualan </a></h3><br>

			<h3> Data Barang </h3>
			<div class="box">	
				<form action="" method="post">
			        <input type="text" name="keyword" placeholder="cari berdasarkan nama barang" autofocus class="input-control-2">
			        <button type="submit" name="cari" class="tambah"> Search </button>
			    </form><br>

			    <table border="1" cellspacing="0" class="table">
			        <thead>
			            <tr>
				            <th>ID Barang</th>
				            <th>Nama Barang</th>
				            <th>Merk</th>
				            <th>Stok</th>
				            <th>Harga Jual</th>
				            <th>Aksi</th>
			            </tr>
			        </thead>
			        <?php
			        $keyword = $_POST['keyword'];
			        if($keyword != ''){
			            $select = mysqli_query($conn, "SELECT * FROM barang
			                WHERE stok > 0 and nama_barang LIKE '%".$keyword."%' ");

			            if(mysqli_num_rows($select)){
				        while($baris = mysqli_fetch_array($select)){
				        ?>
				        <tbody>
				            <tr>
				            	<td><?php echo $baris['id_barang']; ?></td>
				            	<td><?php echo $baris['nama_barang']; ?></td>
				            	<td><?php echo $baris['merk']; ?></td>
				            	<td><?php echo $baris['stok']; ?></td>
				            	<td>Rp. <?php echo number_format($baris['harga_jual']); ?></td>
				            	<td><a href="jual.php?jual=jual&id_barang=<?= $baris["id_barang"];?>&id_member=<?= $usrlgn["id_member"];?>"> <i class="fa-solid fa-cart-plus"></i> </a></td>
				            </tr>
				            <?php }}else{
				            echo "<tr> <td colspan=5'> Data tidak ditemukan </td></tr>";
				        } ?>
				        </tbody>
				        <?php
			        }else{
			            echo "<tr> <td colspan=5'> Pilih barang terlebih dahulu </td></tr>";
			        }
			        	?>
			    </table>
			</div>

			<?php  
				if (isset($_GET['jual'])) {
				
				$idbarang = $_GET["id_barang"];
			    $idmember = $_GET["id_member"];
			    
			    $query1 = mysqli_query($conn, "SELECT * FROM barang where id_barang = '$idbarang' ");
			    $hsl1 = mysqli_fetch_assoc($query1);

			?>

			<h3> Kasir </h3>
			<div class="box">	
				<form action="" method="post">
					<p style="margin-bottom: 5px;">Tanggal</p>
					<input type="text" name="tgl" class="input-control" value="<?php echo date("j F Y, G:i");?>" readonly>

					<p style="margin-bottom: 5px;">Nama Barang</p>
					<input type="text" name="nama" class="input-control" value="<?php echo $hsl1['nama_barang']?>" readonly requaired>

					<input type="hidden" name="idbar" class="input-control" value="<?php echo $hsl1['id_barang']?>" requaired>
					<input type="hidden" name="hrgjual" class="input-control" value="<?php echo $hsl1['harga_jual']?>" requaired>
					<input type="hidden" name="idmem" class="input-control" value="<?php echo $_GET["id_member"];?>" requaired>

					<p style="margin-bottom: 5px;">Jumlah</p>
					<input type="number" name="jumlah" class="input-control" value="<?php echo 1?>" requaired>

					<button type="submit" name="kasir" class="tambah"> <i class="fa-solid fa-cart-plus"></i> Masukkan Keranjang </button>
				</form>
			</div>
			<?php } ?>
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

if (isset($_POST['kasir'])) {
	$idbar = $_POST['idbar'];
	$idmem = $_POST['idmem'];
	$jumlah = $_POST['jumlah'];
	$hrgjual = $_POST['hrgjual'];
	$total = $jumlah*$hrgjual;
	$tgl = $_POST['tgl'];

	$jual = mysqli_query($conn, "INSERT INTO penjualan VALUES (
							'',
							'$idbar',
							'$idmem',
							'$jumlah',
							'$total',
							'$tgl')");

	if($jual){
		echo "
			<script>
				alert('data berhasil ditambahkan!');
		        document.location.href = 'data-penjualan.php';
		    </script>
		";

	}else{
		echo "
		    <script>
		        alert('data gagal ditambahkan!');
		        document.location.href = 'data-penjualan.php';
		    </script>
		";
	}
}

?>