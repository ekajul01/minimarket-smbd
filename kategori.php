<?php  
	session_start();
	require "function.php";
	if (!isset($_SESSION['login'])) {
		header("location:login.php");
		exit;
	}
	$kategori = mysqli_query($conn, "SELECT * FROM kategori");
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
			<h3>Data Kategori</h3>
			<div class="box">
				<form method="post" action="">
					<input type="text" name="kategori" class="input-control-2" placeholder="Masukkan kategori">
					<input type="hidden" name="tgl" value="<?php echo date("j F Y, G:i") ?>">

					<button type="submit" name="tambah" class="tambah"> Tambah Kategori</button>
				</form>
				<table border="1" cellspacing="0" class="table">
					<thead>
						<tr>
							<th> No </th>
							<th> Nama Kategori </th>
							<th> Tanggal Input </th>
							<th> Aksi </th>
						</tr>
					</thead>
					<tbody>
						<?php $i=1; ?>
				        <?php while ($row = mysqli_fetch_assoc($kategori)) : ?>
						<tr>
							<td width="50px"> <?php echo $i;?> </td>
							<td> <?php echo $row['nama_kategori'];?> </td>
							<td> <?php echo $row['tgl_input'];?> </td>
							<td width="150px"> 
								<a href="kategori-edit.php?id_kategori=<?= $row["id_kategori"];?>"><span id="edit"><i class="fa-solid fa-pen-to-square"></i> Edit  </span></a>
								<a href="kategori-hapus.php?id_kategori=<?= $row["id_kategori"];?>"><span id="hapus"><i class="fa-solid fa-trash"></i> Hapus </span></a>
							</td>
						</tr>
				        <?php $i++; ?>
				        <?php endwhile; ?>				        
					</tbody>
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

<?php 

if (isset($_POST['tambah'])) {
	$kategori = $_POST['kategori'];
	$tanggal = $_POST['tgl'];

	$query = mysqli_query($conn, "INSERT INTO kategori values (
							'',
							'$kategori',
							'$tanggal')");

	if($query){
		echo "
			<script>
				alert('data berhasil ditambahkan!');
		        document.location.href = 'kategori.php';
		    </script>
		";

	}else{
		echo "
		    <script>
		        alert('data gagal ditambahkan!');
		        document.location.href = 'kategori.php';
		    </script>
		";
	}
}

?>