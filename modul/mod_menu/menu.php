<html>
<head>
	<script type="text/javascript">
		function validasi(form){
			if(form.kode_menu.value == ""){
				alert("Data Harus Diisi Terlebih Dahulu")
				form.kode_menu.focus();
				return(false);
			}
			return(true);
		}
	</script>
</head>	

<?php
	error_reporting(0);
	session_start();
	$aksi = "modul/mod_menu/aksi_menu.php";

	switch ($_GET['act']) {
		//Tampil Makanan Minuman
		default:
		echo "<h2>Data Menu</h2>
		<input type=button value='Tambah Menu' onclick=\"window.location.href='?module=menu&act=tambah_menu';\">
		<div class='cari'>
			<form action='?module=menu&act=cari' method='post'>
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
					<td class='left'>Kode Menu</td>
					<td class='left'>Jenis Menu</td>
					<td class='left'>Kategori</td>
					<td class='left'>Satuan</td>
					<td class='left'>Edit</td>
					<td class='left'>Hapus</td>
				</tr>
			</thead>
			<tbody>
				<?php
					$p = new Paging;
					$batas = 10;
					$posisi = $p->cariPosisi($batas);

					$tampil = mysqli_query($conn,"select * from menu order by kode_menu LIMIT $posisi,$batas");
					$no = $posisi+1;
					while ($data=mysqli_fetch_array($tampil)) {
						echo "<tr>
								  <td class='left' width='25'>$no</td>
								  <td class='left'>$data[kode_menu]</td>
								  <td class='left'>$data[jenis_menu]</td>
								  <td class='left'>$data[kategori]</td>
								  <td class='left'>$data[satuan]</td>
								  <td class='left'><a href='?module=menu&act=edit_menu&id=$data[kode_menu]'><img src='images/btn_edit.png' width='20' height='20'></a></td>
								  <td class='left'><a href='$aksi?module=menu&act=hapus&id=$data[kode_menu]'><img src='images/btn_delete.png' width='20' height='20' /></a></td>
							  </tr>";
							$no++;
					}
					echo "</tbody></table>";

					$jmldata = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM menu"));
					$jmlhalaman = $p->jumlahHalaman($jmldata, $batas);
					$linkHalaman = $p->navHalaman($_GET[halaman],$jmlhalaman);

					echo "<div class=\"pagination\"> $linkHalaman</div>";
					break;

					case "tambah_menu":
					echo "<h2>Tambah Menu</h2><body OnLoad='document.isi.kode_menu.focus();'>
					<form method='post' name='isi' action='$aksi?module=menu&act=input' onSubmit='return validasi(this)'>
						<table class='list'>
							<tr>
								<td>Kode Menu</td>
								<td> : <input type='text' name='kode_menu' size='15' maxlength='15'></td>
							</tr>
							<tr>
								<td>Jenis Menu</td>
								<td> : <input type='text' name='jenis_menu' size='35' maxlength='100'></td>
							</tr>
							<tr>
								<td>Kategori</td>
								<td> : <select name='kategori'>
											<option value='Tersedia'>Tersedia</option>
											<option value='Kosong'>Tidak Tersedia</option>
										</select>
								</td>
							</tr>
							<tr>
								<td>Satuan</td>
								<td> : <input type='text' name='satuan' size='20' maxlength='50'></td>
							<tr>
							<tr>
								<td colspan='2'><input type='submit' value='Simpan' />
												<input type='button' value='Batal' onclick=self.history.back()></td>
							</tr>
						</table>
					</form></body>";
					break;

					case "edit_menu":
					$edit = mysqli_query($conn, "select * from menu where kode_menu='$_GET[id]'");
					$data = mysqli_fetch_array($edit);
					echo "<h2> Edit Menu </h2>
					<form method='post' action='$aksi?module=menu&act=update'>
					<input type='hidden' name='id' value='$data[kode_menu]'>
						<table class='list'>
							<tr>
								<td>Kode Menu</td>
								<td> : <input type='text' readonly value='$data[kode_menu]' name='kode_menu' size='15' maxlength='15'></td>
							</tr>
							<tr>
								<td>Jenis Menu</td>
								<td> : <input type='text' name='jenis_menu' value='$data[jenis_menu]' size='35'></td>
							</tr>
 							<tr class='kategori'>
	 							<td>Kategori</td>
	 							<td> : <select name='kategori'>";
	 							if($data['kategori']=='Tersedia'){

	 								echo "<option value='Tersedia' selected>Tersedia</option>
	 									  <option value='Kosong'>Tidak Terserdia</option>";

	 							}elseif($data['kategori']=='Kosong'){

	 								echo "<option value='Tersedia'>Tersedia</option>
	 									  <option value='Kosong' selected>Tidak Terserdia</option>";

	 							}
	 								echo"</select></td>
 							</tr>
							<tr>
								<td>Satuan</td>
								<td> : <input type='text' name='satuan' value='$data[satuan] 'size='20' maxlength='50'></td>
							<tr>
							<tr>
								<td colspan='2'><input type='submit' value='Update' />
												<input type='button' value='Batal' onclick=self.history.back()></td>
							</tr>
						</table>
					</form>";
					break;

					case "cari" :
							if(isset($_POST['cari'])){
								$cari = $_POST['cari'];
								$data = mysqli_query($conn, "select * from menu where jenis_menu like '%".$cari."%'");			
							}else{

								$data = mysqli_query($conn, "select * from menu");
							}
							$no=1;
?>
						<table class='list'>	
							<thead>
								<tr>	
									<td class='left'>No.</td>
									<td class='left'>Kode Menu</td>
									<td class='left'>Jenis Menu</td>
									<td class='left'>Kategori</td>
									<td class='left'>Satuan</td>
									<td class='left'>Edit</td>
									<td class='left'>Hapus</td>
								</tr>
							</thead>
						
<?php

							while($d = mysqli_fetch_array($data)){
								?>
								<tr>
									<td class='left' width='25'><?php echo "$no"; ?></td>
									<td class='left'><?php echo "$d[kode_menu]"; ?></td>
									<td class='left'><?php echo "$d[jenis_menu]";?></td>
									<td class='left'><?php echo "$d[kategori]";?></td>
									<td class='left'><?php echo "$d[satuan]";?></td>
									<td class='left'><?php echo "<a href='?module=menu&act=edit_menu&id=$d[kode_menu]'>";?><img src='images/btn_edit.png' width='20' height='20'></a></td>
									<td class='left'><?php echo "<a href='$aksi?module=menu&act=hapus&id=$d[kode_menu]'>";?><img src='images/btn_delete.png' width='20' height='20'></a></td>
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