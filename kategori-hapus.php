<?php  
    require "function.php";
    $kode = $_GET["id_kategori"];
    $hapus = mysqli_query($conn, "DELETE FROM kategori where id_kategori = '$kode'");

    if($hapus){
        echo "
            <script>
                alert('kategori berhasil dihapus!');
                document.location.href = 'kategori.php';
            </script>
        ";
    }else{
        echo "
            <script>
                alert('kategori gagal dihapus!');
                document.location.href = 'kategori.php';
            </script>
        ";
    }

?>