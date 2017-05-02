<?php include_once("template_atas.php"); ?>

<?php
	$nama_barang = "";
	if (isset($_POST["nama_barang"]))
	{	$nama_barang = $_POST["nama_barang"];
	}
	include "koneksi.php";
	$sql = "select * from barang where nama like '%".$nama_barang."%'
			order by id_barang desc";
	$hasil = mysqli_query($kon, $sql);
	if (!$hasil)
	{	die ("Gagal query ..".mysqli_error($kon));
	}
?>
<a href="barang_isi.php">INPUT BARANG</a>
&nbsp; &nbsp; &nbsp;
<a href="barang_cari.php">CARI BARANG</a>
<table border="1">
	<tr>
		<th>Foto</th>
		<th>Nama Barang</th>
		<th>Harga Jual</th>
		<th>Stok</th>
		<th>Operasi</th>
	</tr>
	<?php
		$no = 0;
		while ($row = mysqli_fetch_assoc($hasil))
		{	echo "<tr>
					<td>
						<a href='pict/$row[foto]'>
						<img src='thumb/t_$row[foto]' width='100' />
						</a>
					</td>
					<td>$row[nama]</td>
					<td>$row[harga]</td>
					<td>$row[stok]</td>
					<td>
						<a href='barang_edit.php?id_barang=$row[id_barang]'>EDIT</a>
						&nbsp; &nbsp;
						<a href='barang_hapus.php?id_barang=$row[id_barang]'>HAPUS</a>
					</td>
				  </tr>";
		}
	?>
</table>

<?php include_once("template_bawah.php"); ?>