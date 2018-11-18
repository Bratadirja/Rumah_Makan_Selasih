<?php
	include ('../../pdf/class.ezpdf.php');
	$pdf = new Cezpdf();

	$pdf->ezSetCmMargins(3, 3, 3, 3);
	$pdf->selectFont('../../pdf/fonts/Helvetica');

	$all = $pdf->openObject();

	$pdf->setStrokeColor(0, 0, 0, 1);
	$pdf->addJpegFromFile('logo.png',20, 800,69);

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
	$sql = mysqli_query($conn, "select * from bahan_makanan order by kode_bahan");
	$i=1;

	while ($r=mysqli_fetch_array($sql)) {
		$data[$i] = array('<b>No</b>'=>$i,
						  '<b>Kode Bahan</b>'=>$r['kode_bahan'],
						  '<b>Nama Bahan</b>'=>$r['nama_bahan'],
						  '<b>Jenis Bahan</b>'=>$r['jenis_bahan'],
						  '<b>Tanggal Produksi</b>'=>$r['tgl_produksi'],
						  '<b>Tanggal Kadaluarsa</b>'=>$r['tgl_kadaluarsa']);
		$i++;
	}

	$pdf->ezTable($data, '', '', '');
	$pdf->ezStartPageNumbers(320, 15, 8);
	$pdf->ezStream();

?>