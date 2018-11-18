<?php
	error_reporting(0);
	session_start();
	include "config/koneksi.php";

	$sid = session_id();

	if($_GET){
		if(isset($_GET['act'])){
			if(isset($_GET['act'])=="hapus"){
				mysqli_query($conn, "Delete from tmp_transaksi_pemasok where id_tmp='$_GET[id]' AND id_session='$sid'");
			}
		}

		if($_POST){
			if(isset($_POST['btnTambah'])){

				if(empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){

					echo"<link href='css/style.css' rel='stylesheet' type='text/css'>
							<center>Untuk mengakses modul, Anda harus login <br>";
					echo "<a href=index.php><b>LOGIN</b></a></center>";

				}else{

					$Id_Pemasok = $_POST['id_pemasok'];
					$Nama_Bahan = $_POST['nama_bahan'];
					$Harga = $_POST['harga'];
					$Jumlah = $_POST['jumlah'];
			
							$sql5= mysqli_query($conn, "select id_pemasok from tmp_transaksi_pemasok where id_pemasok='$Id_Pemasok' AND id_session='$sid'");
							
							$ketemu = mysql_num_rows($sql5);
							if($ketemu==0){
								mysqli_query($conn, "insert into tmp_transaksi_pemasok(id_pemasok,nama_bahan,harga,jumlah,id_session) Values('$Id_Pemasok','$Nama_Bahan','$Harga','$Jumlah','$sid')");
									$Subtotal = $Harga;
							}
				}
			}
		

			if(isset($_POST['btnSave'])){
				function isittemp(){
						include "config/koneksi.php";

						$isitemp = array();
						$sid = session_id();
						$sql7 = mysqli_query($conn, "select * from tmp_transaksi_pemasok where id_session='$sid'");
						
						while($r7 = mysqli_fetch_array($sql7)){
							$isitemp[] = $r7;
						}
						return $isitemp;
					}

			
					$No_Pembelian = $_POST['no_pembelian'];
					$Nama = $_POST['nama'];
					$Tanggal = 	InggrisTgl($_POST['tanggal']);

					//Simpan Data Transaksi
					mysqli_query($conn, "insert into transaksi_pemasok(no_pembelian,nama,tgl_pemasok) Values('$No_Pembelian','$Nama','$Tanggal')");

					$isitemp = isittemp();
					$jml = count($isitemp);

						
					//INSERT ke Table Transaksi Pemesanan Item
					for($i=0; $i < $jml; $i++){
						mysqli_query($conn, "insert into transaksi_pemasok_item(no_pembelian,id_pemasok,nama_bahan,harga,jumlah) Values('$No_Pembelian','{$isitemp[$i]['id_pemasok']}','{$isitemp[$i]['nama_bahan']}',{$isitemp[$i]['harga']},{$isitemp[$i]['jumlah']})");
					}
					
					
					//INSERT ke Table Pemasok	
					for ($i=0; $i < $jml ; $i++) { 
						mysqli_query($conn, "insert into pemasok(id_pemasok,nama) Values('{$isitemp[$i]['id_pemasok']}','$Nama')");
					}

				/*	//INSERT ke Table Nota Pesanan
					for ($i=0; $i < $jml ; $i++) { 
						mysqli_query($conn, "insert into nota_pesanan(id_pesanan,user_id,jmlh_pesanan,tgl_pesanan) Values('$Id_Pemesanan','$User_id',{$isitemp[$i]['jumlah']},'$Tanggal')");
					}*/

					$sql6 = mysqli_query($conn, "select * from tmp_transaksi_pemasok");
					$ketemu = mysqli_num_rows($sql6);

					//Mengecek Data Pada Temp Transaksi Pemasok
					if($ketemu==0){
						echo "Data Temp Transaksi Pemesanan Kosong";
					}else{

						mysqli_query($conn, "delete from tmp_transaksi_pemasok");
					}

					echo"Data Berhasil Disimpan";
			}
		}
	}


	// SCRIPT untuk  Membuat Kode Otomatis
	$carikode = mysqli_query($conn, "Select no_pembelian from transaksi_pemasok" );
	$datakode = mysqli_fetch_array($carikode);
	$jumlahdata = mysqli_num_rows($carikode);

	if($datakode){
		$nilaikode = substr($jumlahdata[0], 1);

		// Menjadikan nilai kode(int)
		$kode = (int) $nilaikode;
		// Setiap kode ditambah 1
		$kode = $jumlahdata + 1;
		$kode_otomatis = "BL".str_pad($kode, 4, "0", STR_PAD_LEFT);

	}else{
		$kode_otomatis="BL0001";
	}

	$tglTransaksi = isset($_POST['tanggal']) ? $_POST['tanggal'] : date('d-m-Y');
	$Nama = isset($_POST['nama']) ? $_POST['nama'] : '';
	$Id_Pemasok =isset($_POST['id_pemasok']) ? $_POST['id_pemasok'] : '';


	echo"
	<div class='transaksi'>
	<html>
		<h3>Data Transaksi</h3>
		<form method='post' action='?module=transaksi_pemasok' target='_self'>
			<table class='list_transaksi'> 
				<tr>
					<td>No. Pembelian</td>
					<td> : <input type='text' name='no_pembelian' size='10' readonly='readonly' maxlength='10' value='". $kode_otomatis; echo "'></td>
				</tr>
				<tr>
					<td>Id Pemasok</td>
					<td> : <input type='text' name='id_pemasok' value='"; echo $Id_Pemasok; echo"'  size='10' id='id_pembeli' size='10' maxlength='15'></td>
				</tr>
				<tr>
					<td>Nama</td>
					<td> : <input type='text' name='nama' value='"; echo $Nama; echo"'  size='50' id='nama' size='100' maxlength='100'></td>
				</tr>
				<tr>
					<td>Tanggal Pembelian</td>
					<td> : "; echo form_tanggal("tanggal",$tglTransaksi); echo"</td>
				</tr>
			</table>
			<h3>Input Bahan</h3>
			<table class='list_transaksi'>
				<tr>
					<td align='center'>Nama Bahan</td>
				    <td> : <select class='nama_bahan' name='nama_bahan'>
					<option value=$Nama_Bahan selected></option>";
						$tampil = mysqli_query($conn, "Select kode_bahan, nama_bahan from bahan_makanan");
						while($r = mysqli_fetch_array($tampil)){
							echo"<option value='$r[nama_bahan]'>[$r[kode_bahan]] $r[nama_bahan]</option>";
						}
					echo"</select></td>
				</tr>
				<tr>
					<td align='center'>Harga Beli (Rp) & Jumlah</td>
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
						<table class='list_transaksi'>
							<thead>
								<tr>
									<td class='left' width='25'>No.</td>
									<td class='left'>Id Pemasok</td>
									<td class='left'>Nama Bahan</td>
									<td class='left'>Harga(Rp)</td>
									<td class='left'>Jumlah</td>
									<td class='left'>Subtotal (Rp)</td>
									<td class='left'>Delete</td>
								</tr>
							</thead>";
							//bagian isi daftar menu

							$tmpquery = mysqli_query($conn, "Select * from tmp_transaksi_pemasok where tmp_transaksi_pemasok.id_session='$sid'");
							$no=0;
							while ($rtemp = mysqli_fetch_array($tmpquery)) {
								$Id_Tmp = $rtemp['id_tmp'];
								$Harga = $rtemp['harga'];
								$Harga_rp = format_rupiah($rtemp['harga']);
								$Id_Pemasok = $rtemp['id_pemasok'];
								$Nama_Bahan = $rtemp['nama_bahan'];
								$Jumlah = $rtemp['jumlah'];
								$Subtotal = $rtemp['jumlah'] * $Harga;
								$Subtotal_rp = format_rupiah($Subtotal);
								$Jumlah_Barang = $Jumlah_Barang + $rtemp['jumlah'];
								$Total = $Total + $Subtotal;
								$Total_rp = format_rupiah($Total);
								$no++;

								echo"<tr>
										<td class='left' heigth='25'>"; echo $no; echo"</td>
										<td class='left'>"; echo $Id_Pemasok; echo"</td>
										<td class='left'>"; echo $Nama_Bahan; echo"</td>
										<td class='left'>"; echo $Harga; echo"</td>
										<td class='left'>"; echo $Jumlah; echo"</td>
										<td class='left'>"; echo $Subtotal; echo"</td>
										<td class='left'><a href='?module=transaksi_pemasok&act=hapus&id=$Id_Tmp'><img src='images/hapus.png' width='16' heigth='16' border='0'></a></td>
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
	</html>
	</div>";
	
?>