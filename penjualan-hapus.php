<?php  
    require "function.php";
    $kode = $_GET["id_penjualan"];
    $hapus = mysqli_query($conn, "DELETE FROM penjualan where id_penjualan = '$kode'");

    if($hapus){
        echo "
            <script>
                alert('data berhasil dihapus!');
                document.location.href = 'data-penjualan.php';
            </script>
        ";
    }else{
        echo "
            <script>
                alert('kategori gagal dihapus!');
                document.location.href = 'data-penjualan.php';
            </script>
        ";
    }

?>