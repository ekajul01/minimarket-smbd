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

	$qjual = mysqli_query($conn, "SELECT * FROM penjualan");
	$jmljual = mysqli_num_rows($qjual);
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

			<h3> Penjualan </h3>
			<div class="box">	
				Tanggal <input type="text" name="tgl" class="input-control-2" value="<?php echo date("j F Y, G:i");?>" readonly>

				<?php $penjualan = mysqli_query($conn, "SELECT penjualan.*,
											barang.id_barang,
											barang.nama_barang,
											member.id_member, 
											member.nm_member 
						from penjualan 
					    left join barang on barang.id_barang=penjualan.id_barang 
					    left join member on member.id_member=penjualan.id_member
					    ORDER BY id_penjualan");?>

				<table border="1" cellspacing="0" class="table">
					<thead>
						<tr>
							<th> No </th>
							<th> Nama Barang </th>
							<th> Jumlah </th>
							<th> Total </th>
							<th> Kasir </th>
							<th> Aksi </th>
						</tr>
					</thead>
					
					<tbody>
						<?php $i=1; ?>
				        <?php while ($r = mysqli_fetch_assoc($penjualan)) : ?>
						<tr>
							<td> <?php echo $i;?> </td>
							<td> <?php echo $r['nama_barang'];?> </td>
					<form action="penjualan-update.php" method="post">
							<td>
								<input type="number" name="jumlah" value="<?php echo $r['jumlah'];?>" class="input-control-3">
								<input type="hidden" name="id" value="<?php echo $r['id_penjualan'];?>" >
								<input type="hidden" name="id_brg" value="<?php echo $r['id_barang'];?>">
							</td>
							<td> Rp. <?php echo number_format($r['total']);?> </td>
							<td> <?php echo $r['nm_member'];?> </td>
							<td width="200px"> 
								<button type="submit" name="update" class="update"><i class="fa-solid fa-pen-to-square"></i> Update</button>
					</form>
								<a href="penjualan-hapus.php?id_penjualan=<?= $r["id_penjualan"];?>"><span id="hapus"><i class="fa-solid fa-trash"></i> Hapus </span></a>
							</td>
						</tr>
				        <?php $i++; ?>
				        <?php endwhile; ?>				        
					</tbody>
				</table>

				<?php  
					$q2 = mysqli_query($conn, "SELECT sum(total) as total_beli FROM penjualan");
					$r2 = mysqli_fetch_assoc($q2);
					$qpenjualan = mysqli_query($conn, "SELECT * FROM penjualan");
				?>
				<form action="" method="post">
				<?php  
					if (isset($_POST['reset'])) {
						$reset = mysqli_query($conn, "DELETE FROM penjualan");
						if($hapus){
					        echo "
					            <script>
					                document.location.href = 'kategori.php';
					            </script>
					        ";
					    }
					}
				?>
				<?php foreach($qpenjualan as $isi){;?>
					<input type="hidden" name="id_barang[]" value="<?php echo $isi['id_barang'];?>">
					<input type="hidden" name="id_member[]" value="<?php echo $isi['id_member'];?>">
					<input type="hidden" name="jumlah[]" value="<?php echo $isi['jumlah'];?>">
					<input type="hidden" name="total1[]" value="<?php echo $isi['total'];?>">
					<input type="hidden" name="tgl_input[]" value="<?php echo $isi['tanggal_input'];?>">
					<input type="hidden" name="periode[]" value="<?php echo date('m-Y');?>">
				<?php }?>

				<?php 

					if (isset($_POST['bayar'])) {
						$bayar = $_POST['pembayaran'];
						$totbel = $_POST['totbel'];						
						if(!empty($bayar)){
							$kembali = $bayar - $totbel;
							if($bayar >= $totbel){
								$id_barang = $_POST['id_barang'];
								$id_member = $_POST['id_member'];
								$jumlah = $_POST['jumlah'];
								$total = $_POST['total1'];
								$tgl_input = $_POST['tgl_input'];
								$periode = $_POST['periode'];

								for ($i = 0; $i < $jmljual; $i++) {
									$dataa = mysqli_query($conn, "INSERT INTO nota
											VALUES ('',
													'$id_barang[$i]',
													'$id_member[$i]',
													'$jumlah[$i]',
													'$total[$i]',
													'$tgl_input[$i]',
													'$periode[$i]')");
								}
								echo '<script>alert("Belanjaan Berhasil Di Bayar !");</script>';
							}else{
								echo '<script>alert("Uang Kurang ! Rp.'.$kembali.'");</script>';
							}
						}
						
					}

				?>

				
				Total semua <input type="text" name="totbel" class="input-control-2" value="<?php echo $r2['total_beli'];?>" readonly>
				Bayar <input type="text" name="pembayaran" class="input-control-2" value="<?php echo $bayar ?>"> 
				<button type="submit" name="bayar" class="bayar"> <i class="fa-solid fa-cart-plus"></i> Bayar</button>
				<button type="submit" name="reset" class="reset"> Reset</button>
				<br>
				
				Kembali <input type="text" name="kembali" class="input-control-2" value="<?php echo $kembali ?>">
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

