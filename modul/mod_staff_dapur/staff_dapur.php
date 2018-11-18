<html>
<head>
	<script type="text/javascript">
		function validasi(form){
			if(form.id_staff.value == ""){
				alert("Data Harus Diisi Terlebih Dahulu")
				form.id_staff.focus();
				return(false);
			}
			return(true);
		}
	</script>
</head>	

<?php
	error_reporting(0);
	session_start();
	$aksi = "modul/mod_staff_dapur/aksi_staff_dapur.php";

	switch ($_GET['act']) {

		//Tampil Staff Dapur
		default:
		echo "<h2>Data Staff Dapur</h2>
		<input type=button value='Tambah Staff Dapur' onclick=\"window.location.href='?module=staff_dapur&act=tambah_staff_dapur';\">
		<div class='cari'>
			<form action='?module=staff_dapur&act=cari' method='post'>
				<label>Cari : </label>
				<input type='text' name='cari'>
				<input type='submit' value='Cari'>	
			</form>
		</div>";
?>
		<table class="list">
			<thead>
				<tr>
					<td class='left'>No.</td>
					<td class='left'>Id Staff</td>
					<td class='left'>Nama</td>
					<td class='left'>Alamat</td>
					<td class='left'>Jenis Kelamin</td>
					<td class='left'>Edit</td>
					<td class='left'>Hapus</td>
				</tr>
			</thead>
			<tbody>
				<?php
					$p = new Paging;
					$batas = 10;
					$posisi = $p->cariPosisi($batas);

					$tampil = mysqli_query($conn,"select * from staff_dapur order by id_staff LIMIT $posisi,$batas");
					$no = $posisi+1;
					while ($data=mysqli_fetch_array($tampil)) {
						echo "<tr>
								  <td class='left' width='25'>$no</td>
								  <td class='left'>$data[id_staff]</td>
								  <td class='left'>$data[nama]</td>
								  <td class='left'>$data[alamat]</td>
								  <td class='left'>$data[jenis_kelamin]</td>
								  <td class='left'><a href='?module=staff_dapur&act=edit_staff_dapur&id=$data[id_staff]'><img src='images/btn_edit.png' width='20' height='20'></a></td>
								  <td class='left'><a href='$aksi?module=staff_dapur&act=hapus&id=$data[id_staff]'><img src='images/btn_delete.png' width='20' height='20' /></a></td>
							  </tr>";
							$no++;
					}
					echo "</tbody></table>";

					$jmldata = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM staff_dapur"));
					$jmlhalaman = $p->jumlahHalaman($jmldata, $batas);
					$linkHalaman = $p->navHalaman($_GET[halaman],$jmlhalaman);

					echo "<div class=\"pagination\"> $linkHalaman</div>";
					break;

					case "tambah_staff_dapur":
					echo "<h2>Tambah Staff Dapur</h2><body OnLoad='document.isi.kode_menu.focus();'>
					<form method='post' name='isi' action='$aksi?module=staff_dapur&act=input' onSubmit='return validasi(this)'>
						<table class='list'>
							<tr>
								<td>Id Staff</td>
								<td> : <input type='text' name='id_staff' size='15' maxlength='15'></td>
							</tr>
							<tr>
								<td>Nama</td>
								<td> : <input type='text' name='nama' size='35' maxlength='100'></td>
							</tr>
							<tr>
								<td>Alamat</td>
								<td> &nbsp; <textarea name='alamat' cols='40' rows='3'></textarea></td>
							</tr>
							<tr>
								<td>Jenis Kelamin</td>
								<td> : <input type='radio' name='jenis_kelamin' value='laki'>Laki-Laki</input>
									   <input type='radio' name='jenis_kelamin' value='perempuan'>Perempuan</input>
								</td>
							<tr>
							<tr>
								<td colspan='2'><input type='submit' value='Simpan' />
												<input type='button' value='Batal' onclick=self.history.back()></td>
							</tr>
						</table>
					</form><body>";
					break;

					case "edit_staff_dapur":
					$edit = mysqli_query($conn, "select * from staff_dapur where id_staff='$_GET[id]'");
					$data = mysqli_fetch_array($edit);
					echo "<h2> Edit Onderdil </h2>
					<form method='post' action='$aksi?module=staff_dapur&act=update'>
					<input type='hidden' name='id' value='$data[id_staff]'>
						<table class='list'>
							<tr>
								<td>Id Staff</td>
								<td> : <input type='text' readonly value='$data[id_staff]' name='id_staff' size='15' maxlength='15'></td>
							</tr>
							<tr>
								<td>Nama</td>
								<td> : <input type='text' value='$data[nama]' name='nama' size='35' maxlength='100'></td>
							</tr>
							<tr>
								<td>Alamat</td>
								<td> &nbsp; <textarea value='$data[alamat]' name='alamat' cols='40' rows='3'></textarea></td>
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
								$data = mysqli_query($conn, "select * from staff_dapur where nama like '%".$cari."%'");			
							}else{

								$data = mysqli_query($conn, "select * from staff_dapur");
							}
							$no=1;
?>
						<table class="list">
							<thead>
								<tr>
									<td class='left'>No.</td>
									<td class='left'>Id Staff</td>
									<td class='left'>Nama</td>
									<td class='left'>Alamat</td>
									<td class='left'>Jenis Kelamin</td>
									<td class='left'>Edit</td>
									<td class='left'>Hapus</td>
								</tr>
							</thead>
						
<?php

							while($d = mysqli_fetch_array($data)){
								?>
								<tr>
									<td class='left' width='25'><?php echo "$no"; ?></td>
									<td class='left'><?php echo "$d[id_staff]"; ?></td>
									<td class='left'><?php echo "$d[nama]";?></td>
									<td class='left'><?php echo "$d[alamat]";?></td>
									<td class='left'><?php echo "$d[jenis_kelamin]";?></td>
									<td class='left'><?php echo "<a href='?module=staff_dapur&act=edit_staff_dapur&id=$d[id_staff]'>";?><img src='images/btn_edit.png' width='20' height='20'></a></td>
									<td class='left'><?php echo "<a href='$aksi?module=staff_dapur&act=hapus&id=$d[id_staff]'>";?><img src='images/btn_delete.png' width='20' height='20'></a></td>
								</tr>
							</table>
<?php
							}
									
						break;
				?>
			</tbody>
		</table>
<?php
	}
?>

</html>