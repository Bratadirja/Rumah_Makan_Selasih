<?php
	session_start();
	if(empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
		echo "<link href='css/style.css' rel='stylesheet' type='type/css'
		<center>Untuk Mengakses Modul, Anda Harus Login<br>";
		echo "<a href=index.php><b>Login</b></a></center>";

	}else{

		include "../../config/koneksi.php";
		include "../../config/library2.php";


		$module = $_GET[module];
		$act = $_GET[act];

		//Input Bahan Makanan
		if($module=='bahan_makanan' AND $act=='input'){
			$Kode_Bahan = $_POST['kode_bahan'];
			$Nama_Bahan = $_POST['nama_bahan'];
			$Jenis_Bahan = $_POST['jenis_bahan'];
			$Tgl_Produksi = InggrisTgl($_POST['tgl_produksi']);
			$Tgl_Kadaluarsa = InggrisTgl($_POST['tgl_kadaluarsa']);

			mysqli_query($conn, "insert into bahan_makanan(kode_bahan,nama_bahan,jenis_bahan,tgl_produksi,tgl_kadaluarsa) values('$Kode_Bahan','$Nama_Bahan','$Jenis_Bahan','$Tgl_Produksi','$Tgl_Kadaluarsa')");
			header('location:../../media.php?module='.$module);
		}

		//Update Bahan Makanan
		elseif($module=='bahan_makanan' AND $act=='update'){
			$Kode_Bahan = $_POST['kode_bahan'];
			$Nama_Bahan = $_POST['nama_bahan'];
			$Jenis_Bahan = $_POST['jenis_bahan'];
			$Tgl_Produksi =InggrisTgl($_POST['tgl_produksi']);
			$Tgl_Kadaluarsa = InggrisTgl($_POST['tgl_kadaluarsa']);

			mysqli_query($conn, "update bahan_makanan set kode_bahan='$Kode_Bahan',nama_bahan='$Nama_Bahan',jenis_bahan='$Jenis_Bahan',tgl_produksi='$Tgl_Produksi',tgl_kadaluarsa='$Tgl_Kadaluarsa' where kode_bahan='$_POST[id]'");
			header('location:../../media.php?module='.$module);
		}

		//Hapus Bahan Makanan
		elseif($module=='bahan_makanan' AND $act='hapus'){
			mysqli_query($conn, "delete from bahan_makanan where kode_bahan='$_GET[id]'");
			header('location:../../media.php?module='.$module);
		}


	}
?>