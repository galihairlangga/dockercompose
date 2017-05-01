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
?>
<h2>.:: BARANG EDIT ::.</h2>
<form action='barang_simpan.php' method='post' enctype='multipart/form-data'>
<input type="hidden" name="id_barang" value="<?php echo $id_barang; ?>" />
<table border='1'>
	<tr>
		<td>Nama Barang</td>
		<td><input type='text' name='nama' value="<?php echo $nama; ?>" /></td>
	</tr>
	<tr>
		<td>Harga Jual</td>
		<td><input type='text' name='harga' value="<?php echo $harga; ?>" /></td>
	</tr>
	<tr>
		<td>Stok</td>
		<td><input type='text' name='stok' value="<?php echo $stok; ?>" /></td>
	</tr>
	<tr>
		<td>Gambar [max = 1.5 MB]</td>
		<td>
			<input type='file' name='foto' />
			<input type="hidden" name="foto_lama" value="<?php echo $foto; ?>" /><br />
			<img src="<?php echo "thumb/t_".$foto; ?>" width="100" />
		</td>
	</tr>
	<tr>
		<td colspan='2'>
			<input type='submit' value='Simpan' name='proses' />
			<input type='reset' value='Reset' name='reset' />
		</td>
	</tr>
</table>
</form>

<?php include_once("template_bawah.php"); ?>