<?php  

	session_start();
	require "function.php";
	if (!isset($_SESSION['login'])) {
		header("location:login.php");
		exit;
	}

	if(isset($_POST['update'])){
		$id = $_POST['id'];
		$id_barang = $_POST['id_brg'];
		$jml = $_POST['jumlah'];
		
		$barang = mysqli_query($conn, "SELECT * FROM barang WHERE id_barang = '$id_barang'");
		$vbarang = mysqli_fetch_assoc($barang);

		if($vbarang['stok'] > $jml){
			$jual = $vbarang['harga_jual'];
			$ttl = $jual * $jml;
			$sql1 = mysqli_query($conn, "UPDATE penjualan SET 
									jumlah = '".$_POST['jumlah']."',
									total = '$ttl'
									WHERE id_penjualan = '".$_POST['id']."';
								");
				

			if($sql1){
				echo "
                    <script>
                        alert('data berhasil diupdate!');
                        document.location.href = 'data-penjualan.php';
                    </script>
                ";
			}else{
				echo " 
                    <script>
                        alert('data gagal diupdate!');
                        document.location.href = 'data-penjualan.php';
                    </script>
                ";
			}
			
		}else{
			echo "
                    <script>
                        alert('Keranjang melebihi stok barang anda !!');
                        document.location.href = 'data-penjualan.php';
                    </script>
                ";
        }
	}
?>