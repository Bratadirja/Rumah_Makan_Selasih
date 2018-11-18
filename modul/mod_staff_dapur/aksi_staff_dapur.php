<?php
	session_start();
	if(empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
		echo "<link href='css/style.css' rel='stylesheet' type='text/css'
		<center>Untuk Mengakses Modul, Anda Harus Login <br>";
		echo "<a href=index.php><b>Login</b></a></center>";

	}else{

		include "../../config/koneksi.php";

		$module = $_GET[module];
		$act = $_GET[act];

		//Input Staff Dapur
		if($module=='staff_dapur' AND $act=='input'){
			$Id_Staff = $_POST['id_staff'];
			$Nama = $_POST['nama'];
			$Alamat = $_POST['alamat'];
			$Jenis_Kelamin = $_POST['jenis_kelamin'];

			mysqli_query($conn, "insert into staff_dapur(id_staff,nama,alamat,jenis_kelamin) Values('$Id_Staff','$Nama','$Alamat','$Jenis_Kelamin')");

			header('location:../../media.php?module='.$module);
		}

		//Update Staff Dapur
		elseif ($module=='staff_dapur' AND $act=='update') {
			$Id_Staff = $_POST['id_staff'];
			$Nama = $_POST['nama'];
			$Alamat = $_POST['alamat'];
			$Jenis_Kelamin = $_POST['jenis_kelamin'];

			mysqli_query($conn, "Update staff_dapur set id_staff='$Id_Staff',nama='$Nama',alamat='$Alamat',jenis_kelamin='$Jenis_Kelamin' where id_staff='$_POST[id]'");

			header('location:../../media.php?module='.$module);
		}

		//Hapus Staff Dapur
		elseif ($module=='staff_dapur' AND $act=='hapus') {
			mysqli_query($conn, "delete from staff_dapur where id_staff='$_GET[id]'");

			header('location:../../media.php?module='.$module);
		}
	}
?>