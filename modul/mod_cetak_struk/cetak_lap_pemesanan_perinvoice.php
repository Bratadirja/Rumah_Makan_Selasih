<?php

	include ('../../pdf/class.ezpdf.php');
	include "../../config/library.php";
	include "../../config/library2.php";
	include "../../config/fungsi_indotgl.php";
	$pdf = new Cezpdf();

	$pdf->ezSetCmMargins(3, 3, 3, 3);
	$pdf->selectFont('../../pdf/fonts/Helvetica');

	$all = $pdf->openObject();

	$pdf->setStrokeColor(0, 0, 0, 1);
	$pdf->addJpegFromFile('logo.png',20, 800,69);

	$pdf->addText(195, 820, 14,'<b>CETAK STRUK PEMBAYARAN</b>');
	$pdf->line(10, 795, 578, 795);

	//Garis Bawah Untuk Footer
	$pdf->line(10, 50, 578, 50);

	//Teks Kiri Bawah
	$pdf->addText(30, 34, 8,'Dicetak tgl:'. date('d-m-Y, H:i:s'));

	$pdf->closeObject();

	//Tampil Object di semua Halaman
	$pdf->addObject($all, 'all');

	include "../../config/koneksi.php";
	$sql = mysqli_query($conn, "select * from transaksi_pemesanan_item where no_transaksi='$_GET[no_nota]'");
	$i=1;
	$a=0;

	while ($r=mysqli_fetch_array($sql)) {
			$Id_Pembeli = $r['id_pembeli'];
			$Nama_Menu = $r['nama_menu'];
			$Harga = $r['harga'];
			$Jumlah = $r['jumlah'];
			$Harga_rp = format_rupiah($r['harga']);
			$Subtotal = $r['jumlah'] * $Harga;
			$Subtotal_rp = format_rupiah($Subtotal);
			$Jumlah_Barang = $Jumlah_Barang + $rtemp['jumlah'];
			$Total = $Total + $Subtotal;
			$Total_rp = format_rupiah($Total);


		$data[$i] = array('<b>No</b>'=>$i,
						  '<b>Id Pembeli</b>'=>$r['id_pembeli'],
						  '<b>Nama Menu</b>'=>$r['nama_menu'],
						  '<b>Harga</b>'=>$r['harga'],
						  '<b>Qty</b>'=>$r['jumlah'],
						  '<b>Subtotal</b>'=>$r['jumlah']*$r['harga']
						  );
		$i++;

		$data1[$a] = array('<b>Total Pembayaran</b>'=>$Total);
		
	}

	$pdf->ezTable($data, '', '', '');
	$pdf->ezTable($data1, '', 'Total Pembayaran', '');
	$pdf->ezStartPageNumbers(320, 15, 8);
	$pdf->ezStream();

?>