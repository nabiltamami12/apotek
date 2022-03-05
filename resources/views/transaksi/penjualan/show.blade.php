@extends('layouts.master')

@section('title_name')
    Detail Transaksi Penjualan
@endsection

@section('active_page')
    <li>Transaksi</li>
    <li>Penjualan</li>
    <li class="active">Lihat Detail</li>
@endsection

@section('content')
<section class="content">
        <div class="row">
             
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Detail Penjualan Barang</h3>
                    </div>
                    <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            {!!  Form::hidden('kode', $penjualan->kode, ['id'=>'kode', 'class' => 'form-control'])  !!}
                            <div class="form-group">
                                {!! Form::label('kode', 'No. Bukti : ') !!} {{ $penjualan->kode }}
                            </div> 
                            <div class="form-group">
                                {!! Form::label('tgl', 'Waktu. Transaksi : ' ) !!} {{ $penjualan->tgl->format('d-m-Y H:i:s') }}
                            </div>
                            <div class="form-group">
                                {!! Form::label('user', 'Operator : ') !!} {{ $penjualan->user->fullname }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('kodemember', 'Member : ') !!} {{  ($penjualan->member != null ? $penjualan->member->kode : '-') }}
                            </div> 
                            <div class="form-group">
                                {!! Form::label('namamember', 'Nama Member : ' ) !!} {{ ($penjualan->member != null ? $penjualan->member->nama : '-') }}
                            </div>
                            <div class="form-group">
                                {!! Form::label('catatan', 'Catatan : ') !!} {{ $penjualan->catatan }}
                            </div>
                        </div>
                    </div>

                       
                        

                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTableBuilder">
                                <thead>
                                <tr>
                                    <th class="col-md-2">Kode</th>
                                    <th class="col-md-2">Nama</th>
                                    <th class="col-md-2">Jenis</th>
                                    <th class="col-md-2">Harga</th>
                                    <th class="col-md-1">QTY</th>
                                    <th class="col-md-2">Sub Total</th>
                                </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th colspan="6" style="text-align:right; font-size:22px; color: #9d1500;">Rp 0</th>
                                    </tr>
                                    </tfoot>
                                <tbody>

                                </tbody>
                            </table>
                        
                        
                    </div>
                    <div class="box-footer">
                            <a href="/penjualan" class="btn btn-primary btn-flat"><i class="fa fa-arrow-left"></i> Kembali</a>
                        </div>
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
@endsection

@section('custom_style')
        <!-- DataTables -->
   <link href="/plugins/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="/plugins/datatables-responsive/dataTables.responsive.css" rel="stylesheet">
@endsection

@section('custom_script')
    <script src="/plugins/datatables/js/jquery.dataTables.min.js"></script>
    <script src="/plugins/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="/plugins/datatables-responsive/dataTables.responsive.js"></script>
@endsection

@section('custom_script_footer')
    <script src="/js/transaksi/penjualan/show.js"></script>
@endsection


