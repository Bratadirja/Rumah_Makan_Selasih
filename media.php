<?php
	session_start();
	include "config/koneksi.php";
	

	if(empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
		echo"<link href='css/style.css' rel=stylesheet type='text/css'>
		<center>Untuk mengakses modul, Anda harus login <br>";
		echo"<a href=index.php><b>LOGIN</b></a></center>";

	}else{

		if($_SESSION['leveluser']=='admin'){
	echo"
		<html>
			<head>
				<title>Sistem RM Selasih</title>
				<link href='css/style.css' rel='stylesheet' type='text/css'>
				<script src='js/jquery-1.8.0.min.js' type='text/javascript'></script>
				<link type='text/css' rel='stylesheet' href='js/dhtmlgoodies_calendar/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css' media='screen'>
				<script type='text/javascript' src='js/dhtmlgoodies_calendar/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js'></script>
				<script src='js/jquery.autocomplate.js' type='text/javascript'></script>
			</head>
			<body>
				<div class='header'>
					<div class='menu'>
						<div class='left'>
							<ul>
								<li><a href='media.php?module=home'>Home</a></li>
								<li><a href='media.php?module=user'>User</a></li>
								<li><a href='#'>Pengolahan Data Master</a>
									<ul>
										<li><a href='media.php?module=bahan_makanan'> Data Bahan Makanan</a></li>
										<li><a href='media.php?module=menu'>  Data Menu</a></li>
										<li><a href='media.php?module=makanan_minuman'> Data Makanan Minuman</a></li>
										<li><a href='media.php?module=pelayan'> Data Pelayan</a></li>
										<li><a href='media.php?module=staff_dapur'> Data Staff Dapur</a></li>
									</ul>
								</li>
								<li><a href='#'>Data Laporan</a>
									<ul>
										<li><a href='modul/mod_laporan_bahan_makanan/lap_bahan_makanan.php'>Laporan Bahan Makanan</a></li>
										<li><a href='modul/mod_laporan_makanan_minuman/lap_makanan_minuman.php'>Laporan Makanan Makanan</a></li>
										<li><a href='modul/mod_laporan_pelayan/lap_pelayan.php'>Laporan Data Pelayan</a></li>
										<li><a href='modul/mod_laporan_staff_dapur/lap_staff_dapur.php'>Laporan Data Staff Dapur</a></li>
										<li><a href='media.php?module=lap_transaksi_pemesanan'>Laporan Transaksi</a></li>
									</ul>
								</li>
								<li><a href='media.php?module=logout'>Logout</a></li>
							<ul>	
						</div>
					</div>
				</div>
				<div class='wrap'>
					<div class='content'>";
						 include 'content.php'; 
				echo "
					</div>
					<div class='footer'>
						Copyright &copy; 2018 Deleveloped by Andika Bratadirja.All rights reserved.
					</div>
				</div>";				

			}

			if($_SESSION['leveluser']=='kasir'){
				echo"
				<head>
					<title>Sistem RM Selasih</title>
					<link href='css/style.css' rel='stylesheet' type='text/css'>
					<script src='js/jquery-1.8.0.min.js' type='text/javascript'></script>
					<link type='text/css' rel='stylesheet' href='js/dhtmlgoodies_calendar/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css' media='screen'>
					<script type='text/javascript' src='js/dhtmlgoodies_calendar/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js'></script>
					<script src='js/jquery.autocomplate.js' type='text/javascript'></script>
				</head>
				<body>
				<div class='header'>
					<div class='menu'>
						<div class='left'>
							<ul>
								<li><a href='media.php?module=home'>Home</a></li>
								<li><a href='#''>Pengolahan Transaksi</a>
									<ul>
										<li><a href='media.php?module=transaksi_pemesanan'>Transaksi Pemesanan</a></li>
										<li><a href='media.php?module=transaksi_pemasok'>Transaksi Pemasok</a></li>
									</ul>
								</li>
								<li><a href='media.php?module=logout'>Logout</a></li>
							</ul>
						</div>
					</div>
				</div>
				<div class='wrap'>
					<div class='content'>";
					 	include 'content.php'; 
				echo"
					</div>
					<div class='footer'>
						Copyright &copy; 2018 Deleveloped by Andika Bratadirja.All rights reserved.
					</div>
				</div>";
		}

		if($_SESSION['leveluser']=='manager'){
				echo"
				<head>
					<title>Sistem RM Selasih</title>
					<link href='css/style.css' rel='stylesheet' type='text/css'>
					<script src='js/jquery-1.8.0.min.js' type='text/javascript'></script>
					<link type='text/css' rel='stylesheet' href='js/dhtmlgoodies_calendar/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css' media='screen'>
					<script type='text/javascript' src='js/dhtmlgoodies_calendar/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js'></script>
					<script src='js/jquery.autocomplate.js' type='text/javascript'></script>
				</head>
				<body>
				<div class='header'>
					<div class='menu'>
						<div class='left'>
							<ul>
								<li><a href='media.php?module=home'>Home</a></li>
								<li><a href='#'>Data Laporan</a>
									<ul>
										<li><a href='modul/mod_laporan_bahan_makanan/lap_bahan_makanan.php'>Laporan Bahan Makanan</a></li>
										<li><a href='modul/mod_laporan_makanan_minuman/lap_makanan_minuman.php'>Laporan Makanan Makanan</a></li>
										<li><a href='modul/mod_laporan_pelayan/lap_pelayan.php'>Laporan Data Pelayan</a></li>
										<li><a href='modul/mod_laporan_staff_dapur/lap_staff_dapur.php'>Laporan Data Staff Dapur</a></li>
										<li><a href='media.php?module=lap_transaksi_pemesanan'>Laporan Transaksi</a></li>
									</ul>
								</li>
								<li><a href='media.php?module=logout'>Logout</a></li>
							</ul>
						</div>
					</div>
				</div>
				<div class='wrap'>
					<div class='content'>";
					 	include 'content.php'; 
				echo"
					</div>
					<div class='footer'>
						Copyright &copy; 2018 Deleveloped by Andika Bratadirja.All rights reserved.
					</div>
				</div>
			</body>
		</html>";
		}
	}
?>