<!DOCTYPE html>
<html lang="in">
<head>
    <meta charset="utf-8">

    <title>Laporan Konsinyasi Suplier</title>
</head>

<body>

<style type="text/css">

    .tg  {border-collapse:collapse;border-spacing:0;border-color:#ccc;width: 100%; }
    .tg td{font-family:Arial;font-size:12px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#ccc;color:#333;background-color:#fff;}
    .tg th{font-family:Arial;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#ccc;color:#333;background-color:#f0f0f0;}
    .tg .tg-3wr7{font-weight:bold;font-size:12px;font-family:"Arial", Helvetica, sans-serif !important;;text-align:center}
    .tg .tg-ti5e{font-size:10px;font-family:"Arial", Helvetica, sans-serif !important;;text-align:center}
    .tg .tg-rv4w{font-size:11px;font-family:"Arial", Helvetica, sans-serif !important;}

    body {
        font-family: sans-serif;
        font-size: 10pt;
        margin: 0.5cm 0;
        text-align: justify;
    }

    #title {
        width: 100%;
        text-align: center;
        margin-top: 0px;
        padding: 0px;
    }
    #title .title-header {
        text-align: center;
        margin-top: 0px;
        font-weight: bold;
        font-size: 12pt;
    }
    #title .title-header-alamat {
        text-align: center;
        margin-top: 0px;
        font-weight: normal;
        font-size: 11pt;
        font-style: italic;
    }

    #title .title-header-2 {
        text-align: center;
        margin-top: 0px;
        font-weight: bold;
        font-size: 13pt;
    }
    #title .title-header-3 {
        text-align: center;
        margin-top: 0px;
        font-weight: bold;
        font-size: 20px;
    }
    #title .title-header-4 {
        text-align: center;
        margin-top: 0px;
        font-weight: normal;
        font-size: 10px;
        font-style: italic;
    }

    #header .judul_laporan {
        text-align: center;
        margin-top: 0px;
        font-weight: bold;
        font-size: 18px;
    }
    #header .subjudul_laporan {
        text-align: center;
        margin-top: 0px;
        font-weight: bold;
        font-size: 12px;
    }

    #footer {
        position: fixed;
        left: 0;
        right: 0;
        color: #aaa;
        font-size: 0.9em;
    }

    #footer {
        bottom: 0;
        border-top: 0.1pt solid #aaa;
    }

    #footer table {
        width: 100%;
        border-collapse: collapse;
        border: none;
    }

    #footer td {
        padding: 0;
        width: 50%;
    }

    .page-number {
        text-align: right;
    }

    .page-number:before {
        content: "Halaman " counter(page);
    }

    hr {
        page-break-after: always;
        border: 0;
    }

    .garis-dua {
        border-top: 0.1pt solid #aaa;
    }
    .garis-satu {
        border-top: 3pt solid #000;
    }

    .logo-img {
        top: 12px;
    }

</style>

<div id="title">
    <table width="100%" cellpadding="0">
        <tr>
            <td class="title-header-3">HEDON ART SHOP</td>
        </tr>
        <tr>
            <td class="title-header-alamat">Jl. Gajah Mada, Lingkungan Mojoroto R, Mojopanggung, No.23 Kec. Giri, <br> Kabupaten Banyuwangi, Jawa Timur 68422</td>
        </tr>
    </table>

    <table width="100%" style="margin-top: 10px">
        <tr>
            <td class="garis-satu"></td>
        </tr>
        <tr>
            <td class="garis-dua"></td>
        </tr>
    </table>
</div>

<div id="header">
    <table width="100%" style="margin-top: 10px">
        <tr>
            <td class="judul_laporan">LAPORAN PENJUALAN BARANG KONSINYASI</td>
        </tr>
        <tr>
            <td class="subjudul_laporan">Per Periode : {{ date('d/m/Y') }}</td>
        </tr>
    </table>
</div>

<table width="100%" style="margin-top: 10px">
        <tr>
            <td align="left" valign="top">Mata Uang</td><td align="left" valign="top">:</td><td align="left" valign="top">Rupiah</td>
        </tr>
		<tr>
            <td align="left" valign="top">Periode</td><td align="left" valign="top">:</td><td align="left" valign="top">{{$from}} s/d {{$to}}</td>
        </tr>
		<tr>
            <td align="left" valign="top">Supplier</td><td align="left" valign="top">:</td><td align="left" valign="top">{{$suplier->nama}} <br> {{$suplier->telp}}</td>
        </tr>
		<tr>
            <td align="left" valign="top">Rekening Bank</td><td align="left" valign="top">:</td><td align="left" valign="top">{{$suplier->bank}} <br> {{$suplier->norek}} a.n. {{$suplier->bank_pemilik}}</td>
        </tr>
    </table>

