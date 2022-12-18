<?php  
    require "function.php";
    $kode = $_GET["id"];
    $hapus = mysqli_query($conn, "DELETE FROM barang where id = '$kode'");

    if($hapus){
        echo "
            <script>
                alert('data berhasil dihapus!');
                document.location.href = 'barang.php';
            </script>
        ";
    }else{
        echo "
            <script>
                alert('data gagal dihapus!');
                document.location.href = 'barang.php';
            </script>
        ";
    }

?>