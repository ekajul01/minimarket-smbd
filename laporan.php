<?php  
	error_reporting(0);
	session_start();
	require "function.php";
	if (!isset($_SESSION['login'])) {
		header("location:login.php");
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
			<h3>Laporan</h3>
			<div class="box">
				<form method="post" action="">
					<select name="keyword1" class="input-control-2" required autofocus>					
						<option value=""> -- Pilih Bulan Laporan --</option>
						<option value="01"> Januari </option>
						<option value="02"> Februai </option>
						<option value="03"> Maret </option>
						<option value="04"> April </option>
						<option value="05"> Mei </option>
						<option value="06"> Juni </option>
						<option value="07"> Juli </option>
						<option value="08"> Agustus </option>
						<option value="09"> September </option>
						<option value="10"> Oktober </option>
						<option value="11"> November </option>
						<option value="12"> Desember </option>
					</select>
					<select name="keyword2" class="input-control-2" required autofocus>					
						<option value=""> -- Pilih Tahun Laporan --</option>
						<option value="2020"> 2020 </option>
						<option value="2021"> 2021 </option>
						<option value="2022"> 2022 </option>
						<option value="2023"> 2023 </option>
						<option value="2024"> 2024 </option>
					</select>
					<button type="submit" name="cari" class="tambah"> Search </button>
			    </form><br>

			    <table border="1" cellspacing="0" class="table">
			        <thead>
			            <tr style="background-color : lightgrey;">
				            <th>ID Barang</th>
				            <th>Nama Barang</th>
				            <th>Jumlah</th>
				            <th>Modal</th>
				            <th>Total</th>
				            <th>Nama Kasir</th>
				            <th>Tanggal Input</th>
			            </tr>
			        </thead>
			        <?php
			        $keyword1 = $_POST['keyword1'];
			        $keyword2 = $_POST['keyword2'];
			        
			        if($keyword1 != '' and $keyword2 != ''){
			        	$keyword = "$keyword1-$keyword2";
			            $select = mysqli_query($conn, "SELECT * FROM v_laporan2
					                WHERE periode LIKE '%".$keyword."%' 
	                                ORDER BY Tanggal_Input ASC");

			            if(mysqli_num_rows($select)){
				            $laporan = mysqli_query($conn, "SELECT sum(Jumlah) as tJumlah,
	                                        sum(Modal) as tModal,
	                                        sum(Total) as tTotal
	                                    FROM v_laporan2 
	                                    WHERE periode LIKE '%".$keyword."%' ");
	    					$vlaporan = mysqli_fetch_assoc($laporan);
				        while($baris = mysqli_fetch_array($select)){
				        ?>
				        <tbody>
				            <tr>
				            	<td><?php echo $baris['ID_Barang']; ?></td>
				            	<td><?php echo $baris['Nama_Barang']; ?></td>
				            	<td><?php echo $baris['Jumlah']; ?></td>
				            	<td>Rp. <?php echo number_format($baris['Modal']); ?></td>
				            	<td>Rp. <?php echo number_format($baris['Total']); ?></td>
				            	<td><?php echo $baris['Nama_Kasir']; ?></td>
				            	<td><?php echo $baris['Tanggal_Input']; ?></td>
				            </tr>		            
				            <?php }?>
				            <tr style="background-color : lightgrey;">
                                <td colspan="2"> Total Terjual </td>
                                <td><?php echo $vlaporan['tJumlah']; ?></td>
                                <td>Rp. <?php echo number_format($vlaporan['tModal']); ?></td>
                                <td>Rp. <?php echo number_format($vlaporan['tTotal']); ?></td>
                                <td> Keuntungan </td>
                                <?php $untung = $vlaporan['tTotal']-$vlaporan['tModal'] ; ?>
                                <td>Rp. <?php echo number_format($untung); ?></td>
                            </tr>
                            <?php
				        }else{
				            echo "<tr> <td colspan=7'> Data tidak ditemukan </td></tr>";
				        } ?>
				        </tbody>
				       	<?php
			        }else{
			            echo "<tr> <td colspan=7'> Pilih Periode Laporan </td></tr>";
			        }
			        ?>
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