<div id="footer">
    <table>
        <tr>
            <td>Aplikasi Manajemen Penjualan Artshop Hedon</td>
            <td style="text-align: right;" class="page-number"></td>
        </tr>
    </table>
</div>

<table id="dataTableBuilder" class="table table-striped table-bordered table-hover display select tg"
       cellspacing="0" width="100%" border="1" style="margin-top: 10px;">
    <thead>
    <tr>
        <th style="width: 2%;" class="tg-3wr7"><strong>#</strong></th>
        <th style="width:3%;" class="tg-3wr7"><strong>Kode</strong></th>
        <th style="width:10%;"><strong class="tg-3wr7">Nama</strong></th>
        <th style="width:5%;"><strong class="tg-3wr7">Qty-In</strong></th>
        <th style="width:5%;"><strong class="tg-3wr7">Qty-Out</strong></th>
        <!--<th style="width:5%;"><strong class="tg-3wr7">Return</strong></th>-->
        <th style="width:5%;"><strong class="tg-3wr7">Stok</strong></th>
        <th style="width:10%;"><strong class="tg-3wr7">HPP</strong></th>
        <th style="width:10%;"><strong class="tg-3wr7">Total HPP</strong></th>
    </tr>
    </thead>
    <tbody>
	<?php 
		$G_hpp=0;
		$G_Thpp=0;
		$G_hj=0;
		$G_omset=0;
		$G_lk=0;		
	?>
    @foreach($konsinyasi as $i => $value)
		<?php 
			if($value->penjualandetail->count() > 0){				
				$totalhpp = $value->hpp * $value->penjualandetail[0]->qty_out;
				$omset = $value->harga_jual_1 * $value->penjualandetail[0]->qty_out;
				$labakotor=$omset - $totalhpp;
			}
			else{
				$totalhpp = 0;
				$omset = 0;
				$labakotor=0;
			}
			
		?>
        <tr>
            <td style="width:5%; text-align: center;" class="tg-rv4w">{{ $i+1 }}</td>
            <td style="width:15%; text-align: center;" class="tg-rv4w">{{ $value->barcode }}</td>
            <td style="width:20%; class="tg-rv4w">{{ $value->nama }}</td>
            <td style="width:5%;">
				@if($value->pembeliandetail->count() > 0)
					@if($value->stok_awal->count() > 0)
						{{$value->stok_awal[0]->awal + $value->pembeliandetail[0]->qty_in}}
					@else
						@if($value->stok_awal_tdk_transaksi->count() > 0)
							{{$value->stok_awal_tdk_transaksi[0]->stok+ $value->pembeliandetail[0]->qty_in}} 
						@else
							{{$value->pembeliandetail[0]->qty_in}} 
						@endif
					@endif
				@else
					@if($value->stok_awal->count() > 0)
						{{$value->stok_awal[0]->awal}}
					@else
						@if($value->stok_awal_tdk_transaksi->count() > 0)
							{{$value->stok_awal_tdk_transaksi[0]->stok}}
						@else
							0
						@endif
					@endif					
				@endif
			</td>
            <td style="width:5%;">
				@if($value->penjualandetail->count() == 0)
					0
				@else
					{{$value->penjualandetail[0]->qty_out}}
				@endif
			</td>
            <!--<td style="width:5%; text-align: center;" class="tg-rv4w">0</td>-->
            <td style="width:5%; text-align: center;" class="tg-rv4w">
				@if($value->history->count() > 0)
					{{$value->history[0]->stok}}
				@else					
					@if($value->stok_awal_tdk_transaksi->count() > 0)
						{{$value->stok_awal_tdk_transaksi[0]->stok}}
					@else
						0
					@endif
				@endif
			</td><td style="width:5%;">{{ number_format($value->hpp, 0, ',', '.') }}</td>
            <td style="width:5%;">{{ number_format($totalhpp, 0, ',', '.') }}</td>
        </tr>
		<?php 
			$G_hpp=$G_hpp+$value->hpp;
			$G_Thpp=$G_Thpp+$totalhpp;
			$G_hj=$G_hj+$value->harga_jual_1;
			$G_omset=$G_omset+$omset;
			$G_lk=$G_lk+$labakotor;		
		?>
    @endforeach
		<tr>
            <td colspan="6"></td>
            <td class="tg-rv4w"><strong class="tg-3wr7">-</strong></td>
            <td class="tg-rv4w"><strong class="tg-3wr7">{{ number_format($G_Thpp, 0, ',', '.') }}</strong></td>
        </tr>

    </tbody>
</table>

</body>
</html>