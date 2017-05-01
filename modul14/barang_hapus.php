<?php include_once("template_atas.php"); ?>

<?php
	include "koneksi.php";
	$id_barang = $_GET["id_barang"];
	$sql = "select * from barang where id_barang = '$id_barang'";
	$hasil = mysqli_query($kon,$sql);
	if(!$hasil) die ("Gagal Query...");
	
	$data = mysqli_fetch_array($hasil);
	$nama = $data["nama"];
	$harga = $data["harga"];
	$stok = $data["stok"];
	$foto = $data["foto"];
	
	echo "<h2>KONFIRMASI HAPUS</h2>
		  Nama Barang : $nama <br/>
		  Harga Barang : $harga <br />
		  Stok : $stok <br />
		  Foto : <img src='thumb/t_".$foto."' /> <br /><br />
		  APAKAH DATA INI AKAN DI HAPUS ? <br />
		  <a href='barang_hapus.php?id_barang=$id_barang&hapus=1'>YA</a>
		  &nbsp; &nbsp;
		  <a href='barang_tampil.php'>TIDAK</a>";
		  
	if(isset($_GET['hapus']))
	{	$sql = "delete from barang where id_barang = '$id_barang'";
		$hasil = mysqli_query($kon, $sql);
		if(!$hasil)
		{	echo "Gagal Hapus Barang : $nama .. <br />
				  <a href='barang_tampil.php'>Kembali ke Daftar Barang</a>";
		}
		else
		{	$gbr = "pict/$foto";
			if(file_exists($gbr)) unlink($gbr);
			$gbr = "thumb/t_$foto";
			if(file_exists($gbr)) unlink($gbr);
			header('location:barang_tampil.php');
		}
	}
?>

<?php include_once("template_bawah.php"); ?>