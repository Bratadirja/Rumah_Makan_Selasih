<?php
error_reporting(0);
session_start();

$aksi = "modul/mod_transaksi_pemesanan/aksi_transaksi_pemesanan.php";
$sid = session_id();

include "../../config/koneksi.php";

if($_GET){
	if(isset($_GET['act'])){
		if(isset($_GET['act'])=="hapus"){
			mysqli_query($conn, "Delete from tmp_transaksi_pemesanan where id_tmp='$_GET[id]' AND id_session='$sid'");
		}
	}

	if($_POST){
		if(isset($_POST['btnTambah'])){

			if(empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){

				echo"<link href='css/style.css' rel='stylesheet' type='text/css'>
						<center>Untuk mengakses modul, Anda harus login <br>";
				echo "<a href=login.php><b>LOGIN</b></a></center>";

			}else{

				
				$Id_Pembeli = $_POST['id_pembeli'];
				$Nama_Menu = $_POST['nama_menu'];
				$Harga = $_POST['harga'];
				$Jumlah = $_POST['jumlah'];
				$Nama = $_POST['nama'];
				$Alamat = $_POST['alamat'];
				$Id_Pemesanan = $_POST['id_pemesanan'];
				$Tanggal = 	InggrisTgl($_POST['tanggal']);

				
						$sql5 = mysqli_query($conn, "select id_pembeli from tmp_transaksi_pemesanan where id_pembeli='$Id_Pembeli' AND id_session='$sid'");
						$ketemu = mysql_num_rows($sql5);
						if($ketemu==0){
							mysqli_query($conn, "insert into tmp_transaksi_pemesanan(id_pembeli,nama_menu,harga,jumlah,id_session) Values('$Id_Pembeli','$Nama_Menu','$Harga','$Jumlah','$sid')");
								$Subtotal = $Harga;
						}
			}
		}
	}
}
	
$nomorTransaksi = buatKode($conn, "transaksi_pemesanan", date("ym"));
$tglTransaksi = isset($_POST['tanggal']) ? $_POST['tanggal'] : date('d-m-Y');
echo"
<html>
	<h3>Data Transaksi</h3>
	<form method='post' action='?module=transaksi_pemesanan' target='_self'>
		<table class='list'> 
			<tr>
				<td>No. Transaksi</td>
				<td> : <input type='text' name='no_transaksi' size='10' readonly='readonly' maxlength='10' value='". $nomorTransaksi; echo "'></td>
			</tr>
			<tr>
				<td>Id Pembeli</td>
				<td> : <input type='text' name='id_pembeli' size='10' id='id_pembeli' size='10' maxlength='15'></td>
			</tr>
			<tr>
				<td>Nama</td>
				<td> : <input type='text' name='nama' size='50' id='nama' size='100' maxlength='15'></td>
			</tr>
			<tr>
				<td>Alamat</td>
				<td> &nbsp; <textarea name='alamat' cols='40' rows='3'></textarea></td>
			</tr>
			<tr>
				<td>Id Pemesanan</td>
				<td> : <input type='text' name='id_pemesanan' size='10' maxlength='10'></td> 
			<tr>
			<tr>
				<td>Tanggal Pemesanan</td>
				<td> : "; echo form_tanggal("tanggal",$tglTransaksi); echo"</td>
			</tr>
		</table>
		<h3>Input Menu</h3>
		<table class='list'>
			<tr>
				<td align='center'>Nama Menu</td>
			    <td> : <select class='nama_menu' name='nama_menu'>
				<option value=$Nama_Menu selected>$Nama_Menu</option>";
					$tampil = mysqli_query($conn, "Select kode_menu, nama_menu, harga from makanan_minuman natural join menu");
					while($r = mysqli_fetch_array($tampil)){
						echo"<option value=$r[nama_menu]>[$r[kode_menu]] $r[nama_menu] | Rp. $r[harga]</option>";
					}
				echo"</select></td>
			</tr>
			<tr>
				<td align='center'>Harga Jual (Rp) & Jumlah</td>
				<td> : <input type='text' name='harga' size='10' maxlength='20'> 
						QTY <input type='text' name='jumlah' size='3' maxlength='5'>
						&nbsp;&nbsp; <input type='submit' name='btnTambah' style='cursor:pointer;' value=' Tambah '>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><input name='btnSave' type='submit' style='cursor:pointer;' value=' SIMPAN TRANSAKSI ' /></td>
			</tr>
			<tr>
				<td colspan='2'>
					<table class='list'>
						<thead>
							<tr>
								<td class='left' width='25'>No.</td>
								<td class='left'>Id Pembeli</td>
								<td class='left'>Nama Menu</td>
								<td class='left'>Harga(Rp)</td>
								<td class='left'>Jumlah</td>
								<td class='left'>Subtotal (Rp)</td>
								<td class='left'>Delete</td>
							</tr>
						</thead>";
						//bagian isi daftar menu

						$tmpquery = mysqli_query($conn, "Select * from tmp_transaksi_pemesanan where tmp_transaksi_pemesanan.id_session='$sid'");
						$no=0;
						while ($rtemp = mysqli_fetch_array($tmpquery)) {
							$Id_Tmp = $rtemp['id_tmp'];
							$Harga = $rtemp['harga'];
							$Harga_rp = format_rupiah($rtemp['harga']);
							$Id_Pembeli = $rtemp['id_pembeli'];
							$Nama_Menu = $rtemp['nama_menu'];
							$Jumlah = $rtemp['jumlah'];
							$Subtotal = $rtemp['jumlah'] * $Harga;
							$Subtotal_rp = format_rupiah($Subtotal);
							$Jumlah_Barang = $Jumlah_Barang + $rtemp['jumlah'];
							$Total = $Total + $Subtotal;
							$Total_rp = format_rupiah($Total);
							$no++;

							echo"<tr>
									<td class='left' heigth='25'>"; echo $no; echo"</td>
									<td class='left'>"; echo $Id_Pembeli; echo"</td>
									<td class='left'>"; echo $Nama_Menu; echo"</td>
									<td class='left'>"; echo $Harga; echo"</td>
									<td class='left'>"; echo $Jumlah; echo"</td>
									<td class='left'>"; echo $Subtotal; echo"</td>
									<td class='left'><a href='?module=transaksi_pemesanan&act=hapus&id=$Id_Tmp'><img src='images/hapus.gif' width='16' heigth='16' border='0'></a></td>
								</tr>";
						}
						echo"<tr>
								<td colspan='4' align='right'>Grand Total</td>
								<td class='left'>"; echo $Jumlah_Barang; echo"</td>
								<td class='left'>"; echo $Total_rp; echo"</td>
								<td clasd='left'>&nbsp;</td>
							</tr>
					</table>
					<input type='hidden'>
				</td>
			</tr>
		</table>
	</form>
</html>";

?>