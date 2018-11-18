<?php
	session_start();
	if(empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
		echo "<link href='css/style.css' rel='stylesheet' type='text/css'>
		<center>Untuk Mengakses Modul, Anda Harus Login <br>
		echo<a href=index.php><b>Login</b></a></center>";

	}else{
		include "../../config/koneksi.php";

		$module = $_GET[module];
		$act = $_GET[act];

		//Input Makanan Minuman
		if($module=='menu' AND $act=='input'){
			$Kode_Menu = $_POST['kode_menu'];
	  	    $Jenis_Menu = $_POST['jenis_menu'];
	   		$Kategori = $_POST['kategori'];
	   		$Satuan = $_POST['satuan'];

	   		mysqli_query($conn, "insert into menu(kode_menu,jenis_menu,kategori,satuan) values('$Kode_Menu','$Jenis_Menu','$Kategori','$Satuan')");
	   		header('location:../../media.php?module='.$module);
		}

		//Update Makanan Minuman
		elseif($module=='menu' AND $act=='update'){
			$Kode_Menu = $_POST['kode_menu'];
	  	    $Jenis_Menu = $_POST['jenis_menu'];
	   		$Kategori = $_POST['kategori'];
	   		$Satuan = $_POST['satuan'];

			mysqli_query($conn, "update menu set kode_menu='$Kode_Menu',jenis_menu='$Jenis_Menu',kategori='$Kategori',satuan='$Satuan' where kode_menu='$_POST[id]'");
			header('location:../../media.php?module='.$module);
		}

		//Hapus Makanan Minuman
		elseif($module=='menu' AND $act='hapus'){
			mysqli_query($conn, "delete from menu where kode_menu='$_GET[id]'");
			header('location:../../media.php?module='.$module);
		}
	}
?>