<?php 
session_start();

include 'function.php';

$username = $_POST['user'];
$password = $_POST['pass'];

$login = mysqli_query($conn,"SELECT member.*, login.user, login.pass
						FROM MEMBER INNER JOIN login ON member.id_member = login.id_member
						WHERE USER = '$username' AND PASS = '$password'");


$cek = mysqli_num_rows($login);

if($cek > 0){
 
	$data = mysqli_fetch_assoc($login);
	$_SESSION['login'] = true;
	$_SESSION['username'] = $data['user'];
	header("location:index.php");

}else{
	header("location:login.php?pesan=gagal");
}

?>