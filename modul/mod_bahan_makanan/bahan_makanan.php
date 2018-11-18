<html>
<head>
	<script type="text/javascript">
		function validasi(form){
			if(form.kode_bahan.value == ""){
				alert("Data Harus Diisi Terlebih Dahulu")
				form.kode_bahan.focus();
				return(false);
			}
			return(true);
		}
	</script>
</head>	


<?php
	error_reporting(0);
	$aksi = "modul/mod_bahan_makanan/aksi_bahan_makanan.php";

	switch ($_GET['act']) {

		default:
			echo"<h2>Data Bahan Makanan</h2>
			<input type=button value='Tambah Bahan Makanan' onclick=\"window.location.href='?module=bahan_makanan&act=tambah_bahan_makanan';\">
			<div class='cari'>
				<form action='?module=bahan_makanan&act=cari' method='post'>
					<label>Cari : </label>
					<input type='text' name='cari'>
					<input type='submit' value='Cari'>	
				</form>
			</div>";

?>
			<table class=list>
				<thead>
					<tr>
						<td class="left">No.</td>
						<td class="left">Kode Bahan Makanan
						</td>
						<td class="left">Nama Bahan Makanan</td>
						<td class="left">Jenis Bahan</td>
						<td class="left">Tanggal Produksi</td>
						<td class="left">Tanggal Kadarluarsa</td>
						<td class="left">Edit</td>
						<td class="lef">Hapus</td>
					</tr>
				</thead>
				<tbody>
					<?php
						$p = new Paging;
						$batas = 10;
						$posisi = $p->cariPosisi($batas); 
						$tampil = mysqli_query($conn,"SELECT * FROM bahan_makanan ORDER BY kode_bahan LIMIT $posisi,$batas");
						$no = $posisi+1;

						while($data=mysqli_fetch_array($tampil)){
							echo "<tr>
									<td class='left' width='25'>$no</td>
									<td class='left'>$data[kode_bahan]</td>
									<td class='left'>$data[nama_bahan]</td>
									<td class='left'>$data[jenis_bahan]</td>
									<td class='left'>$data[tgl_produksi]</td>
									<td class='left'>$data[tgl_kadaluarsa]</td>
									<td class='left'><a href='?module=bahan_makanan&act=edit_bahan_makanan&id=$data[kode_bahan]'><img src='images/btn_edit.png' width='20' height='20'></a></td>
									<td class='left'><a href='$aksi?module=bahan_makanan&act=hapus&id=$data[kode_bahan]'><img src='images/btn_delete.png' width='20' height='20'></a></td>
								  </tr>";
								 $no++;
						}
						echo "</tbody></table>";
						$jmldata = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM bahan_makanan"));
						$jmlhalaman = $p->jumlahHalaman($jmldata, $batas);
						$linkHalaman = $p->navHalaman($_GET[halaman], $jmlhalaman);
						echo "<div class=\"pagination\">$linkHalaman</div>";
						break;

						case "tambah_bahan_makanan":
							$tglProduksi = isset($_POST['tgl_produksi']) ? $_POST['tgl_produksi'] : date('d-m-Y');
							$tglKadaluarsa = isset($_POST['tgl_kadaluarsa']) ? $_POST['tgl_kadaluarsa'] : date('d-m-Y');
							echo "<h2>Tambah Bahan Makanan</h2><body OnLoad='document.isi.kode_bahan.focus();'>
							<form method='post' name='isi' action='$aksi?module=bahan_makanan&act=input' onSubmit='return validasi(this)'>
								<table class='list'>
									<tr>
										<td>Kode Bahan Makanan</td>
										<td> : <input type='text' name='kode_bahan' size='15' maxlength='15'></td>
									</tr>
									<tr>
										<td>Nama Bahan Makanan</td>
										<td> : <input type='text' name='nama_bahan' size='35' maxlength='100'></td>
									</tr>
									<tr>
										<td>Jenis Bahan Makanan</td>
										<td> : <input type='text' name='jenis_bahan' size='35' maxlength='35'></td>
									</tr>
									<tr>
										<td>Tanggal Produksi</td>
										<td> : "; echo form_tanggal("tgl_produksi",$tglProduksi); echo"</td>
									</tr>
									<tr>
										<td>Tanggal Kadarluarsa</td>
										<td> : "; echo form_tanggal("tgl_kadaluarsa",$tglKadaluarsa); echo"</td>
									</tr>
									<tr>
										<td colspan='2'>
											<input type='submit' value='Simpan'>
											<input type='button' value='Batal' onclick=self.history.back()></td>
										</td>
									</tr>
								</table>
							</form></body>";	
						break;

						case "edit_bahan_makanan":
							$edit = mysqli_query($conn,"select * from bahan_makanan where kode_bahan='$_GET[id]'");
							$data = mysqli_fetch_array($edit);
							$tglProduksi = isset($_POST['tgl_produksi']) ? $data[tgl_produksi] : date('d-m-Y');
							$tglKadaluarsa = isset($_POST['tgl_kadaluarsa']) ? $data[tgl_kadaluarsa] : date('d-m-Y');
							echo "<h2> Edit Onderdil</h2>
							<form method='post' action='$aksi?module=bahan_makanan&act=update'>
								<input type='hidden' name='id' value='$data[kode_bahan]'>
								<table class='list'>
									<tr>
										<td>Kode Bahan Makanan</td>
										<td> : <input type='text' value='$data[kode_bahan]' name='kode_bahan'  size='15' maxlength='15'></td>
									</tr>
									<tr>
										<td>Nama Bahan Makanan</td>
										<td> : <input type='text' value='$data[nama_bahan]' name='nama_bahan' size='35' maxlength='100'></td>
									</tr>
									<tr>
										<td>Jenis Bahan Makanan</td>
										<td> : <input type='text' value='$data[jenis_bahan]' name='jenis_bahan' size='35' maxlength='35'></td>
									</tr>	
									<tr>
										<td>Tanggal Produksi</td>
										<td> : "; echo form_tanggal("tgl_produksi",$tglProduksi); echo"</td>
									</tr>
									<tr>
										<td>Tanggal Kadarluarsa</td>
										<td> : "; echo form_tanggal("tgl_kadaluarsa",$tglKadaluarsa); echo"</td>
									</tr>
									<tr>
										<td colspan='2'>
											<input type='submit' value='Update'>
											<input type='button' value='Batal'
											onclick=self.history.back()>
										</td>
									</tr>
								</table>
							</form>
							";
						break;

						case "cari" :
							if(isset($_POST['cari'])){
								$cari = $_POST['cari'];
								$data = mysqli_query($conn, "select * from bahan_makanan where nama_bahan like '%".$cari."%' OR jenis_bahan like '%".$cari."%'");			
							}else{

								$data = mysqli_query($conn, "select * from bahan_makanan");
							}
							$no=1;
?>
						<table class="list">
							<thead>
								<tr>
									<td class="left">No.</td>
									<td class="left">Kode Bahan Makanan
									</td>
									<td class="left">Nama Bahan Makanan</td>
									<td class="left">Jenis Bahan</td>
									<td class="left">Tanggal Produksi</td>
									<td class="left">Tanggal Kadarluarsa</td>
									<td class="left">Edit</td>
									<td class="lef">Hapus</td>
								</tr>
							</thead>
						
<?php

							while($d = mysqli_fetch_array($data)){
								?>
								<tr>
									<td class='left' width='25'><?php echo "$no"; ?></td>
									<td class='left'><?php echo "$d[kode_bahan]"; ?></td>
									<td class='left'><?php echo "$d[nama_bahan]";?></td>
									<td class='left'><?php echo "$d[jenis_bahan]";?></td>
									<td class='left'><?php echo "$d[tgl_produksi]";?></td>
									<td class='left'><?php echo "$d[tgl_kadaluarsa]";?></td>
									<td class='left'><?php echo "<a href='?module=bahan_makanan&act=edit_bahan_makanan&id=$d[kode_bahan]'>";?><img src='images/btn_edit.png' width='20' height='20'></a></td>
									<td class='left'><?php echo "<a href='$aksi?module=bahan_makanan&act=hapus&id=$d[kode_bahan]'>";?><img src='images/btn_delete.png' width='20' height='20'></a></td>
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