<?php
	error_reporting(E_ALL ^ E_DEPRECATED);
	$host = "localhost";
	$user = "root";
	$pass = "";
	$dbname = "toko_ol";
	
	$kon = mysqli_connect($host, $user, $pass);
	if (!$kon)
		die ("Gagal Koneksi...");
		
	$hasil = mysqli_select_db($kon, $dbname);
	if (!$hasil)
	{	$hasil = mysqli_query($kon, "create database $dbname"); 
		if (!$hasil)
			die ("Gagal Buat Database");
		else
			$hasil = mysqli_select_db($kon, $dbname);
			if (!$hasil) die ("Gagal Konek Database");
	}

	$sql_tabel_barang = "create table if not exists barang (
						 id_barang int auto_increment not null primary key,
						 nama varchar(40) not null,
						 harga int not null default 0,
						 stok int not null default 0,
						 foto varchar(70) not null default '',
						 key(nama) )engine=innodb";
	mysqli_query($kon, $sql_tabel_barang) or die ("Gagal Buat Tabel Barang");
	
	$sql_tabel_Hjual = "create table if not exists hjual(
						idhjual int auto_increment not null primary key,
						tanggal date not null,
						namacust varchar(40) not null,
						email varchar(40) not null default '',
						notelp varchar(40) not null default '')engine=innodb";
	mysqli_query($kon, $sql_tabel_Hjual) or die ("Gagal Buat Tabel Header Jual");
	
	$sql_tabel_Djual = "create table if not exists djual(
						iddjual int auto_increment not null primary key,
						idhjual int not null,
						id_barang int not null,
						qty int not null,
						harga int not null,
						foreign key(idhjual) references hjual(idhjual) on update cascade on delete cascade,
						foreign key(id_barang) references barang(id_barang) on update cascade on delete cascade)";
	mysqli_query($kon, $sql_tabel_Djual) or die ("Gagal Buat Tabel Detail Jual");
	
	$sql_tabel_user = "create table if not exists pengguna(
					   idpengguna int auto_increment not null primary key,
					   user varchar(25) not null,
					   password varchar(50) not null,
					   nama_lengkap varchar(50) not null,
					   akses varchar(10) not null)";
	mysqli_query($kon, $sql_tabel_user) or die ("Gagal Buat Tabel Pengguna");
	
	$sql = "select * from pengguna";
	$hasil = mysqli_query($kon,$sql);
	$jumlah = mysqli_num_rows($hasil);
	if($jumlah == 0)
	{	$sql = "insert into pengguna(user,password,nama_lengkap,akses) values
				('admin',md5('admin'),'administrator','toko'),
				('cust',md5('cust'),'pelanggan','beli')";
		mysqli_query($kon, $sql);
	}
?>