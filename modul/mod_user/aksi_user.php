<?php
	session_start();
	if(empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
		echo "<link href='media.css' rel='stylesheet' type='type/css'>
		<center>Untuk Mengakses Modul, Anda Harus Login Terlebih dahulu<br>
		";

		echo "<a href=index.php><b>Login</b></a></center>";

	}else{
		include "../../config/koneksi.php";

		$module=$_GET[module];
		$act=$_GET[act];

		//Input User
		if($module=='user' AND $act=='input'){
		   $User_id = $_POST['user_id'];
		   $Password = $_POST['password'];
		   $Nama = $_POST['nama'];
		   $Alamat = $_POST['alamat'];
		   $Jenis_Kelamin = $_POST['jenis_kelamin'];
		   $Level = $_POST['level'];

		   mysqli_query($conn, "insert into user(user_id,password,nama,alamat,jenis_kelamin,level) values('$User_id','$Password','$Nama','$Alamat','$Jenis_Kelamin','$Level')");
		   header('location:../../media.php?module='.$module);

		   //Input Ke tabel Manager
		   if ($Level=='manager') {
		   		mysqli_query($conn, "insert into manager(nama,alamat,jenis_kelamin) values('$Nama','$Alamat','$Jenis_Kelamin')");
		   }

		   //Input ke tabel Kasir
		   if ($Level=='kasir') {
		   		mysqli_query($conn, "insert into kasir(nama,alamat,jenis_kelamin) values('$Nama','$Alamat','$Jenis_Kelamin')");
		   }

		}

		//Update User
		elseif ($module=='user' AND $act=='update') {
		   $User_id = $_POST['user_id'];
		   $Password = md5($_POST['password']);
		   $Nama = $_POST['nama'];
		   $Alamat = $_POST['alamat'];
		   $Jenis_Kelamin = $_POST['jenis_kelamin'];
		   $Level = $_POST['level'];

		   mysqli_query($conn, "update user set user_id='$User_id', nama='$Nama', alamat='$Alamat', jenis_kelamin='$Jenis_Kelamin', level='$Level' where user_id='$_POST[id]'");

		
			header('location:../../media.php?module='.$module);
		}

		//Hapus  User
		elseif($module=='user' AND $act=='hapus'){
			mysqli_query($conn, "delete from user where user_id='$_GET[id]'");
			header('location:../../media.php?module='.$module);
		}
	}


?>