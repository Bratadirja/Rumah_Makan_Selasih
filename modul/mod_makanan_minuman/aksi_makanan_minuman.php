<?php
	session_start();
	if(empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
		echo "<link href='css/style.css' rel='stylesheet' type='text/css'>
		<center>Untuk Mengakses Modul, Anda Harus Login <br>
		echo<a href=index.php><b>Login</b></a></center>";

	}else{
		include "../../config/koneksi.php";
		include "../../config/library.php";
		include "../../config/library2.php";
		include "../../config/fungsi_indotgl.php";
		include "../../config/fungsi_combobox.php";
		include "../../config/class_paging.php";

		$module = $_GET[module];
		$act = $_GET[act];

		//Input Makanan Minuman
		if($module=='makanan_minuman' AND $act=='input'){
			$Id_List = $_POST['id_list'];
	  	    $Nama_Menu = $_POST['nama_menu'];
	   		$Kategori = $_POST['kategori'];
	   		$Harga = $_POST['harga'];

	   		mysqli_query($conn, "insert into makanan_minuman(id_list,nama_menu,kategori,harga) values('$Id_List','$Nama_Menu','$Kategori','$Harga')");
	   		header('location:../../media.php?module='.$module);
		}

		//Update Makanan Minuman
		elseif($module=='makanan_minuman' AND $act=='update'){
			$Id_List = $_POST['id_list'];
	  	    $Nama_Menu = $_POST['nama_menu'];
	   		$Kategori = $_POST['kategori'];
	   		$Harga = $_POST['harga'];

			mysqli_query($conn, "update makanan_minuman set id_list='$Id_List',nama_menu='$Nama_Menu',kategori='$Kategori',harga='$Harga' where id_list='$_POST[id]'");
			header('location:../../media.php?module='.$module);
		}

		//Hapus Makanan Minuman
		elseif($module=='makanan_minuman' AND $act=='hapus'){
			mysqli_query($conn, "delete from makanan_minuman where id_list='$_GET[id]'");
			header('location:../../media.php?module='.$module);
		}

		//Tambah Ke Daftar Menu
		elseif($module=='makanan_minuman' AND $act=='simpan_daftar_menu'){
			$Kode_Menu = $_POST['pilih_menu'];
			$Id_List = $_POST['id'];

			mysqli_query($conn, "insert into retail_berisi(Kode_Menu,id_list) values('$Kode_Menu','$Id_List')");
    		header('location:../../media.php?module='.$module);
		}

	}
?>