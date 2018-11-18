<html>
<head>
	<script type="text/javascript">
		function validasi(form){
			if(form.id_list.value == ""){
				alert("Data Harus Diisi Terlebih Dahulu")
				form.id_list.focus();
				return(false);
			}
			return(true);
		}
	</script>
</head>	

<?php
	error_reporting(0);
	session_start();
	$aksi = "modul/mod_makanan_minuman/aksi_makanan_minuman.php";

	switch ($_GET['act']) {
		//Tampil Makanan Minuman
		default:
		echo "<h2>Data Makanan Minuman</h2>
		<input type=button value='Tambah Makanan Minuman' onclick=\"window.location.href='?module=makanan_minuman&act=tambah_makanan_minuman';\">
		<div class='cari'>
			<form action='?module=makanan_minuman&act=cari' method='post'>
				<label>Cari : </label>
				<input type='text' name='cari'>
				<input type='submit' value='Cari'>	
			</form>
		</div>";
?>
		<table class='list'>	
			<thead>
				<tr>	
					<td class='left'>No.</td>
					<td class='left'>ID List</td>
					<td class='left'>Nama Menu</td>
					<td class='left'>Kategori</td>
					<td class='left'>Harga Satuan</td>
					<td class='left'>Edit</td>
					<td class='left'>Hapus</td>
					<td class='left'>Tambah ke Menu</td>
				</tr>
			</thead>
			<tbody>
				<?php
					$p = new Paging;
					$batas = 10;
					$posisi = $p->cariPosisi($batas);

					$tampil = mysqli_query($conn,"select * from makanan_minuman order by id_list LIMIT $posisi,$batas");
					$no = $posisi+1;
					while ($data=mysqli_fetch_array($tampil)) {
						echo "<tr>
								  <td class='left' width='25'>$no</td>
								  <td class='left'>$data[id_list]</td>
								  <td class='left'>$data[nama_menu]</td>
								  <td class='left'>$data[kategori]</td>
								  <td class='left'> Rp ";?><?php echo format_rupiah($data[harga]); echo"</td>
								  <td class='left'><a href='?module=makanan_minuman&act=edit_makanan_minuman&id=$data[id_list]'><img src='images/btn_edit.png' width='20' height='20'></a></td>
								  <td class='left'><a href='$aksi?module=makanan_minuman&act=hapus&id=$data[id_list]'><img src='images/btn_delete.png' width='20' height='20' /></a></td>
								  <td class='left'><a href='?module=makanan_minuman&act=tambah_daftar_menu&id=$data[id_list]'>Tambah ke Menu</a></td>
							  </tr>";
							$no++;
					}
					echo "</tbody></table>";

					$jmldata = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM makanan_minuman"));
					$jmlhalaman = $p->jumlahHalaman($jmldata, $batas);
					$linkHalaman = $p->navHalaman($_GET[halaman],$jmlhalaman);

					echo "<div class=\"pagination\"> $linkHalaman</div>";
					break;

					case "tambah_makanan_minuman":
					echo "<h2>Tambah Makanan Minuman</h2><body OnLoad='document.isi.kode_menu.focus();'>
					<form method='post' name='isi' action='$aksi?module=makanan_minuman&act=input' onSubmit='return validasi(this)'>
						<table class='list'>
							<tr>
								<td>ID List</td>
								<td> : <input type='text' name='id_list' size='15' maxlength='15'></td>
							</tr>
							<tr>
								<td>Nama Menu</td>
								<td> : <input type='text' name='nama_menu' size='35' maxlength='100'></td>
							</tr>
							<tr>
								<td>Kategori</td>
								<td> : <select name='kategori'>
											<option value='Makanan'>Makanan</option>
											<option value='Minuman'>Minuman</option>
										</select>
								</td>
							</tr>
							<tr>
								<td>Harga Satuan (Rp)</td>
								<td> : <input type='text' name='harga' size='20' maxlength='50'></td>
							<tr>
							<tr>
								<td colspan='2'><input type='submit' value='Simpan' />
												<input type='button' value='Batal' onclick=self.history.back()></td>
							</tr>
						</table>
					</form></body>";
					break;

					case "edit_makanan_minuman":
					$edit = mysqli_query($conn, "select * from makanan_minuman where id_list='$_GET[id]'");
					$data = mysqli_fetch_array($edit);
					echo "<h2> Edit Makanan Minuman </h2>
					<form method='post' action='$aksi?module=makanan_minuman&act=update'>
					<input type='hidden' name='id' value='$data[id_list]'>
						<table class='list'>
							<tr>
								<td>ID List</td>
								<td> : <input type='text' readonly value='$data[id_list]' name='id_list' size='15' maxlength='15'></td>
							</tr>
							<tr>
								<td>Nama Menu</td>
								<td> : <input type='text' value='$data[nama_menu]' name='nama_menu' size='35' maxlength='100'></td>
							</tr>
							<tr class='kategori'>
	 							<td>Kategori</td>
	 							<td> : <select name='kategori'>";
	 							if($data['kategori']=='Makanan'){

	 								echo "<option value='Makanan' selected>Makanan</option>
	 									  <option value='Minuman'>Minuman</option>";

	 							}elseif($data['kategori']=='Minuman'){

	 								echo "<option value='Makanan'>Makanan</option>
	 									  <option value='Minuman' selected>Minuman</option>";

	 							}
	 								echo"</select></td>
 							</tr>
							<tr>
								<td>Harga Satuan (Rp)</td>
								<td> : <input type='text' value='$data[harga]' name='harga' size='20' maxlength='50'></td>
							</tr>
							<tr>
								<td colspan='2'><input type='submit' value='Update' />
												<input type='button' value='Batal' onclick=self.history.back()></td>
							</tr>
						</table>
					</form>";
					break;

					case "tambah_daftar_menu":
					$edit = mysqli_query($conn, "select * from makanan_minuman where id_list='$_GET[id]'");
					$data = mysqli_fetch_array($edit);

					echo "
					<h2>Memilih Menu</h2>
					<form method='post' action='$aksi?module=makanan_minuman&act=simpan_daftar_menu'>
						<input type='submit' value='Simpan ke Menu'>
						<input type='hidden' name='id' value='$data[id_list]'>";

?>
						<table class='list'>	
							<thead>
								<tr>	
									<td class='left'>No.</td>
									<td class='left'>ID List</td>
									<td class='left'>Nama Menu</td>
									<td class='left'>Kategori</td>
									<td class='left'>Harga Satuan</td>
									<td class='left'>Tambah ke Menu</td>
								</tr>
							</thead>
							<tbody>
								<?php 
									//echo "<form method='post' action='$aksi?module=makanan_minuman&act=simpan_daftar_menu'>";

									$tampil = mysqli_query($conn,"select * from makanan_minuman where id_list='$_GET[id]'");
									echo "<input type='hidden' name='id' value='$data[id_list]'>";
									$no = 1;
									while ($data=mysqli_fetch_array($tampil)) {
										echo "<tr>
												  <td class='left' width='25'>$no</td>
												  <td class='left'>$data[id_list]</td>
												  <td class='left'>$data[nama_menu]</td>
												  <td class='left'>$data[kategori]</td>
												  <td class='left'> Rp ";?><?php echo format_rupiah($data[harga]); echo"</td>";
								
											  
											$no++;
									}
									echo "
									<td> <select class='pilih_menu' name='pilih_menu'>
									<option value=$Pilih_Menu selected>$Pilih_Menu</option>";
									$tampil1 = mysqli_query($conn, "Select kode_menu, jenis_menu from menu");
									while($r = mysqli_fetch_array($tampil1)){
										echo"<option value=$r[kode_menu]>[$r[kode_menu]] | $r[jenis_menu]</option>";
									}
								echo"
								</select></td>
												</tr>
											  </tbody></table>
											  </form>";

									/*
									$subquery = mysqli_query($conn, "Select * from retail_berisi where kode_menu='".$data1['kode_menu']."' ");
									$sql = mysqli_query($conn, "select * from menu");

									echo "<h2>Tambah ke Menu</h2>";
									while ($data3 = mysqli_fetch_array($sql)) {

											echo "<br><input type='checkbox' name='kode_menu[]' value='.$data3[kode_menu].'> $data3[kode_menu] : $data3[jenis_menu]</input>";

									}

									echo "<input type='hidden' name='id_list' value='$data1[id_list]'>
										  <br><br>
										  <input type='submit' value='Simpan'>
									</form>";*/

									
											
					break;

					case "cari" :
							if(isset($_POST['cari'])){
								$cari = $_POST['cari'];
								$data = mysqli_query($conn, "select * from makanan_minuman where nama_menu like '%".$cari."%' OR kategori like '%".$cari."%'");			
							}else{

								$data = mysqli_query($conn, "select * from makanan_minuman");
							}
							$no=1;
?>
						<table class='list'>	
							<thead>
								<tr>	
									<td class='left'>No.</td>
									<td class='left'>ID List</td>
									<td class='left'>Nama Menu</td>
									<td class='left'>Jumlah</td>
									<td class='left'>Harga Satuan</td>
									<td class='left'>Edit</td>
									<td class='left'>Hapus</td>
								</tr>
							</thead>
						
<?php

							while($d = mysqli_fetch_array($data)){
								?>
								<tr>
									<td class='left' width='25'><?php echo "$no"; ?></td>
									<td class='left'><?php echo "$d[id_list]"; ?></td>
									<td class='left'><?php echo "$d[nama_menu]";?></td>
									<td class='left'><?php echo "$d[jumlah]";?></td>
									<td class='left'><?php echo "$d[harga]";?></td>
									<td class='left'><?php echo "<a href='?module=makanan_minuman&act=edit_makanan_minuman&id=$d[id_list]'>";?><img src='images/btn_edit.png' width='20' height='20'></a></td>
									<td class='left'><?php echo "<a href='$aksi?module=makanan_minuman&act=hapus&id=$d[id_list]'>";?><img src='images/btn_delete.png' width='20' height='20'></a></td>
<?php
									$no++;
?>
								</tr>
<?php
							}
							echo "</table>";
									
						break;
?>
			</tbody>
		</table>
<?php
	}

?>	

</html>