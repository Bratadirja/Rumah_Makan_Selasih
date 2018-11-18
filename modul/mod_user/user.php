<?php
	error_reporting(0);
	session_start();
	$aksi = "modul/mod_user/aksi_user.php";

	switch ($_GET['act']) {
		
		//Tampil User
		default:

			if($_SESSION['leveluser']=='admin'){
				$tampil = mysqli_query($conn, "SELECT * FROM user ORDER BY user_id");
				echo "<h2>Data User</h2>
				<input type=button value='Tambah User' onclick=\"window.location.href='?module=user&act=tambahuser';\">
				<div class='cari'>
				<form action='?module=user&act=cari' method='post'>
					<label>Cari : </label>
					<input type='text' name='cari'>
					<input type='submit' value='Cari'>	
				</form>
			</div>"; 

			}elseif ($_SESSION['leveluser']=='manager') {
				$tampil = mysqli_query($conn, "SELECT * FROM user WHERE user_id='$_SESSION[namauser]'");
				echo "<h2>Data User</h2>";

			}else{
				$tampil = mysqli_query($conn, "SELECT * FROM user WHERE user_id='$_SESSION[namauser]'");
				echo "<h2>Data User</h2>";
			}

echo "<table class='list'>
		<thead>
			<tr>
				<td class='left'>No.</td>
				<td class='left'>User ID</td>
				<td class='left'>Nama Lengkap</td>
				<td class='left'>Alamat</td>
				<td class='left'>Jenis Kelamin</td>
				<td class='left'>level</td>
				<td class='left'>Edit</td>";

				if($_SESSION['leveluser']=='admin'){

					echo "<td class='left'>Hapus</td>";

				}
			echo"</tr>
		</thead>
		<tbody>";

		$no=1;
		while($data = mysqli_fetch_array($tampil)){
			echo"<tr>
					<td class='left' width='25'>$no</td>
					<td class='left'>$data[user_id]</td>
					<td class='left'>$data[nama]</td>
					<td class='left'>$data[alamat]</td>
					<td class='left'>$data[jenis_kelamin]</td>
					<td class='left'>$data[level]</td>
					<td class='left'>
						<a href='?module=user&act=edituser&id=$data[user_id]'><img src='images/btn_edit.png' width='20' height='20'></a>
					</td>";

					if($_SESSION['leveluser']=='admin'){
						echo "<td class='left'>
								<a href='$aksi?module=user&act=hapus&id=$data[user_id]'><img src='images/btn_delete.png' width='20' height='20'></a>
							</td>";
					}

			echo"</tr>";

			$no++;
		}
			
		echo "</tbody></table>";
		break;
			
		case 'tambahuser':
			if($_SESSION['leveluser']=='admin'){
?>
				<html>
					<h2> Tambah User</h2>
<?php
					echo"<form method='post' action='$aksi?module=user&act=input'>";
?>
							<table class="list"> 
								<tr>
									<td>User ID</td>
									<td> : <input type="text" name="user_id" size="20" maxlength="20"></td>
								</tr>
								<tr>
									<td>Password</td>
									<td> : <input type="Password" name="password" size="35" maxlength="50"></td>
								</tr>
								<tr>
									<td>Nama Lengkap</td>
									<td> : <input type="text" name="nama" size="40" maxlength="50"></td>
								</tr>
								<tr>
									<td>Alamat</td>
									<td> &nbsp;<textarea name="alamat" rows="3" cols="40"></textarea></td>
								</tr>
								<tr>
									<td>Jenis Kelamin</td>
									<td> : <input type="radio" name="jenis_kelamin" value="laki">Laki-Laki</input>&nbsp;&nbsp;
										   <input type="radio" name="jenis_kelamin" value="perempuan">Perempuan</input>
									</td>
								</tr>
								<tr>
									<td>Level</td>
									<td> : <select name="level">
												<option value="admin">Admin</option>
												<option value="kasir">Kasir</option>
												<option value="manager">Manager</option>

										   </select>
									</td>
								</tr>
								<tr>
									<td colspan="2">
										<input type="submit" name="submit" value="Simpan">
										<input type="button" value="batal" onclick=self.history.back()>
									</td>
								</tr>
							</table>
						</form>
					</html>
<?php
				}else{

					echo "Anda Tidak Berhak Mengakses Halaman Ini";
				}
			break;

			case 'edituser':
				$edit = mysqli_query($conn, "SELECT * FROM user WHERE  user_id='$_GET[id]'");
				$data = mysqli_fetch_array($edit);

				echo "<h2>Edit User</h2>
				<form method='post' action='$aksi?module=user&act=update'>
					<input type='hidden' name='id' value='$data[user_id]'>
					<table>
						<tr>
							<td>User ID</td>
							<td> : <input type='text' name='user_id' size='20' value='$data[user_id]'></td>
						</tr>
						<tr>
							<td>Password</td>
							<td> : <input type='password' name='password' size='35' maxlength='50'></td>
						</tr>
						<tr>
							<td>Nama Lengkap</td>
							<td> : <input name='nama' size='40' maxlength='100' value='$data[nama]'></td>
						</tr>
						<tr>
							<td>Alamat</td>
							<td> : <textarea name='alamat' cols='40' rows='3' value='$data[alamat]'></textarea>
						</tr>
						<tr>
							<td>Jenis Kelamin</td>
							<td> : <input type='radio' name='jenis_kelamin' value='laki'>Laki-Laki</input>
								   <input type='radio' name='jenis_kelamin' value='perempuan'>Perempuan</input>
							</td>
 						</tr>";

 						if($_SESSION['leveluser']=='admin'){
 							echo "
 							<tr>
 								<td>Level</td>
 								<td> : <select name='level'>";
 								if($data['level']=='admin'){

 									echo "<option value='admin' selected>Admin</option>
 										  <option value='kasir'>Kasir</option>
 										  <option value='manager'>Manager</option>";

 								}elseif($data['level']=='kasir'){

 									echo "<option value='admin'>Admin</option>
 										  <option value='kasir' selected>Kasir</option>
 										  <option value='manager'>Manager</option>";

 								}elseif($data['level']=='manager'){

 									echo "<option value='admin'>Admin</option>
 										  <option value='kasir'>Kasir</option>
 										  <option value='manager' selected>Manager</option>";

 								}
 								echo"</select></td>
 							</tr>";

 						}else{
 							echo "
 							<tr>
 								<td>Level</td>
 								<td> : <select name='level'>
 											<option value='kasir'>Kasir</option>
 									      </select>
 								 </td>
 							</tr>
 							<tr>
 								<td>Level</td>
 								<td> : <select name='level'>
 											<option value='manager'>Manager</option>
 									   </select>
 								 </td>
 							</tr>";		
 						}
 						echo "
 						<tr>
 							<td colspan='2'>
 								<input type='submit' name='submit' value='Update'>
 								</input>
 								<input type='button' value='Batal'
											onclick=self.history.back()>
 							</td>
 						</tr>
					</table>
				</form>";
			break;

			case 'cari':
				if(isset($_POST['cari'])){
								$cari = $_POST['cari'];
								$data = mysqli_query($conn, "select * from user where level like '%".$cari."%' OR nama like '%".$cari."%'");			
							}else{

								$data = mysqli_query($conn, "select * from user");
							}
							$no=1;
?>
						<table class="list">
							<thead>
								<tr>
									<td class="left">No.</td>
									<td class="left">User ID
									</td>
									<td class="left">Nama Lengkap</td>
									<td class="left">Alamat</td>
									<td class="left">Jenis Kelamin</td>
									<td class="left">Level</td>
									<td class="left">Edit</td>
									<td class="lef">Hapus</td>
								</tr>
							</thead>
						
<?php

							while($d = mysqli_fetch_array($data)){
								?>
								<tr>
									<td class='left' width='25'><?php echo "$no"; ?></td>
									<td class='left'><?php echo "$d[user_id]"; ?></td>
									<td class='left'><?php echo "$d[nama]";?></td>
									<td class='left'><?php echo "$d[alamat]";?></td>
									<td class='left'><?php echo "$d[jenis_kelamin]";?></td>
									<td class='left'><?php echo "$d[level]";?></td>
									<td class='left'><?php echo "<a href='?module=bahan_makanan&act=edituser&id=$d[user_id]'>";?><img src='images/btn_edit.png' width='20' height='20'></a></td>
									<td class='left'><?php echo "<a href='$aksi?module=bahan_makanan&act=hapus&id=$d[user_id]'>";?><img src='images/btn_delete.png' width='20' height='20'></a></td>
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