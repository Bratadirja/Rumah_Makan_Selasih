<?php
	error_reporting(0);
	session_start();

	echo "<link href='../../css/stylelap.css' rel='stylesheet' type='text/css'>";
	include "../../config/koneksi.php";
	include "../../config/library.php";
	include "../../config/library2.php";
	include "../../config/fungsi_indotgl.php";

	echo"<h2>Laporan Penjualan Rumah Makan Selasih</h2>
	<table class='list'>";

	$sql4 = mysqli_query($conn, "select transaksi_pemesanan.*, pembeli.id_pembeli from transaksi_pemesanan natural join pembeli where no_transaksi='$_GET[no_nota]'");
	$r4 = mysqli_fetch_array($sql4);

	$tanggal = IndonesiaTgl($r4['tanggal']);
	$No_Transaksi = $r4['no_transaksi'];
	$Id_Pembeli = $r4['id_pembeli'];
	$User_id = $r4['userid'];
	$Nama = $r4['nama'];
	$Alamat = $r4['alamat'];

	echo"
	<tr><td class='left' width='100' colspan='2'>Tanggal : $tanggal &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nama Kasir : $User_id</td></tr>
	<tr><td class='left' colspan='2'>No. Transaksi : $No_Transaksi </td></tr>
	<tr><td class='left' colspan='2'>ID. Pembeli : $Id_Pembeli </td></tr>
	<tr>
		<td class='left'>Nama : $Nama</td>
	</tr>
	<tr>
		<td class='left'>Alamat : $Alamat</td>
	</tr>
	<tr><td colspan='2'>";

	echo"<table class='list'>
		<thead>
			<tr>
				<td class='left' width='25'>No.</td>
				<td class='left'>Id Pembeli</td>
				<td class='left'>Nama Menu</td>
				<td class='left'>Harga(Rp)</td>
				<td class='left'>QTY</td>
				<td class='left'>Subtotal</td>
			</tr>
		</thead>
		<tr><td colspan='8' class='left'><strong></strong></td></tr>";
		$sql5 = mysqli_query($conn, "select * from transaksi_pemesanan_item where no_transaksi='$_GET[no_nota]'");
		$no=1;
		while($r5=mysqli_fetch_array($sql5)){
			$Id_Pembeli = $r5['id_pembeli'];
			$Nama_Menu = $r5['nama_menu'];
			$Harga = $r5['harga'];
			$Jumlah = $r5['jumlah'];
			$Harga_rp = format_rupiah($r5['harga']);
			$Subtotal = $r5['jumlah'] * $Harga;
			$Subtotal_rp = format_rupiah($Subtotal);
			$Jumlah_Barang = $Jumlah_Barang + $rtemp['jumlah'];
			$Total = $Total + $Subtotal;
			$Total_rp = format_rupiah($Total);
			echo "<tr><td class='left'>$no</td>
					  <td class='left'>$Id_Pembeli</td>
					  <td class='left'>$Nama_Menu</td>
					  <td class='left'>$Harga_rp</td>
					  <td class='left'>$Jumlah</td>
					  <td class='left'>$Subtotal_rp</td>
				   <tr>";
				   $no++;
		}
		$bayar = $Total;
		$bayar_rp = format_rupiah($bayar);
		echo"</table></td></tr>
		<tr>
			<td class='left'>Harga Sudah Termasuk PPN 10%</td><td class='right'>Total Pembayaran : $Total_rp</td>
		</tr>
	</table>";

	
?>