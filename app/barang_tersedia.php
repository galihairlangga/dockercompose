<?php include_once("template_atas.php"); ?>

<?php
	$barang_pilih = 0;
	if (isset($_COOKIE["keranjang"]))
	{	$barang_pilih = $_COOKIE["keranjang"];
	}
	if (isset($_GET["id_barang"]))
	{	$id_barang = $_GET["id_barang"];
		$barang_pilih = $barang_pilih ."," . $id_barang;
		setcookie("keranjang",$barang_pilih,time()+3600);
	}
	include "koneksi.php";
	$sql = "select * from barang where id_barang not in($barang_pilih)
			and stok > 0 order by id_barang desc";
	$hasil = mysqli_query($kon, $sql);
	if (!$hasil)
	{	die ("Gagal query ..".mysqli_error($kon));
	}
?>
<h2>DAFTAR BARANG TERSEDIA</h2>
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
						<a href='$_SERVER[PHP_SELF]?id_barang=$row[id_barang]'>BELI</a>
					</td>
				  </tr>";
		}
	?>
</table>

<?php include_once("template_bawah.php"); ?>