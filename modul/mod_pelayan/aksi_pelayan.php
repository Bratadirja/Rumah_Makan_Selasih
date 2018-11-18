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

		//Input Pelayan
		if($module=='pelayan' AND $act=='input'){
			$Id_Pelayan = $_POST['id_pelayan'];
			$Nama = $_POST['nama'];
			$Jenis_Kelamin = $_POST['jenis_kelamin'];

			mysqli_query($conn, "insert into pelayan(id_pelayan,nama,jenis_kelamin) Values('$Id_Pelayan','$Nama','$Jenis_Kelamin')");

			header('location:../../media.php?module='.$module);
		}

		//Update Pelayan
		elseif ($module=='pelayan' AND $act=='update') {
			$Id_Pelayan = $_POST['id_pelayan'];
			$Nama = $_POST['nama'];
			$Jenis_Kelamin = $_POST['jenis_kelamin'];

			mysqli_query($conn, "Update pelayan set id_pelayan='$Id_Pelayan',nama='$Nama',jenis_kelamin='$Jenis_Kelamin' where id_pelayan='$_POST[id]'");

			header('location:../../media.php?module='.$module);
		}

		//Hapus Pelayan
		elseif ($module=='pelayan' AND $act=='hapus') {
			mysqli_query($conn, "delete from pelayan where id_pelayan='$_GET[id]'");

			header('location:../../media.php?module='.$module);
		}
	}

?>