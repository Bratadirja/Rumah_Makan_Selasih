drop database if exists dbrumah_makan;

Create database dbrumah_makan;

use dbrumah_makan;

Create table user(
	user_id varchar(10) not null,
	password varchar(100) not null,
	nama varchar(100) not null,
	alamat varchar(100),
	jenis_kelamin varchar(10),
	level enum('kasir','admin') not null default 'kasir',
	primary key(user_id)
)
ENGINE=Innodb default CHARSET=latin1;

Create table pelayan(
	id_pelayan varchar(10) not null,
	nama varchar(100) not null,
	jenis_kelamin varchar(10),
	primary key(id_pelayan)
)
ENGINE=Innodb default CHARSET=latin1;

Create table pembeli(
	id_pembeli varchar(10) not null,
	nama varchar(100) not null,
	alamat varchar(100),
	primary key(id_pembeli)
)
ENGINE=Innodb default CHARSET=latin1;

Create table struk(
	id_struk varchar(10) not null,
	nomor_transaksi varchar(50) not null,
	jmlh_transaksi int(3),
	tgl_transaksi datetime(6),
	primary key(id_struk)
)
ENGINE=Innodb default CHARSET=latin1;
 
Create table retail_dibayar(
	id_struk varchar(10) not null,
	id_pembeli varchar(10) not null,
	tgl_pembayaran datetime(6),
	foreign key(id_struk) references struk(id_struk),
	foreign key(id_pembeli) references pembeli(id_pembeli)
)
ENGINE=Innodb default CHARSET=latin1;

Create table nota_pesanan(
	id_pesanan varchar(10) not null,
	user_id varchar(10) not null,
	jmlh_pesanan int(10) not null,
	tgl_pesanan datetime(6),
	total int(10),
	primary key(id_pesanan),
	foreign key(user_id) references user(user_id)
)
ENGINE=Innodb default CHARSET=latin1;

Create table retail_melayani(
	id_pelayan varchar(10) not null,
	id_pembeli varchar(10) not null,
	foreign key(id_pelayan) references pelayan(id_pelayan),
	foreign key(id_pembeli) references pembeli(id_pembeli)
)
ENGINE=Innodb default CHARSET=latin1;

Create table retail_mendapat(
	id_pembeli varchar(10) not null,
	id_pesanan varchar(10) not null,
	foreign key(id_pembeli) references pembeli(id_pembeli),
	foreign key(id_pesanan) references nota_pesanan(id_pesanan)
)
ENGINE=Innodb default CHARSET=latin1;

Create table menu(
	kode_menu varchar(10) not null,
	id_pesanan varchar(10) null,
	jenis_menu varchar(10),
	kategori varchar(10),
	satuan varchar(10),
	primary key(kode_menu),
	foreign key (id_pesanan) references nota_pesanan(id_pesanan)
)
ENGINE=Innodb default CHARSET=latin1;

Create table makanan_minuman(
	id_list varchar(10) not null,
	nama_menu varchar(100),
	jumlah int(3),
	harga int(10) not null,
	primary key(id_list)
)
ENGINE=Innodb default CHARSET=latin1;

Create table retail_berisi(
	kode_menu varchar(10) not null,
	id_list varchar(10) not null,
	foreign key(kode_menu) references menu(kode_menu),
	foreign key(id_list) references makanan_minuman(id_list)
)
ENGINE=Innodb default CHARSET=latin1;

Create table manager(
	id_manager varchar(10) not null,
	nama varchar(100),
	alamat varchar(100),
	primary key(id_manager)
)
ENGINE=Innodb default CHARSET=latin1;

Create table bahan_makanan(
	kode_bahan varchar(10) not null,
	id_manager varchar(10) null,
	nama_bahan varchar(100) not null,
	jenis_bahan varchar(50),
	tgl_produksi date,
	tgl_kadaluarsa date,
	primary key(kode_bahan),
	foreign key(id_manager) references manager(id_manager)
)
ENGINE=Innodb default CHARSET=latin1;

Create table retail_terdapat(
	id_list varchar(10) not null,
	kode_bahan varchar(10) not null,
	foreign key(id_list) references makanan_minuman(id_list),
	foreign key(kode_bahan) references bahan_makanan(kode_bahan)
)
ENGINE=Innodb default CHARSET=latin1;

Create table pemasok(
	id_pemasok varchar(10) not null,
	nama varchar(100),
	primary key(id_pemasok)
)
ENGINE=Innodb default CHARSET=latin1;

Create table retail_suplai(
	id_pemasok varchar(10) not null,
	kode_bahan varchar(10) not null,
	tgl_pemasok datetime(6),
	foreign key(id_pemasok) references pemasok(id_pemasok),
	foreign key(kode_bahan) references bahan_makanan(kode_bahan)
)
ENGINE=Innodb default CHARSET=latin1;

Create table staff_dapur(
	id_staff varchar(10) not null,
	nama varchar(100),
	alamat varchar(100),
	jenis_kelamin varchar(10),
	primary key(id_staff)
)
ENGINE=Innodb default CHARSET=latin1;

Create table retail_diolah(
	id_pesanan varchar(10) not null,
	id_staff varchar(10) not null,
	foreign key(id_pesanan) references nota_pesanan(id_pesanan),
	foreign key(id_staff) references staff_dapur(id_staff)
)
ENGINE=Innodb default CHARSET=latin1;
