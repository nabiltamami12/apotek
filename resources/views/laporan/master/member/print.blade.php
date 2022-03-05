<!DOCTYPE html>
<html lang="in">
<head>
    <meta charset="utf-8">

    <title>Laporan Daftar Member</title>
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
            <td class="title-header-3">{{ env('TOKO_NAMA') }}</td>
        </tr>
        <tr>
            <td class="title-header-alamat">{{ env('TOKO_ALAMAT').' '.env('TOKO_TELP', '').' '.env('TOKO_HP', '') }}</td>
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
            <td class="judul_laporan">LAPORAN DAFTAR MEMBER</td>
        </tr>
        <tr>
            <td class="subjudul_laporan">Per Periode : {{ date('d/m/Y') }}</td>
        </tr>
    </table>
</div>

<div id="footer">
    <table>
        <tr>
            <td>Aplikasi Manajemen Penjualan</td>
            <td style="text-align: right;" class="page-number"></td>
        </tr>
    </table>
</div>

<table id="dataTableBuilder" class="table table-striped table-bordered table-hover display select tg"
       cellspacing="0" width="100%" border="1" style="margin-top: 10px;">
    <thead>
    <tr>
        <th style="width: 5%;" class="tg-3wr7"><strong>#</strong></th>
        <th style="width:15%;" class="tg-3wr7"><strong>Kode</strong></th>
        <th><strong class="tg-3wr7">Nama</strong></th>
        <th style="width: 8%;" class="tg-3wr7"><strong>Level</strong></th>
        <th style="width: 15%;" class="tg-3wr7"><strong>No. HP</strong></th>
        <th class="tg-3wr7"><strong>Alamat</strong></th>
    </tr>
    </thead>
    <tbody>
    @foreach($member as $i => $value)
        <tr>
            <td style="width: 5%; text-align: center;" class="tg-rv4w">{{ $i+1 }}</td>
            <td style="width:15%; text-align: center;" class="tg-rv4w">{{ $value->kode }}</td>
            <td class="tg-rv4w">{{ $value->nama }}</td>
            <td style="width: 8%;text-align: center;" class="tg-rv4w">{{ $value->level }}</td>
            <td style="width: 15%;text-align: center;" class="tg-rv4w">{{ $value->gsm }}</td>
            <td class="tg-rv4w">{{ $value->alamat }}</td>
        </tr>
    @endforeach

    </tbody>
</table>

</body>
</html>