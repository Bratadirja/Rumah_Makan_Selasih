<?php
	error_reporting(0);
	include "config/koneksi.php";
	include "config/library.php";
	include "config/library2.php";
	include "config/fungsi_indotgl.php";
	include "config/fungsi_combobox.php";
	include "config/class_paging.php";

	if($_GET['module']=='home'){
		if($_SESSION['leveluser']=='admin'){
			$jam=date("H:i:s");
			$tgl=tgl_indo(date("Y m d"));
			echo "<br><p align=center>Hai<b> $_SESSION[namalengkap]</b>, Anda Login Sebagai Admin.
			Silahkan klik menu pilihan yang berada dibagian header untuk mengelola Modul Aplikasi.<br><b>$hari_ini, $tgl, $jam</b> WIB</p><br>"; ?>
			<html>
				<table class="list">
					<thead>
						<td class='center' colspan=5>
							<center>
								Control Panel
							</center>
						</td>
					</thead>
					<tr>
						<td width=120 align=center>
							<?php
								echo"<a href=media.php?module=user><img src=images/user.jpg border=none><br><b>Data User</b></a>";
							?>
						</td>
						<td width=120 align=center>
							<?php
								echo"<a href=media.php?module=bahan_makanan><img src=images/bahan_makanan.jpg border=none><br><b>Data Bahan Makanan</b></a>";
							?>
						</td>
						<td width=120 align=center>
							<?php
								echo"<a href=media.php?module=makanan_minuman><img src=images/makanan_minuman.jpg boder=none><br><b>Data Makanan & Minuman</b></a>";
							?>
						</td>
						<td width=120 align=center>
							<?php
								echo"<a href=media.php?module=pelayan><img src=images/pelayan.jpg border=none><br><b>Data Pelayan</b></a>";
							?>
						</td>
						<td width=120 align=center>
							<?php
								echo"<a href=media.php?module=staff_dapur><img src=images/staff_dapur.jpg border=none><br><b>Data Staff Dapur</b></a>";
							?>
						</td>
					</tr>
					<tr>
						<td width=120 align=center>
							<?php
								/*echo"<a href=media.php?module=lap_cetak_struk><img src=images/struk.jpg border=none><br><b>Cetak Struk</b></a>";*/
							?>

							<?php
								echo"<a href='modul/mod_laporan_makanan_minuman/lap_makanan_minuman.php'><img src=images/lap_makanan_minuman.jpg border=none><br><b>Laporan Makanan Minuman</b></a>";
							?>
						</td>
						<td width=120 align=center>
							<?php
								echo"<a href='modul/mod_laporan_bahan_makanan/lap_bahan_makanan.php'><img src=images/lap_bahan_makanan.jpg border=none><br><b>Laporan Bahan Makanan</b></a>";
							?>
						</td>
						<td width=120 align=center>
							<?php
								echo"<a href='modul/mod_laporan_pelayan/lap_pelayan.php'><img src=images/lap_pelayan.png border=none><br><b>Laporan Data Pelayan</b></a>";
							?>
						</td>
						<td width=120 align=center>
							<?php
								echo"<a href='modul/mod_laporan_staff_dapur/lap_staff_dapur.php'><img src=images/lap_staff_dapur.jpg border=none><br><b>Laporan Data Staff Dapur</b></a>";
							?>
						</td>
						<td width=120 align=center>
							<?php
								echo"<a href='media.php?module=lap_transaksi_pemesanan'><img src=images/lap_nota_pesanan.jpg border=none><br><b>Laporan Transaksi</b></a>";
							?>
						</td>
					</tr>
				</table>
			</html>
			<?php

		}elseif($_SESSION['leveluser']=='kasir'){
			echo "<div class=home_kasir>
					<h2>Selamat Datang</h2>
				  	<p>Hai <b>$_SESSION[namalengkap]</b>, Anda Login sebagai kasir.<br>
				  	Silahkan klik menu pilihan yang berada di header untuk mengelola Modul Aplikasi.</p>
				  	<p>&nbsp;</p>";
				  

				  /*
				  <html>
				<table class='list'>
					<thead>
						<td class='center' colspan=5>
							<center>
								Control Panel
							</center>
						</td>
					</thead>
					<tr>
						<td width=120 align=center>
							<a href=media.php?module=user><img src=images/user.jpg border=none><br><b>Data User</b></a>
						</td>
						<td width=120 align=center>
							<a href=media.php?module=bahan_makanan><img src=images/bahan_makanan.jpg border=none><br><b>Data Bahan Makanan</b></a>
						</td>
						<td width=120 align=center>
							<a href=media.php?module=makanan_minuman><img src=images/makanan_minuman.jpg boder=none><br><b>Data Makanan & Minuman</b></a>				
						</td>
						<td width=120 align=center>
							<a href=media.php?module=pelayan><img src=images/pelayan.jpg border=none><br><b>Data Pelayan</b></a>
						</td>
						<td width=120 align=center>
							<a href=media.php?module=staff_dapur><img src=images/staff_dapur.jpg border=none><br><b>Data Staff Dapur</b></a>
						</td>
					</tr>
					<tr>
						<td width=120 align=center>
							<a href=media.php?module=lap_cetak_struk><img src=images/struk.jpg border=none><br><b>Cetak Struk</b></a>
						</td>
						<td width=120 align=center>
							<a href='modul/mod_laporan_bahan_makanan/lap_bahan_makanan.php'><img src=images/lap_bahan_makanan.jpg border=none><br><b>Laporan Bahan Makanan</b></a>
						</td>
						<td width=120 align=center>
							<a href='modul/mod_laporan_pelayan/lap_pelayan.php'><img src=images/lap_pelayan.png border=none><br><b>Laporan Data Pelayan</b></a>
						</td>
						<td width=120 align=center>
							<a href='modul/mod_laporan_staff_dapur/lap_staff_dapur.php'><img src=images/lap_staff_dapur.jpg border=none><br><b>Laporan Data Staff Dapur</b></a>
						</td>
						<td width=120 align=center>
							<a href='media.php?module=lap_transaksi_pemesanan'><img src=images/lap_nota_pesanan.jpg border=none><br><b>Laporan Transaksi</b></a>
						</td>
					</tr>
				</table>
			</html>*/
				echo "
				  <p align=right>Login : $hari_ini, ";
				  echo tgl_indo(date("Y m d"));
				  echo" | ";
				  echo date("H:i:s");
				  echo "WIB
				</div>";

		}elseif($_SESSION['leveluser']=='manager'){
			$jam=date("H:i:s");
			$tgl=tgl_indo(date("Y m d"));
			echo "<br><p align=center>Hai<b> $_SESSION[namalengkap]</b>, Anda Login Sebagai Manager.
			Silahkan klik menu pilihan yang berada dibagian header untuk mengelola Modul Aplikasi.<br><b>$hari_ini, $tgl, $jam</b> WIB</p><br>
				  
			<html>
				<table class='list'>
					<thead>
						<td class='center' colspan=5>
							<center>
								Control Panel
							</center>
						</td>
					</thead>
					<tr>
						<td width=120 align=center>
							<a href='modul/mod_laporan_makanan_minuman/lap_makanan_minuman.php'><img src=images/lap_makanan_minuman.jpg border=none><br><b>Laporan Makanan Minuman</b></a>
						</td>
						<td width=120 align=center>
							<a href='modul/mod_laporan_bahan_makanan/lap_bahan_makanan.php'><img src=images/lap_bahan_makanan.jpg border=none><br><b>Laporan Bahan Makanan</b></a>
						</td>
						<td width=120 align=center>
							<a href='modul/mod_laporan_pelayan/lap_pelayan.php'><img src=images/lap_pelayan.png border=none><br><b>Laporan Data Pelayan</b></a>
						</td>
						<td width=120 align=center>
							<a href='modul/mod_laporan_staff_dapur/lap_staff_dapur.php'><img src=images/lap_staff_dapur.jpg border=none><br><b>Laporan Data Staff Dapur</b></a>
						</td>
						<td width=120 align=center>
							<a href='media.php?module=lap_transaksi_pemesanan'><img src=images/lap_nota_pesanan.jpg border=none><br><b>Laporan Transaksi</b></a>
						</td>
					</tr>
				</table>
			</html>

				  <p align=right>Login : $hari_ini, ";
				  echo tgl_indo(date("Y m d"));
				  echo" | ";
				  echo date("H:i:s");
				  echo "WIB";



		}
	}

	//Bagian User
	elseif ($_GET['module']=='user') {
		if($_SESSION['leveluser']=='admin' OR $_SESSION['leveluser']=='kasir' OR $_SESSION['leveluser']=='manager'){
			include "modul/mod_user/user.php";
		}
	}

	//Bagian Bahan Makanan
	elseif ($_GET['module']=='bahan_makanan') {
		if($_SESSION['leveluser']=='admin'){
			include "modul/mod_bahan_makanan/bahan_makanan.php";
		}
	}

	//Bagian Bahan Menu
	elseif ($_GET['module']=='menu') {
		if($_SESSION['leveluser']=='admin'){
			include "modul/mod_menu/menu.php";
		}
	}

	//Bagian Makanan Minuman
	elseif ($_GET['module']=='makanan_minuman') {
		if($_SESSION['leveluser']=='admin'){
			include "modul/mod_makanan_minuman/makanan_minuman.php";
		}
	}

	//Bagian Pelayan
	elseif ($_GET['module']=='pelayan') {
		if($_SESSION['leveluser']=='admin'){
			include "modul/mod_pelayan/pelayan.php";
		}
	}

	//Bagian Staff Dapur
	elseif ($_GET['module']=='staff_dapur') {
		if($_SESSION['leveluser']=='admin'){
			include "modul/mod_staff_dapur/staff_dapur.php";
		}
	}

	//Bagian Transaksi
	elseif ($_GET['module']=='transaksi_pemesanan') {
		if($_SESSION['leveluser']=='admin' OR $_SESSION['leveluser']=='kasir'){
			include "modul/mod_transaksi_pemesanan/transaksi_pemesanan.php";
		}
	}

	//Bagian Pemasok
	elseif ($_GET['module']=='transaksi_pemasok') {
		if($_SESSION['leveluser']=='admin' OR $_SESSION['leveluser']=='kasir'){
			include "modul/mod_transaksi_pemasok/transaksi_pemasok.php";
		}
	}

	//Bagian Laporan Transaksi
	elseif($_GET['module']=='lap_transaksi_pemesanan'){
		if($_SESSION['leveluser']=='admin' OR $_SESSION[leveluser]=='kasir' OR $_SESSION[leveluser]=='manager'){
			include "modul/mod_laporan_transaksi_pemesanan/lap_transaksi_pemesanan.php";
		}
	}

	//Bagian Cetak Struk
	elseif($_GET['module']=='lap_cetak_struk'){
		if($_SESSION['leveluser']=='admin' OR $_SESSION[leveluser]=='kasir'){
			include "modul/mod_cetak_struk/lap_cetak_struk.php";
		}
	}

	elseif($_GET['module']=='logout'){
		if($_SESSION['leveluser']=='admin' OR $_SESSION[leveluser]=='kasir' OR $_SESSION[leveluser]=='manager'){
			include "modul/mod_logout/logout.php";
		}
	}

?>