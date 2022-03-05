<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
@page { margin: 0px; }
body { margin: 6px;  }

table{
font-size: 10px;
width: 100%;
empty-cells: 0px;
}
	</style>
</head>
<body>
<table>  
	<tr>
		<td colspan="3" align="">
			APOTEK AL-RAZAAK <br>
			Genteng - Banyuwangi <br>
			081252899024 <br>
			-------------------------------------------------- <br>
	     </td>
	</tr>
	<tr>
		<td width="20%">Tanggal</td>
		<td width="5%">:</td>
		<td width="75%">{{ $tgl }}</td>
	</tr>
	<tr>
		<td>Nota</td>
		<td>:</td>
		<td>{{ $no_faktur }}</td>
	</tr>
	<tr>
		<td>Kasir</td>
		<td>:</td>
		<td>{{ $kasir }}</td>
	</tr>
	<tr>
		<td colspan="3">--------------------------------------------------</td>
	</tr>
</table>



<table border="0">
	<?php foreach ($detail as $key => $value) : ?>
	<tr>
		<td colspan="3">{{ $value->barang->nama}}</td>
	</tr>
	<tr>
		<td width="33%">{{ number_format($value->jumlah,0,".",".") }} {{ $value->barang->satuan }}</td>
		<td width="33%">{{ number_format($value->harga_jual,0,".",".") }} </td>
		<td width="33%" align="right">{{ number_format($value->harga_jual*$value->jumlah,0,".",".") }}</td>
	</tr>
	<tr>
		<td colspan="3">--------------------------------------------------</td>
	</tr>
<?php endforeach; ?>
</table>

<table border="0">
	<tr>
		<td width="20%">Total</td>
		<td width="80%" align="right">{{  number_format($total,0,".",".") }}</td>
	</tr>
	<tr>
		<td>Tunai</td>
		<td align="right">{{  number_format($bayar,0,".",".") }}</td>
	</tr>
	<tr>
		<td>Kembali </td>
		<td align="right">&nbsp;&nbsp; {{  number_format($kembalian,0,".",".") }}</td>
	</tr>
	<tr>
		<td colspan="3">--------------------------------------------------</td>
	</tr>
</table>

<?php if($penjualan->catatan != null) : ?>
<table>
<tr>
	<td colspan="3" align="center">
		Catatan <br>
		{{ $penjualan->catatan }} <br>
		-------------------------------------------------- <br>
     </td>
</tr>
</table>
<?php endif; ?>


<?php if ($penjualan->member != null) :?>
<table>
<tr>
	<td colspan="3" align="center">
		Member : {{ $nama_member }} <br>
		-------------------------------------------------- <br>
     </td>
</tr>
</table>
<?php endif; ?>
<table>
<tr>
	<td colspan="3" align="">
		Terima Kasih Telah Berbelanja <br>
		-------------------------------------------------- <br>
		** Barang Yang Sudah Dibeli ** <br>
		** Tidak Dapat Dikembalikan ** <br>
		---------- TERIMA KASIH ---------
     </td>
</tr>
</table>
</body>
</html>