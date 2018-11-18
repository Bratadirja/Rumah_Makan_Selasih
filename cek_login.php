<?php
	
	include "config/koneksi.php";

	$pass = $_POST['password'];
	$login = mysqli_query($conn, "SELECT * FROM user WHERE user_id='$_POST[username]' AND password='$pass'");
	
	$ketemu = mysqli_num_rows($login);
	$r = mysqli_fetch_array($login);

	if($ketemu > 0){
		session_start();
		$_SESSION['namauser'] = $r['user_id'];
		$_SESSION['passuser'] = $r['password'];
		$_SESSION['namalengkap'] = $r['nama'];
		$_SESSION['alamatuser'] = $r['alamat'];
		$_SESSION['jeniskelamin_user'] = $row['jenis_kelamin'];
		$_SESSION['leveluser'] = $r['level'];

		if($_SESSION['leveluser']=='kasir'){

			header('location:media.php?module=home');

		}else{

		header('location:media.php?module=home');

		}

	}else{

		include "error_login.php";
		
	}

	
?>