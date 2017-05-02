<?php
	$namacust = $_POST["namacust"];
	$email = $_POST["email"];
	$notelp = $_POST["notelp"];
	$tanggal = date("Y-m-d");
	$barang_pilih = "";
	$qty = 1;
	
	$data_valid = "YA";
	if (strlen(trim($namacust)) == 0)
	{	echo "Nama Harus Diisi! <br />";
		$data_valid = "TIDAK";
	}
	
	if (strlen(trim($notelp)) == 0)
	{	echo "No. Telp Harus Diisi! <br />";
		$data_valid = "TIDAK";
	}
	
	if (isset($_COOKIE["keranjang"]))
	{	$barang_pilih = $_COOKIE["keranjang"];
	}
	else
	{	echo "Keranjang Belanja Kosong <br />";
		$data_valid = "TIDAK";
	}
	
	if ($data_valid == "TIDAK")
	{	echo "masih ada kesalahan, silahkan perbaiki! <br />";
		echo "<input type='button' value='Kembali' onClick='self.history.back()'>";
		exit;
	}

	include "koneksi.php";

	$simpan = true;
	//$mulai_transaksi = mysqli_begin_transaction($kon); hanya bisa dilaptop	
	$mulai_transaksi = "start transaction";
	mysqli_query($kon, $mulai_transaksi);

	$sql = "insert into hjual(tanggal, namacust, email, notelp)
			values('$tanggal','$namacust','$email','$notelp')";
	$hasil = mysqli_query($kon, $sql);
	if(!$hasil)
	{	echo "Data Customer Gagal Simpan <br />";
		$simpan = false;
	}
	
	$idhjual = mysqli_insert_id($kon);
	if($idhjual == 0)
	{	echo "Data Customer Tidak Ada <br />";
		$simpan = false;
	}

	$barang_array = explode(",",$barang_pilih);
	$jumlah = count($barang_array);
	
	if($jumlah <= 1)
	{	echo "Tidak Ada Yang Dipilih<br />";
		$simpan = false;
	}
	else
	{	foreach ($barang_array as $id_barang)
		{	if($id_barang == 0)
			{	continue;
			}

			$sql = "select * from barang where id_barang = $id_barang";
			$hasil = mysqli_query($kon, $sql);
			if(!$hasil)
			{	echo "Barang Tidak Ada <br />";
				$simpan = false;
				break;
			}
			else
			{	$row = mysqli_fetch_assoc($hasil);
				$stok = $row["stok"] - 1;
				if($stok < 0)
				{	echo "Stok Barang ".$row['stok']." Kosong <br />";
					$simpan = false;
					break;
				}
				$harga = $row["harga"]; 
			}

			$sql = "insert into djual(idhjual, id_barang, qty, harga)
					values('$idhjual','$id_barang','$qty','$harga')";
			$hasil = mysqli_query($kon, $sql);
			if(!$hasil)
			{	echo "Detail Jual Gagal Simpan <br />";
				$simpan = false;
				break;
			}

			$sql = "update barang set stok = $stok
					where id_barang = $id_barang";
			$hasil = mysqli_query($kon, $sql);
			if(!$hasil)
			{	echo "Update Stok Barang Gagal <br />";
				$simpan = false;
				break;
			}
		}
	}

	if($simpan)
	{	$komit = mysqli_commit($kon);
	}
	else
	{	$rollback = mysqli_rollback($kon);
		echo "Pembelian Gagal <br />";
		echo "<input type='button' value='Kembali' onClick='self.history.back()'>";
		exit;
	}

	header("location: bukti_beli.php?idhjual=$idhjual");	
	setcookie("keranjang",$barang_pilih,time()-3600);
?>