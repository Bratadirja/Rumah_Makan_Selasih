<html>
<head>
	<script type="text/javascript">
		function validasi(form){
			if(form.id_pelayan.value == ""){
				alert("Data Harus Diisi Terlebih Dahulu")
				form.id_pelayan.focus();
				return(false);
			}
			return(true);
		}
	</script>
</head>	

<?php
error_reporting(0);
	session_start();
	$aksi = "modul/mod_pelayan/aksi_pelayan.php";

	switch ($_GET['act']) {
		//Tampil Palayan
		default:
		echo "<h2>Data Pelayan</h2>
		<input type=button value='Tambah Pelayan' onclick=\"window.location.href='?module=pelayan&act=tambah_pelayan';\">
		<div class='cari'>
			<form action='?module=pelayan&act=cari' method='post'>
				<label>Cari : </label>
				<input type='text' name='cari'>
				<input type='submit' value='Cari'>	
			</form>
		</div>";
?>
		<table class="list">
			<thead>
				<tr>
					<td class="left">No.</td>
					<td class="left">Id Pelayan</td>
					<td class="left">Nama</td>
					<td class="left">Jenis Kelamin</td>
					<td class="left">Edit</td>
					<td class="left">Hapus</td>
				</tr>
			</thead>
			<tbody>
				<?php
					$p = new Paging;
					$batas = 10;
					$posisi = $p->cariPosisi($batas);
					$tampil = mysqli_query($conn,"select * from pelayan order by id_pelayan LIMIT $posisi,$batas");
					$no = $posisi+1;

					while ($data=mysqli_fetch_array($tampil)) {
						echo "<tr>
								<td class='left' width='25'>$no</td>
								<td class='left'>$data[id_pelayan]</td>
								<td class='left'>$data[nama]</td>
								<td class='left'>$data[jenis_kelamin]</td>
								<td class='left'><a href='?module=pelayan&act=edit_pelayan&id=$data[id_pelayan]'><img src='images/btn_edit.png' width='20' height='20'></a></td>
								  <td class='left'><a href='$aksi?module=pelayan&act=hapus&id=$data[id_pelayan]'><img src='images/btn_delete.png' width='20' height='20' /></a></td>
							  </tr>";
							  $no++;
					}
					echo "</tr></table>";

					$jmldata = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM pelayan"));
					$jmlhalaman = $p->jumlahHalaman($jmldata, $batas);
					$linkHalaman = $p->navHalaman($_GET[halaman],$jmlhalaman);

					echo "<div class=\"pagination\">$linkHalaman<div>";
					break;

					case 'tambah_pelayan':
						echo "<h2>Tambah Pelayan</h2><body OnLoad='document.isi.kode_menu.focus();'>
						<form method='post' name='isi' action='$aksi?module=pelayan&act=input' onSubmit='return validasi(this)'>
							<table class='list'>
								<tr>
									<td>Id Pelayan</td>
									<td> : <input type='text' name='id_pelayan' size='15' maxlength='15'></td>
								</tr>
								<tr>
									<td>Nama</td>
									<td> : <input type='text' name='nama' size='35' maxlength='100'></td>
								</tr>
								<tr>
									<td>Jenis Kelamin</td>
									<td> : <input type='radio' name='jenis_kelamin' value='laki'>Laki-Laki</input>
										   <input type='radio' name='jenis_kelamin' value='perempuan'>Perempuan</input>
									</td>
								</tr>
								<tr>
									<td colspan='2'><input type='submit' value='Simpan' />
													<input type='button' value='Batal' onclick=self.history.back()></td>
								</tr>
							</table>
						</form></body>";
					break;

					case "edit_pelayan":
						$edit = mysqli_query($conn, "select * from pelayan where id_pelayan='$_GET[id]'");
						$data = mysqli_fetch_array($edit);
						echo "<h2> Edit Pelayan </h2>
						<form method='post' action='$aksi?module=pelayan&act=update'>
						<input type='hidden' name='id' value='$data[id_pelayan]'>
							<table class='list'>
								<tr>
									<td>Id Pelayan</td>
									<td> : <input type='text' readonly name='id_pelayan' value='$data[id_pelayan]' size='15' maxlength='15'></td>
								</tr>
								<tr>
									<td>Nama</td>
									<td> : <input type='text' name='nama' value='$data[nama]' size='35' maxlength='100'></td>
								</tr>
								<tr>
									<td>Jenis Kelamin</td>
									<td> : <input type='radio' name='jenis_kelamin' value='laki'>Laki-Laki</input>
										    <input type='radio' name='jenis_kelamin' value='perempuan'>Perempuan</input>
									</td>
								</tr>
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
								$data = mysqli_query($conn, "select * from pelayan where nama like '%".$cari."%'");			
							}else{

								$data = mysqli_query($conn, "select * from pelayan");
							}
							$no=1;
?>
						<table class="list">
							<thead>
								<tr>
									<td class="left">No.</td>
									<td class="left">Id Pelayan</td>
									<td class="left">Nama</td>
									<td class="left">Jenis Kelamin</td>
									<td class="left">Edit</td>
									<td class="left">Hapus</td>
								</tr>
							</thead>
						
<?php

							while($d = mysqli_fetch_array($data)){
								?>
								<tr>
									<td class='left' width='25'><?php echo "$no"; ?></td>
									<td class='left'><?php echo "$d[id_pelayan]"; ?></td>
									<td class='left'><?php echo "$d[nama]";?></td>
									<td class='left'><?php echo "$d[jenis_kelamin]";?></td>
									<td class='left'><?php echo "<a href='?module=pelayan&act=edit_pelayan&id=$d[id_pelayan]'>";?><img src='images/btn_edit.png' width='20' height='20'></a></td>
									<td class='left'><?php echo "<a href='$aksi?module=pelayan&act=hapus&id=$d[id_pelayan]'>";?><img src='images/btn_delete.png' width='20' height='20'></a></td><?php
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