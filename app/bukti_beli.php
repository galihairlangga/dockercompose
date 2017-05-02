<style type="text/css">
	@media print{
		#tombol{
			display: none;
		}
	}
</style>
<div id="tombol">
	<input type="button" value="Beli Lagi" onclick="window.location.assign('barang_tersedia.php')" />
	<input type="button" value="Print" onclick="window.print()" />
</div>
<?php
	$idhjual = $_GET["idhjual"];
	include "koneksi.php";
	$sqlhjual = "select * from hjual where idhjual = $idhjual";
	$hasilhjual = mysqli_query($kon, $sqlhjual);
	$rowhjual = mysqli_fetch_assoc($hasilhjual);

	echo "<pre>
		  <h2>BUKTI PEMBELIAN</h2>
		  NO. NOTA : ".date("Ymd").$rowhjual['idhjual']."<br />
		  Tanggal  : ".$rowhjual['tanggal']."<br />
		  Nama     : ".$rowhjual['namacust']."<br /><br />";
	$sqldjual = "select barang.nama, djual.harga, djual.qty,
				 (djual.harga * djual.qty) as jumlah
				 from djual inner join barang on 
				 djual.id_barang = barang.id_barang where
				 djual.idhjual = $idhjual";
	$hasildjual = mysqli_query($kon, $sqldjual);
	echo "<table border='1' cellpadding='10' cellspacing='0'>
			<tr>
				<th>Nama Barang</th>
				<th>Quantity</th>
				<th>Harga</th>
				<th>Jumlah</th>
			</tr>";
	$totalharga = 0;
	while($rowdjual = mysqli_fetch_assoc($hasildjual))
	{	echo "<tr>
				<td>".$rowdjual['nama']."</td>
				<td align='right'>".$rowdjual['qty']."</td>
				<td align='right'>".$rowdjual['harga']."</td>
				<td align='right'>".$rowdjual['jumlah']."</td>
			  </tr>";
		$totalharga = $totalharga + $rowdjual['jumlah'];
	}
	echo   "<tr>
				<td colspan='3' align='right'>
					<strong>Total Jumlah</strong>
				</td>
				<td align='right'>
					<strong>$totalharga</strong>
				</td>
			</tr>
		 </table>
		 </pre>";
?>