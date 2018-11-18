<?php
	include ('../../pdf/class.ezpdf.php');
	$pdf = new Cezpdf();

	$pdf->ezSetCmMargins(3, 3, 3, 3);
	$pdf->selectFont('../../pdf/fonts/Helvetica');

	$all = $pdf->openObject();

	$pdf->setStrokeColor(0, 0, 0, 1);
	$images = "<img src=../../images/logo.png>";
	$pdf->addJpegFromFile($images,20, 800,69);

	$pdf->addText(195, 820, 14,'<b>LAPORAN DATA BAHAN MAKANAN</b>');
	$pdf->addText(160, 800, 14,'<b>                RUMAH MAKAN SELASIH</b>');
	$pdf->line(10, 795, 578, 795);

	//Garis Bawah Untuk Footer
	$pdf->line(10, 50, 578, 50);

	//Teks Kiri Bawah
	$pdf->addText(30, 34, 8,'Dicetak tgl:'. date('d-m-Y, H:i:s'));

	$pdf->closeObject();

	//Tampil Object di semua Halaman
	$pdf->addObject($all, 'all');

	include "../../config/koneksi.php";
	include "../../config/library2.php";

	$sql = mysqli_query($conn, "select * from makanan_minuman order by id_list");
	$i=1;

	while ($r=mysqli_fetch_array($sql)) {
		$data[$i] = array('<b>No</b>'=>$i,
						  '<b>Id List</b>'=>$r['id_list'],
						  '<b>Nama Menu</b>'=>$r['nama_menu'],
						  '<b>Jumlah</b>'=>$r['jumlah'],
						  '<b>Harga (Rp)</b>'=>format_rupiah($r['harga']));
		$i++;
	}

	$pdf->ezTable($data, '', '', '');
	$pdf->ezStartPageNumbers(320, 15, 8);
	$pdf->ezStream();
?>