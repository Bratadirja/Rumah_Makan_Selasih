<?php
	error_reporting(0);
	session_start();

	
	$sid = session_id();


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
					echo "<a href=index.php><b>LOGIN</b></a></center>";

				}else{

					$Id_Pembeli = $_POST['id_pembeli'];
					$Nama_Menu = $_POST['nama_menu'];
					$Harga = $_POST['harga'];
					$Jumlah = $_POST['jumlah'];
			
							$sql5= mysqli_query($conn, "select id_pembeli from tmp_transaksi_pemesanan where id_pembeli='$Id_Pembeli' AND id_session='$sid'");
							
							$ketemu = mysql_num_rows($sql5);
							if($ketemu==0){
								mysqli_query($conn, "insert into tmp_transaksi_pemesanan(id_pembeli,nama_menu,harga,jumlah,id_session) Values('$Id_Pembeli','$Nama_Menu','$Harga','$Jumlah','$sid')");
									$Subtotal = $Harga;
							}
				}
			}
		

			if(isset($_POST['btnSave'])){
				function isittemp(){
						include "config/koneksi.php";

						$isitemp = array();
						$sid = session_id();
						$sql7 = mysqli_query($conn, "select * from tmp_transaksi_pemesanan where id_session='$sid'");
						
						while($r7 = mysqli_fetch_array($sql7)){
							$isitemp[] = $r7;
						}
						return $isitemp;
					}

			
					$No_Transaksi = $_POST['no_transaksi'];
					$Nama = $_POST['nama'];
					$Tanggal = 	InggrisTgl($_POST['tanggal']);
					$Alamat = $_POST['alamat'];
					$Id_Pemesanan = $_POST['id_pemesanan'];
					$User_id = $_SESSION['namauser'];

					//Simpan Data Transaksi
					mysqli_query($conn, "insert into transaksi_pemesanan(no_transaksi,id_pemesanan,nama,tanggal,alamat,userid) Values('$No_Transaksi','$Id_Pemesanan','$Nama','$Tanggal','$Alamat','$User_id')");
					

					$isitemp = isittemp();
					$jml = count($isitemp);

					for($i=0; $i < $jml; $i++){
						mysqli_query($conn, "insert into struk(nomor_transaksi,jmlh_transaksi,tgl_transaksi) Values('$No_Transaksi',{$isitemp[$i]['jumlah']},'$Tanggal')");
					}
						
					//INSERT ke Table Transaksi Pemesanan Item
					for($i=0; $i < $jml; $i++){
						mysqli_query($conn, "insert into transaksi_pemesanan_item(no_transaksi,id_pembeli,nama_menu,harga,jumlah) Values('$No_Transaksi','{$isitemp[$i]['id_pembeli']}','{$isitemp[$i]['nama_menu']}',{$isitemp[$i]['harga']},{$isitemp[$i]['jumlah']})");
					} 
					
					
					//INSERT ke Table Pembeli	
					for ($i=0; $i < $jml ; $i++) { 
						mysqli_query($conn, "insert into pembeli(id_pembeli,nama,alamat) Values('{$isitemp[$i]['id_pembeli']}','$Nama','$Alamat')");
					}

					//INSERT ke Table Nota Pesanan
					for ($i=0; $i < $jml ; $i++) { 
						mysqli_query($conn, "insert into nota_pesanan(id_pesanan,user_id,jmlh_pesanan,tgl_pesanan) Values('$Id_Pemesanan','$User_id',{$isitemp[$i]['jumlah']},'$Tanggal')");
					}

					$sql6 = mysqli_query($conn, "select * from tmp_transaksi_pemesanan");
					$ketemu = mysqli_num_rows($sql6);


					//Mengecek Data Pada Temp Transaksi Pemesanan
					if($ketemu==0){
						echo "Data Temp Transaksi Pemesanan Kosong";
					}else{

						mysqli_query($conn, "delete from tmp_transaksi_pemesanan");
					}

					echo"Data Berhasil Disimpan";
			}

			if(isset($_POST['btnCetak'])){
				header("location:media.php?module=lap_cetak_struk");
			}


		}
	}

	// SCRIPT untuk  Membuat Kode Otomatis
	$carikode = mysqli_query($conn, "Select no_transaksi from transaksi_pemesanan" );
	$datakode = mysqli_fetch_array($carikode);
	$jumlahdata = mysqli_num_rows($carikode);

	if($datakode){
		$nilaikode = substr($jumlahdata[0], 1);

		// Menjadikan nilai kode(int)
		$kode = (int) $nilaikode;
		// Setiap kode ditambah 1
		$kode = $jumlahdata + 1;
		$kode_otomatis = "TR".str_pad($kode, 4, "0", STR_PAD_LEFT);

	}else{
		$kode_otomatis="TR0001";
	}

		
	$tglTransaksi = isset($_POST['tanggal']) ? $_POST['tanggal'] : date('d-m-Y');
	$Id_Pemesanan = isset($_POST['id_pemesanan']) ? $_POST['id_pemesanan'] : '';
	$Nama = isset($_POST['nama']) ? $_POST['nama'] : ''; 
	$Alamat = isset($_POST['alamat']) ? $_POST['alamat'] : '';
	$Id_Pembeli =isset($_POST['id_pembeli']) ? $_POST['id_pembeli'] : '';


	echo"
	<html>
		<div class='transaksi'>
			<h3>Data Transaksi</h3>
			<form method='post' action='?module=transaksi_pemesanan' target='_self'>
				<table class='list_transaksi'> 
					<tr>
						<td>No. Transaksi</td>
						<td> : <input type='text' name='no_transaksi' size='10' readonly='readonly' maxlength='10' value='". $kode_otomatis; echo "'></td>
					</tr>
					<tr>
						<td>Id Pembeli</td>
						<td> : <input type='text' name='id_pembeli' value='"; echo $Id_Pembeli; echo"'  size='10' id='id_pembeli' size='10' maxlength='15'></td>
					</tr>
					<tr>
						<td>Nama</td>
						<td> : <input type='text' name='nama' value='"; echo $Nama; echo"'  size='50' id='nama' size='100' maxlength='100'></td>
					</tr>
					<tr>
						<td>Alamat</td>
						<td> &nbsp;  <input type='text' value='"; echo $Alamat; echo"'	 style='height:70px; width:300px ' name='alamat' id='nama' ></td>
					</tr>
					<tr>
						<td>Id Pemesanan</td>
						<td> : <input type='text' name='id_pemesanan' value='"; echo $Id_Pemesanan; echo"' size='10' maxlength='10'></td> 
					<tr>
					<tr>
						<td>Tanggal Pemesanan</td>
						<td> : "; echo form_tanggal("tanggal",$tglTransaksi); echo"</td>
					</tr>
				</table>
				<h3>Input Menu</h3>
				<table class='list_transaksi'>

					<tr>
						<td align='center'>Nama Menu</td>
					    <td> : <select class='nama_menu' name='nama_menu'>
						<option value=$Nama_Menu selected></option>";
							$tampil = mysqli_query($conn, "Select kode_menu, nama_menu, harga from makanan_minuman natural join retail_berisi");
							while($r = mysqli_fetch_array($tampil)){
								echo"<option value='$r[nama_menu]'>[$r[kode_menu]] $r[nama_menu] | Rp. $r[harga]</option>";
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
						<td><input name='btnSave' type='submit' style='cursor:pointer;' value=' SIMPAN TRANSAKSI ' />
						<input name='btnCetak' type='submit' style='cursor:pointer;' Value='CETAK STRUK' /></td>
					</tr>
					<tr>
						<td colspan='2'>
							<table class='data_list_transaksi'>
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
											<td class='left'><a href='?module=transaksi_pemesanan&act=hapus&id=$Id_Tmp'><img src='images/hapus.png' width='16' heigth='16' border='0'></a></td>
										</tr>";
								}
								echo"<tr>
										<td colspan='4' align='right'><b>Grand Total</b></td>
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
		</div>
	</html>";

?>